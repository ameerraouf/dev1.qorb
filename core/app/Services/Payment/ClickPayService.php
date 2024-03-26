<?php

namespace App\Services\Payment;
use App\Models\Package;

use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\PurchaseTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Events\Teacher\SubscribePackage;
use Clickpaysa\Laravel_package\Facades\paypage;

class ClickPayService extends BasePaymentService
{
    public $successUrl;
    public $cancelUrl;
    public $currency;
    public $package_id;
    public $sub_service_id;
    public $main_service_id;
    public $childrenIdsAsString;
    public $teacher_id;
    protected $test_mode;
    protected $server_key;
    protected $client_key;
    protected $gateway;
    public function __construct($object)
    {
        if (isset($object['id'])) {
            $this->cancelUrl = isset($object['cancelUrl ']) ? $object['cancelUrl '] : route('paymentCancel', $object['id']);
            $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
        }
        if(isset($object['package_id'])){
            $this->package_id = $object['package_id'] ?? $this->package_id;
            $this->sub_service_id = $object['sub_service_id'];
            $this->main_service_id = $object['main_service_id'];
            $this->childrenIdsAsString = $object['childrenIdsAsString'];
            $this->teacher_id = $object['teacher_id'];
        }
        $this->test_mode = env('CLICK_PAY_MODE');
        $this->server_key = env('CLICK_PAY_SERVER_KEY');
        $this->client_key = env('CLICK_PAY_CLIENT_KEY');
        $this->currency = $object['currency'];
    }
    public function makePayment($amount, $data= NULL)
    {
        try {

            $response = Http::withHeaders([
                'authorization' => $this->server_key,
                'content-type' => 'application/json',
            ])->post('https://secure.clickpay.com.sa/payment/request',[
                "customer_details" => [
                    "name"  => Auth::guard('teacher')->user()->name,
                    "email" => Auth::guard('teacher')->user()->email,
                    "phone" => Auth::guard('teacher')->user()->phone,
                ],
                'tran_type'     => 'sale',
                'tran_class'    => 'ecom',
                "profile_id" => 44713,
                "tran_type" => "sale",
                "tran_class" => "ecom" ,
                "cart_id" => Str::uuid(),
                "cart_description" => 'Cart Description',
                "cart_currency" => "SAR",
                "cart_amount" => $amount,
                "callback" => $this->cancelUrl,
                "return" => $this->successUrl,

            ]);
            return  $response;

        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id, $payer_id = null)
    {
        $response = Http::withHeaders([
            'authorization' => $this->server_key,
            'content-type' => 'application/json',
        ])->post('https://secure.clickpay.com.sa/payment/query',[
            "profile_id" => 44713,
            "tran_ref"   => $payment_id
        ]);

        $data['success'] = false;
        $data['data'] = null;
        $payment = $response;
        if ($payment['payment_result']['response_status'] == 'A' ) {
            Log::info($response);

            $data['success'] = true;
            $data['data']['amount'] = $payment['cart_amount'];
            $data['data']['currency'] = $payment['cart_currency'];
            $data['data']['payment_status'] =  'success' ;
            $data['data']['payment_method'] = 'clickpay';
            // Store in your local database that the transaction was paid successfully
        }
        return $data;
    }
}
