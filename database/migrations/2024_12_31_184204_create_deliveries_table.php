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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique();
        //    $table->decimal('latitude', 10, 6);            // الموقع الجغرافي للطلب (خط العرض)
          //  $table->decimal('longitude', 10, 6);           // الموقع الجغرافي للطلب (خط الطول)
            $table->point('current_location')->nullable(); // c دي بتأدي وظيفة السطرين ال فوق
            $table->enum('status',['in-progress','delivered'])->default('in-progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
