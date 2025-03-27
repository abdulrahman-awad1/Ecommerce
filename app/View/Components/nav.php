<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items=config('nav'); //config داخل ال  nav انشئ ملف
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav'); //v  هيتبعت للصفحه دي بشكل مباشر لانه بابلك $items  كدا ال
    }
}
