<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    public $timestamps = false; //v دي عملتها فولص لان انا حذفتها من الجدول اصلا بس لارافيل بتضيفها تلقائي

    protected $guarded;
}
