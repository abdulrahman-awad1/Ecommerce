<?php

namespace App\services;

use GuzzleHttp\Client;

class currencyConvener
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CURRENCY_API_KEY'); // أخذ الـ API Key من .env
    }

    // دالة لتحويل المبالغ بين العملات
    public function convert($fromCurrency, $toCurrency, $amount)
    {
        try {
            // إرسال طلب API للحصول على أسعار الصرف
            $response = $this->client->get("https://v6.exchangerate-api.com/v6/{$this->apiKey}/latest/{$fromCurrency}");

            $data = json_decode($response->getBody()->getContents(), true);

            if ($data['result'] !== 'success') {
                throw new \Exception('Error fetching currency data');
            }

            // استخراج سعر الصرف
            $exchangeRate = $data['conversion_rates'][$toCurrency];

            // تحويل المبلغ
            $convertedAmount = $amount * $exchangeRate;

            return $convertedAmount;
        } catch (\Exception $e) {
            // التعامل مع الأخطاء
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
