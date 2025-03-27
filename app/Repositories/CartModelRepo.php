<?php
namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
//use http\Cookie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartModelRepo implements CartRepo
{

    public function get(): collection
    {

        return Cart::with('product')->where('cookie_id','=',$this->getCookieId())->get();

    }

    public function add(Product $product,$quantity=1)
    {
        $item = Cart::where('id', '=', $product->id)
            ->where('cookie_id','=',$this->getCookieId())
            ->first();



        if (!$item){
        $cart= Cart::create([
            'cookie_id'=> $this->getCookieId(),
            'user_id'=> Auth::id(),
            'product_id'=> $product->id,
            'quantity'=> $quantity
        ]);
        $this->get()->push($cart);
        return $cart;
        }
        return $item->increment('quantity',$quantity);
    }
    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id','=',$this->getCookieId())
            ->update([
            'quantity'=>$quantity
        ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id','=',$this->getCookieId())
            ->delete();



    }
    public function empty()
    {
        Cart::where('cookie_id', )->destroy();


    }
    public function total() : float //c دي معناها ان القيمه المفروض تطلع تكون فلوت ولو كانت غير كدا يبقي ايرور
    {
        return (float) Cart::where('cookie_id','=', )-> // m كلمة فلوت دي هتحول نوع الناتج ال طلع الي فلوت اي كان قيمة الناتج اصلا
            join('products','products.id','=','carts.product_id')
            ->selectRow('SUM(products.price * carts.quantity) as total')
            ->value('total');
       // $this->get(); // items  الجمله دي هترجعلي ال

    }

    protected function getCookieId(){
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id){
            $cookie_id =Str::uuid();
            Cookie::queue('cart_id',$cookie_id,30*24*60);
        }
        return $cookie_id;
    }

}
