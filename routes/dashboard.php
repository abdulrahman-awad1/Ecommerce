<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard',[DashboardController::class,'index'])
    ->middleware(['auth:admin', 'verified'])
    ->prefix('admin/dashboard')
    ->name('dashboard');

Route::get('categories/trash',[CategoriesController::class,'trash'])->name('categories.trash');
Route::put('categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');
Route::delete('categories/{category}/forceDelete',[CategoriesController::class,'forceDelete'])->name('categories.forceDelete');


Route::resource('dashboard/categories',CategoriesController::class)->middleware('auth');
Route::resource('dashboard/products',ProductsController::class)->middleware('auth');
Route::get('dashboard/profile',[ProfileController::class,'edit'])->name('profile.edit');
Route::put('profile/update',[ProfileController::class,'update'])->name('profile.update');

//c لاحظ ف الراوت ال فوق فيهم حاجات مشتركه بتستدعيها في كل مره ف كل راوت فيهم
//v  عشان منكررش الصفات المشتركه  route group ممكن نستخدم
//v  يحتوي ع 2براميتر الاول عباره عن اراي يحتوي ع الصفات المشركه والتاني خاص بالمسار والكنترولر (الصفات الخاصه) route group

Route::group([
  /*  'prefix'=>'dashboard',
    'middleware'=>['auth','verify'],
    ''=>'',*/

],function (){
   // Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified']);

  /*  Route::resource('dashboard/categories',CategoriesController::class)->middleware('auth')
    ->names([
    'index'=>'',
    'show'=>'',
    'edit'=>'',
    ]);
    n names هستخدم معاه  resource بم ان الراوت دا من النوع*/

});

//route group طريقه اخري ل
/*Route::middleware('')->prefix('')->group(function (){
        Route::resource('dashboard/categories',CategoriesController::class)->middleware('auth')

});*/

