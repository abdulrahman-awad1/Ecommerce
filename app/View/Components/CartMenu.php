<?php

namespace App\View\Components;

use App\facades\Cart;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public $items;
    public $total;
    public function __construct()
    {
      $this->items  = Cart::get(); // cart >> وليس موديل facade ودا
        $this->total = Cart::total();
        // Cart زي ما عملنا ف الكنترولر بتاع ال service container استدعي ال facade  خد بالك ممكن بدل ما استدعي ال
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}
