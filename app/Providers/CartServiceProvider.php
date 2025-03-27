<?php

namespace App\Providers;

use App\Repositories\CartModelRepo;
use App\Repositories\CartRepo;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepo::class,function (){
            return new CartModelRepo();
            //cart ف السيرفس كونتينر وهستدعيه ف الكنترول  عن طريق الكلاس الانتر فيس ال اسمه CartModelRepo كدا انا خذنت اوبجيك من ال
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
