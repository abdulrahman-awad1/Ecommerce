<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;
    public function __construct(Order $order) //m دي ممكن نمرر فيها متغير  //v يعني ممكن نمرر فيها الاوردر عشان لو عايزين نعرض بيانات الاوردر


    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $add = $this->order->billingAddress();
        return (new MailMessage)
                    ->subject('new order'.$this->order->number)//b  دا لارافيل بتضيف واحد تلقائي subject بتحط هنا عنوان للرساله ولو مضيفتش ال
                    ->from('e@commerce.com','ecommerce') //env لو مكتبتش السطر دا هياخد البيانات من ملف ال
                    ->greeting('hi'.$notifiable->name)//v دي رساله ترحيبيه
                    ->line('a new order created by '.$add->name)//line دا بيسمح بكتابة برجراف او رساله ف النتوفيكيشن
                    ->action('Notification Action', url('/'))//v اضغط عليه عشان يوجهني لصفحه تانيه button دا المفروض يبقي
                    ->line('Thank you for using our application!');
             //    ->view(''); دا عشان اختار شكل الملف ال هيتعرض فيه الرساله بس اصلا لارافيل ليها ديفولت تيمبليت لعرض الرساله
    }
    public function toDataBase( $notifiable)
    {
        $add = $this->order->billingAddress();
        return [ //json ف شكل data  هيتخزن ف تابل النوتيفيكيشن ف كولوم return  كل ال داخل ال
            'body'=>'a new order created by '.$add->name,
            'icon'=>'',
            'url'=> url('/'),
        ];
    }
    public function toBroadCast( $notifiable)
    {
        $add = $this->order->billingAddress();
        return new BroadcastMessage([
            'body'=>'a new order created by '.$add->name,
            'icon'=>'',
            'url'=> url('/'),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
