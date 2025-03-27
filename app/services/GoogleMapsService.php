<?php

namespace App\services;

use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
    // دالة للحصول على الإحداثيات بناءً على العنوان
    public function getCoordinates($address)
    {
        // إرسال طلب إلى Google Geocoding API
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,  // العنوان الذي نبحث عنه
            'key' => env('GOOGLE_API_KEY'),  // استخدام الـ API Key
        ]);

        // التحقق من الاستجابة
        if ($response->successful()) {
            // إرجاع البيانات كـ JSON
            return $response->json();
        }

        // في حالة فشل الطلب
        return null;
    }


}
