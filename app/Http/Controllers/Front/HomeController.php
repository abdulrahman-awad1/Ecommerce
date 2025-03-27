<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $product = Product::where('status','=','active')->get();
       // $product = Product::active()->latest(6)->get(); //d دي بديله للجمله ال فوقها
        //where الاسكوب دا بيحقق نفس جملة ال  active دا كدا عملت سكوب داخل موديل ال  اسمه

   //     return view(/*'api',$product*/);
        return response()->json(['product' => $product]);
    }
}
