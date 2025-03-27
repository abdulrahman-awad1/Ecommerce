<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     */
    //B دا ايفينت خاص بالاشعارات ف الداتا بيز
    public function handle(OrderCreated $event)
    {
        $order = $event->order;//x استدعيت الاوردر عشان هبعته ف النوتيفيكيشن
        $user = User::where('store_id',$order->store_id)->first();//c عشان نبعتله نوتيفيكيشن store_id  حددنا اليوزر ال ليه // x دا يعتب اليوزر ال شغال ف المحل
        $user->notify(new OrderCreatedNotification($order));//B دي خاصه لارسال الاشعارات  notify استدعينا ميثود
        //m واستدعينا اوبجيكت من النوتيفيكشين ال انشأناها ومررنا معاها تفاصيل الاوردر

        //v الحاله ال فوق دي عشان ابعت اشعار ليوزر واحد طب لو عندي اكتر من يوزر يعتبر شغالين ف نفس المحل وعايزين نبعتلهم كلهم اشعار ب الاوردر
        $users = User::where('store_id',$order->store_id)->get();
        Notification::send($users,new OrderCreatedNotification($order));
    }
}
