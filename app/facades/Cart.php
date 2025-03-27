<?php
namespace App\facades;

use App\Repositories\CartRepo;
use Illuminate\Support\Facades\Facade;
use App\Repositories\CartModelRepo;
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepo::class;
    }
}
