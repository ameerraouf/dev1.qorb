<?php

namespace App\Services\Payment;
use Illuminate\Support\Facades\Http;

use Clickpaysa\Laravel_package\Facades\paypage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClickPayService extends BasePaymentService
{
    public $successUrl;
    public $cancelUrl;
    public $currency;
    protected $test_mode;
    protected $server_key;
    protected $client_key;
    protected $gateway;

    public function __construct($object)
    {
        if (isset($object['id'])) {
            // $this->cancelUrl = isset($object['cancelUrl ']) ? $object['cancelUrl '] : route('paymentCancel', $object['id']);
            $this->cancelUrl = isset($object['cancelUrl ']);
            // $this->successUrl = isset($object['successUrl']) ? $object['successUrl'] : route('paymentNotify', $object['id']);
            $this->successUrl = isset($object['successUrl']);
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
                    "name"  => auth()->user()->name,
                    "email" => auth()->user()->email,
                    "phone" => auth()->user()->mobile_number,
                ],
                'tran_type'     => 'sale',
                'tran_class'    => 'ecom',
                "profile_id" => 42974,
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
            "profile_id" => 42974,
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
            $data['data']['payment_method'] = CLICKPAY;
            // Store in your local database that the transaction was paid successfully
        }

        return $data;
    }
}
