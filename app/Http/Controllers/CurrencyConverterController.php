<?php

namespace App\Http\Controllers;

use App\services\currencyConvener;
use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    protected $currencyConverterService;

    public function __construct(currencyConvener $currencyConverterService)
    {
        $this->currencyConverterService = $currencyConverterService;
    }

    // دالة لتحويل العملات
    public function convert(Request $request)
    {
        $request->validate([
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $fromCurrency = $request->input('from_currency');
        $toCurrency = $request->input('to_currency');
        $amount = $request->input('amount');

        // استدعاء دالة التحويل من الخدمة
        $convertedAmount = $this->currencyConverterService->convert($fromCurrency, $toCurrency, $amount);

        return response()->json([
            'converted_amount' => $convertedAmount,
            'from_currency' => $fromCurrency,
            'to_currency' => $toCurrency,
            'amount' => $amount,
        ]);
    }
}
