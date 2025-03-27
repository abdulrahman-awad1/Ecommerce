<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\CartRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;


class CheckoutController extends Controller //v احنا هنا هنعمل الاوردر فمحتاجين السله ال هتضيف فيها الطلب
{
    public $order;

    public function __construct()
    {
        // يمكنك تهيئة المتغير هنا إذا كنت بحاجة إلى ذلك
        $this->order = Order::find(1);
    }

    public function create(CartRepo $cart){ // x استدعيد السله
        if ($cart->get()->count() == 0){
            return redirect()->route('home');
        }
        return view('',[
            'cart'=>$cart,
            'countries'=>Countries::getNames(),
            ]);
    }


    public function store(Request $request , CartRepo $cart){
      /*  $request->validate([
            'add.billing.first_name'=>['required','string','max:255'],
            'add.billing.last_name'=>['required','string','max:255'],
            'add.billing.email'=>['required','string','max:255'],
            'add.billing.phone_number'=>['required','string','max:255'],
            'add.billing.city'=>['required','string','max:255'],

        ]);*/

        $items = $cart->get()->groupBy('product.store_id')->all();//m كنا انشأنا ميثود اسمها جيت ف الكارت عشان تجيب العناصر او الايتم

        DB::beginTransaction();

        try {
            foreach ($items as $store_id =>$cart_items){
                $order = Order::create([ //x هنا حددنا صاحب الاوردر والمحل وطريقة الدفع
                   'store_id'=>$store_id,
                   'user_id'=>Auth::id(),
                  'payment_method'=>'cod',//x دي اختصار للدفع الكاش
                    ]);

            //v هنجيب كل العناصر او الايتم ال هشتريها تتعرض ف السله
            foreach ($cart_items as $item)
            {
                OrderItem::create([ //v كدا يعتبر من السله انشأنا الايتم او العناصر
                   'order_id'=>$order->id,
                   'product_id'=>$item->product->id, //v للمنتج id  من خلال السله قدرت اوصل لموديل البرودكت عن طريق الريلاشن ال بينهم وجبت ال
                   'product_name'=>$item->product->name,//v نفس سطر ال فوق
                   'price'=>$item->product->price,//v نفس سطر ال فوق
                   'quantity'=>$item->quantity,
                   ]);
        }
             //b دا خاص ب الاوردرادريس بتاع ال يوزر
            foreach ($request->post('addr') as $type => $address){
                 $address['type'] = $type; //c billing or shipping هنا بحدد نوع الاوردر ادريس
                 $order->addresses()->create($address);//n واخزن الادريس orderAddress عشان اوصل لموديل ال addresses  من خلال موديل الاوردر استخدمت فانكشن ال
             }

            $cart->empty();//b دا بيمسح محتوي السله بعد ما الاوردر ما اتنفذ

           DB::commit();

           event(new OrderCreated($order));//C كدا استدعيت اوبجيكت من الايفنت ال انشأته
        //   event('order_created',/*ممكن هنا امرر داتا*/); // b دا ايفينت غير ال فوق ودا مش بحتاج اكتب امر لانشائه


            }

          } catch (Throwable $e){
              DB::rollBack();
              throw $e;
            }

        return response()->json([
            'status' => 'success',
            'message' => 'Redirecting to charge page',
            'order_id'=>$order->id,
            'charge_url' => route('charge', $order->id) //n وجه المستخدم لصفحة الدفع ومعه الاوردر
        ]);


    }
}
