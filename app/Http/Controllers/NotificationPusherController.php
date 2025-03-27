<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationPusherController extends Controller
{
    public function sendNotification(Request $request)
    {

        // افترض أنك تحصل على ID المستخدم والرسالة من الطلب
        $userId = $request->input('user_id');
        $message = $request->input('message');

        // التحقق من وجود المستخدم
        $user = User::find($userId);
        if ($user) {
            // إرسال الحدث عبر Pusher
            event(new OrderCreated());
            return response()->json(['message' => 'Notification sent successfully!']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
