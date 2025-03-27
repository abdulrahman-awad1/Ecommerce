<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()//n عشان لو اشتريت منتج مثلا وبعد كدا صاحب المنتج حذفه من المنتجات null القيمه ممكن تكون
                ->constrained('products')->nullOnDelete();
            //v العامودين التاليين عشان بردو لو صاحب المنتج الاصلي حذف تفاصيل المنتج اكون انا محتفظ بالتفاصيل ف الاوردر بتاعي
            $table->string('product_name');
            $table->float('price');

            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unique(['order_id','product_id']);//c دا معناه ان الاوردر ممكن يتكرر لوحده و البرودكت ممكن يتكرر لوحده انما الاتنين مع بعض مش هيتكرروا
            $table->json('options')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
