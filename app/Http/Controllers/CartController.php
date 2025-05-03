<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CartModelRepo;
use App\Repositories\CartRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function Sodium\add;

class CartController extends Controller
{
    public function index(CartRepo $cart){ //m cart هنا استدعيت السيرفس بروفيدر ف متغير اسمه
      //  $repository = new CartModelRepo(); هنا لغيت الاوبجيكت ال كل مره بستدعيه لان استخدمت السيرفر كونتينر بدل منه
      //  $items = $cart->get();

        return response()->json([
            'cart' => $cart
        ]);
    }

    public function store(Request $request , CartRepo $cart){
        $request->validate([
            'product_id'=>['required','int','exists:product,id'],
            'quantity'=>['nullable','int','min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
     //   $repository = new CartModelRepo();
        $cart->add($product,$request->post('quantity'));
        return response()->json([
            'message' => 'تم إضافة المنتج إلى السلة'
        ], 200);

    }
    public function update(Request $request ,/* $id*/ CartRepo $cart){
        $request->validate([
            'product_id'=>['required','int','exists:product,id'],
            'quantity'=>['nullable','int','min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
      //  $repository = new CartModelRepo();
       // $repository->update($product,$request->post('quantity'));
        $cart->update($product,$request->post('quantity'));
        return response()->json([
            'message' => 'تم إضافة المنتج إلى السلة'
        ], 200);




    }
    public function destroy($id){
        $repository = new CartModelRepo();// c دي سبت الاوبجيكت عادي ومستخدمتش السيرفس بروفيدر
        $repository->delete($id);
        return response()->json([
            'message' => 'تم حذف المنتج'
        ], 200);


    }
}
