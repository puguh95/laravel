<?php

namespace App\API;

use Illuminate\Support\Facades\Http;

use Duitku\Api;
use Duitku\Config;
use Exception;

class DuitkuAPI
{
    private $config;

    public function __construct()
    {
        $this->config = new Config(
            config('duitku.api_key'),
            config('duitku.merchant_code'),
            config('duitku.sandbox'),
        );
    }

    public function getPaymentMethods($amount = 0)
    {
        try {
            $result = json_decode(Api::getPaymentMethod($amount, $this->config), true);

            if (!isset($result['responseCode']) || $result['responseCode'] != '00') return null;

            $list_method = array_values(array_filter($result['paymentFee'], function ($item) {
                return !in_array($item['paymentMethod'], ['DN', 'AT', 'VC', 'FT']);
            }));

            return $list_method;
        } catch (Exception) {
            return null;
        }
    }

    public function createInvoice($data)
    {
        try {
            $payload = array(
                'paymentAmount'     => $data['paymentAmount'],
                'paymentMethod'     => $data['paymentMethod'],
                'merchantOrderId'   => $data['merchantOrderId'],
                'productDetails'    => $data['productDetails'],
                'customerVaName'    => $data['customerVaName'],
                'email'             => $data['email'],
                'itemDetails'       => $data['itemDetails'],
                'callbackUrl'       => $data['callbackUrl'],
                'returnUrl'         => $data['returnUrl'],
                'expiryPeriod'      => 10,
            );

            $result = json_decode(Api::createInvoice($payload, $this->config), true);

            if (!isset($result['statusCode']) || $result['statusCode'] != '00') return null;

            return $result;
        } catch (Exception) {
            return null;
        }
    }

    public function transactionStatus($order_id)
    {


        try {
            $result = json_decode(Api::transactionStatus($order_id, $this->config), true);

            if (!isset($result['reference'])) return null;

            return $result;
        } catch (Exception) {
            return null;
        }
    }
}
