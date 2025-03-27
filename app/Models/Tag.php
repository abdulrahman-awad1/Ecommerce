<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['name','slug'];


    public function products(){
        return $this->belongsToMany(
            Product::class,       //related model
            'product_tag',     //pivot table لبجدول الوسيط
            'product_id',  // FK in pivot table for the current table
            'tag_id',      // FK in pivot table for the related table
            'id',              // PK for current model
            'id');         //  PK for related model
    }
}
