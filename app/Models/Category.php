<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory ,SoftDeletes;
   // protected $fillable =['','',''] ; دا بتحدد الحقل ال المفروض تضيفه
    protected $guarded; //m دا بيحدد الحقول الممنوع اضافتها

// validation
    public static function rules(){
        return [
            'name'=>'required|string|min:3',
            'parent_id'=>'nullable|int|exists:categories,id',
            'image'=>'nullable|image|max:1048576',/*|dimensions:min_width=10,max_height=100000*/ //image النوع صوره , max عباره عن حجم الصوره ب البايت
            'status'=>'in:active,archived',

            //custom rules
            function($attribute,$value ,$fails){
                if (strtolower($value)=='laravel'){
                    $fails('this name not avilable');
                }
            }
            // custom rule
        ];
    }

    //relation
    public function products(){
      // return $this->hasMany(Product::class); ممكن نكتبها كدا او زي ما هي مكتوبة تحت ف حالة ان تسميه الاعمده مش مظبوطه
        return $this->hasMany(Product::class,'category_id','id');
    }
    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id')
            ->withDefault([
                'name'=>'-'
            ]);
    }
    public function children(){
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
