<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {

        if (is_null($request->payment_method)) {
            $this->showToastrMessage('warning', __('Please Select Payment Method'));
            return redirect()->back();
        }

        if ($request->payment_method == 'clickpay') {
            if (!(env('CLICK_PAY_SERVER_KEY'))) {
                $this->showToastrMessage('error', __('Click Pay payment gateway is off!'));
                return redirect()->back();
            }
        }
        $order_data = $this->placeOrder($request->payment_method,$request->package_id,$request->package_price);
        if($order_data['status']){
            $order = $order_data['data'];
        }else{
            $this->showToastrMessage('error', __('Something went wrong!'));
            return redirect()->back();
        }
        /***********************************************************************  I Stopped Here **************************************************************/

        /** order billing address */

        // if (auth::user()->student) {
        //     $student = Student::find(auth::user()->student->id);
        //     $student->fill($request->all());
        //     $student->save();
        // }


        // Actions For Payment

        if ($request->payment_method == 'clickpay') {
            $object = [
                'id' => $order->uuid,
                'payment_method' => 'clickpay',
                'currency' => get_option('click_pay_currency')
            ];
            $total = $order->grand_total * (get_option('click_pay_conversion_rate') ? get_option('click_pay_conversion_rate') : 0);
            $total = number_format($total, 2,'.','');
            $getWay = new BasePaymentService($object);
            $responseData = $getWay->makePayment($total);

            if($responseData['redirect_url']){
                $order->payment_id = $responseData['tran_ref'];
                session()->put('payment_id', $order->payment_id);
                $order->save();
                return Redirect::away($responseData['redirect_url']);
            }else{
                $this->showToastrMessage('error', $responseData['message']);
                return redirect()->back();
            }
        }
    }

    private function placeOrder($payment_method,$package_id,$package_price)
    {
        DB::beginTransaction();
        try{
            $order = new Order();
            $order->package_id  = $package_id;
            $order->teacher_id  = Auth::guard('teacher')->user()->id;
            $order->order_number = rand(100000, 999999);
            $order->sub_total = 0+$package_price;
            $order->discount = 0;
            $order->platform_charge = 0;
            $order->shipping_cost = 0;
            $order->current_currency = 'SAR';
            $order->grand_total = $order->sub_total + $order->shipping_cost + $order->platform_charge;
            $order->payment_method = $payment_method;

            $payment_currency = '';
            $conversion_rate = '';

            // Check Payments Information

            if ($payment_method == 'clickpay') {
                $payment_currency = env('CLICK_PAY_CURRENCY');
                $conversion_rate = env('CLICK_PAY_CONVERSION_RATE') ? env('CLICK_PAY_CONVERSION_RATE') : 0;
            }

            // Set Order Info Oayment

            $order->payment_currency = $payment_currency;
            $order->conversion_rate = $conversion_rate;
            if ($conversion_rate) {
                $order->grand_total_with_conversation_rate = ($order->sub_total + $order->platform_charge + $order->shipping_cost) * $conversion_rate;
            }

            // Save Order
            $order->save();

            DB::commit();

            return ['status' => true,'data' => $order];

        }catch (\Exception $e){
            DB::rollBack();
            $this->logger->log('Cannot Create Order', $e->getMessage());
            return ['status' => false,'data' => null];
        }

    }
}
