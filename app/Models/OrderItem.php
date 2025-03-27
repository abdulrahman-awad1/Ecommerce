<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use mysql_xdevapi\Table;

//class OrderItem extends Model
class OrderItem extends Pivot // x عملت استدعاء للبيفوت وليس للموديل عشان دا جدول بسيط
{
    use HasFactory;
    //c للبيفوت مش للموديل فبالتلي لازم اضيف الجملتين دول extend  السطرين دول انا ضيفتهم لان الموديل دا عباره عن وسيط وعمل
    protected $table = 'order_items';
    public $incrementing = true;


    public $timestamps = false; //v دي عملتها فولص لان انا حذفتها من الجدول اصلا بس لارافيل بتضيفها تلقائي
    protected $guarded;

    public function product(){
        return $this->belongsTo(Product::class)->withDefault([
            'name'=>$this->poduct_name,
        ]);
    }
    public function order(){
        return $this->belongsTo(Order::class);

    }
}
