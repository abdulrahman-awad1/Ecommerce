<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';//b دا اسم التابل ال هيتصل بيه
    protected $connection = 'mysql'; //n دا نوع الداتا بيز ال هيتصل بيها لان احنا عارفين ان ممكن يشتغل مع اكتر من داتا بيز
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    //x كل هذه التعريفات بتكون اصلا ديفولت ف لارافيل ف كلاس(المودل) وانا مش محتاج اكتبها الا لو غيرت القيم الديفولت دي

    public function products(){
        return $this->hasMany(Product::class,'store_id','id');
    }
}
