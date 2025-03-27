<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['cookie_id','product_id','user_id','options','quantity'];

    // event (observers) دي الحاجات ال خاصه ب الايفينت
    //creating,created,updating,updated,saving,saved
    //deleting,deleted,restoring,restored,retrieved
    //x دي الفانكشن الخاصه ب الايفينت  تشبه فانكشن الجلوبال سكوب
    //n ممكن جوه الفانكشن دي اكتب كود الايفنت نفسه وممكن استدعي الايفنت من ملف الاوبسيرفر
    protected static function booted()
    {
        //v هستدعي من الاوبسيرفر
        static::observe(CartObserver::class);

       /* static::creating(function (Cart $cart){
            $cart->id = Str::uuid(); // it`s give random uuid for cart

        });*/ //x انا هنا وقفت الكود دا لان كتبته ف الاوبسيرفر
    }

    // relation
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'anonymous' // b عطينا دا اسم ديفولت ف حالة ان مفيش يوزر اصلا
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
