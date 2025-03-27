<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationDataBaseController extends Controller
{
    public function sendNotification(Request $request)// v فانكشن لارسال الاشعارات فقط
    {
        $user = User::find(1); // تحديد المستخدم
       // $user->notify(new OrderCreatedNotification($));

        return response()->json(['message' => 'Notification sent successfully!']);
    }

    public function getNotifications(Request $request) //c فانكشن لاستقبال الاشعارات عند اليوزر
    {
        // الحصول على المستخدم من التوكن أو ID
        $user = Auth::user(); // تحديد المستخدم

        // استرجاع الإشعارات غير المقروءة
      //  $notifications = $user->notifications()->take(10)->get();
        $new_notification_count =$user->unreadNotifications()->count();

        $notifications = $user->notifications()->map(function ($notification) {
            return [

                'id' => $notification->id,
                'message' => $notification->data['message'],
                'created_at' => $notification->created_at->diffForHumans(), // تاريخ الإشعار
                'read_at' => $notification->read_at ? $notification->read_at->diffForHumans() : null, // تاريخ القراءة
            ];
        })->latest(10)->get();

        return response()->json($notifications,$new_notification_count);
    }
    public function unreadNotification(Request $request){
        $notification_id =$request->query('notification_id');
        if ($notification_id){
            $user = $request->user();
            if ($user){
                $notification=$user->unreadNotificatons()->find($notification_id);
                if ($notification){
                    $notification->markAsRead();
                }
            }
        }
        return response()->json(['unread_notifications' => $notification_id]);

    }
}
