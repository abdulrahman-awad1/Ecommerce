<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;

class StripePaymentController extends Controller
{
    public function charge(Order $order, Request $request)
    {
        $amount = $order->items->sum(function ($item){
            return $item->price * $item->quantity;

        });
        Stripe::setApiKey(config('services.stripe.secret')); // قم بتعيين مفتاح Stripe السري

        try {
            // إنشاء Stripe Token باستخدام بيانات البطاقة
            $token = Token::create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);

            // استخدام هذا الـ token لإنشاء عملية الشحن
            $charge = Charge::create([
                'amount' => $request->amount * 100, // المبلغ بالـ سنت (على سبيل المثال 10.00 دولار = 1000 سنت)
                'currency' => 'usd', // العملة
                'description' => 'Payment for order',
                'source' => $token->id, // استخدام الـ token الذي تم إنشاؤه
            ]);
            $payment = Payment::create([
            //    'user_id' => auth()->id(), // ربط الدفع بالمستخدم الحالي
                'amount' => $request->amount,
                'currency' => 'usd',
                'status' => 'completed', // حالة الدفع (مثال: "completed")
               // 'payment_method' => 'card', // طريقة الدفع
                'transaction_id' => $charge->id, // معرّف الشحن من Stripe
             //   'transaction_name' => 'Payment for order',
            ]);

            return response()->json(['status' => 'success', $token]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
