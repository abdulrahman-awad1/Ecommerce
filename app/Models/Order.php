<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id','user_id','payment_method','status','payment_status' //h لان مش هنضيفه احنا يدوي ولكن هيتضاف تلقائي عن طريق فانكشن هننفذها   number هنا مضفناش حقل ال
    ];

    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'customer'//n دا قيمه ديفولت لاسم اليوزر ف حالة ان ايوزر مش مسجل دخول
        ]);
    }
    public function items(){
        return $this->hasMany(OrderItem::class,'order_id');
    }


    // many to many
    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
            ->using(OrderItem::class)//V هنا عملت يوزينج للموديل الوسيط
            ->withPivot(['product_name','price','quantity','options']);//c الكولومز دي كان لازم اضيفها عشان لارافيل تشوفها
    }


    //relation 1 to many لان الاوردر الواحد ممكن يكون ليه اكتر من ادريس ال هو الفاتوره او الشحن
    public function addresses(){
        return $this->hasMany(OrderAddress::class);
    }

    //nمن خلال ال 2فانكشن الجايين دول 1 to تم تقسيم الريلاشن السابقه دي الي ريلاشن 1
    public function billingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','order')->where('type','=','billing');
    }
    public function shippingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','order')->where('type','=','shipoing');
    }






    //method event for add number column
    public static function booted()
    {
        static::creating( function (Order $order){
            $order->number = Order::getNextOrderNumber();

        });

    }

    //c الفانكشن دي استخدمتها عشان احسب منها رقم الاوردر ع حسب السنه الحاليه
    //x بعد ما حسبت منها رقم الاوردر حهستخدمه ف فانكشن الايفينت عشان يتضاف او يتكريت ف تابل الاوردر
    public function getNextOrderNumber(){
        $year = Carbon::now()->year;
        $number =Order::whereYear('created_at','=',$year)->max('number');
        if ($number){
            return $number+1;
        }
        return $year.'0001';
    }
}

