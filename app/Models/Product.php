<?php

namespace App\Models;

use App\Models\Scopes\storeScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

class Product extends Model
{
    use HasFactory;
    protected $guarded;
    protected $appends = [];

    //global scope
    protected static function booted()
    {
        static ::addGlobalScope('store',new storeScope());

    }

    //relation
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,       //related model
            'product_tag',     //pivot table لبجدول الوسيط
        'product_id',  // FK in pivot table for the current table
        'tag_id',      // FK in pivot table for the related table
        'id',              // PK for current model
            'id');         //  PK for related model
    }

    //scope
    public function scopeActive(Builder $builder ){ //b ال جوه القوس دا ثابت عشان بيستدعي من الداتا بيز
        $builder->where('status','=','active');
    }

    //accessors
    //v بنستخدمه عشان نستدعيه بعد ذلك ونعرض منه ف الواجهة
    public function getFullNameAttribute() // f بنستدعيه ف الواجهة بالطريقه دي >> $product->full_name ,, طبعا المتغير ال اسمه برودكت بيشير ال الموديل
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    //accessors
    public function getSalePercentAttribute()
    {
        // Check if price is greater than 0 to avoid division by zero
        if ($this->price > 0 && $this->compare_price < $this->price) {
            // Calculate the sale percentage
            $discount = (($this->price - $this->compare_price) / $this->price) * 100;
            return round($discount, 2); // Round to 2 decimal places
        }

        return 0; // No discount if no sale_price or invalid data
    }

}
