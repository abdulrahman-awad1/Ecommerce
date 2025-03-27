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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('user_id')
                ->nullable()//v لان ممكن اسمح لاي شخص حتي لو مش عامل تسجيل دخول يدخل يعمل اوردر null  القيمه دي ممكن تبقي
                ->constrained('users')
                ->nullOnDelete();
            $table->string('number')->unique();
            $table->enum('status',['pending','processing','cancelled','delivering','completed','refunded'])
                ->default('pending');
            $table->enum('payment_status',['pending','paid','failed'])->default('pending');
            $table->string('payment_method');
            $table->float('shipping')->default(0);//b الشحن
            $table->float('tax')->default(0);// x الضريبه المضافه
            $table->float('discount')->default(0);
            $table->float('total')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
