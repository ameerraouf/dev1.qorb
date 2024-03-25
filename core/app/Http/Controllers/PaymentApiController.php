<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Payment\BasePaymentService;

class PaymentApiController extends Controller
{
    // use ImageSaveTrait, General, SendNotification;
    protected $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function paymentNotifier(Request $request, $id)
    {
        $payment_id = $request->input('paymentId', '-1');
        $payer_id = $request->input('PayerID', '-1');
        $im_payment_id = $request->input('payment_id', '-1');
        $this->logger->log('Payment Start', '==========');
        $this->logger->log('Payment paymentId', $payment_id);
        $this->logger->log('Payment PayerID', $payer_id);
         $order = Order::where(['uuid' => $id, 'payment_status' => 'due'])->first();
         if (is_null($order)) {
            return redirect()->action('HomeController@HomePage')->with('errorMessage', (__('backend.PaymentErrorMessage')));
         }

        Log::info($order);

        $this->logger->log('Payment verify request : ', json_encode($request->all()));

        $payment_id = $order->payment_id;
        $data = ['id' => $order->uuid, 'payment_method' =>$order->payment_method, 'currency' => $order->payment_currency];
        $getWay = new BasePaymentService($data);
        if ($payer_id != '-1') {
             $payment_data = $getWay->paymentConfirmation($payment_id, $payer_id);
         } else {
             $payment_data = $getWay->paymentConfirmation($payment_id);
        }

        $this->logger->log('Payment done for order', json_encode($order));
        $this->logger->log('Payment details', json_encode($payment_data));

        if ($payment_data['success']) {
            var_dump($payment_data['data']['payment_status'] == 'success');
            if ($payment_data['data']['payment_status'] == 'success') {
                DB::beginTransaction();
                try {
                    $order->payment_status = 'paid';
                    $order->payment_method = $payment_data['data']['payment_method'];
                    $order->save();
                    $this->logger->log('status', 'paid');

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->logger->log('End with Exception', $e->getMessage());
                }
                return redirect()->action('HomeController@HomePage')->with('doneMessage', (__('backend.PaymentSuccessMessage')));

            }
        }else {
            return redirect()->action('HomeController@HomePage')->with('errorMessage', (__('backend.PaymentErrorMessage')));
        }

    }

    public function paymentCancel(Request $request){
        return redirect()->action('HomeController@HomePage')->with('errorMessage', (__('backend.PaymentErrorMessage')));
    }
}
