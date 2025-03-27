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
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status',['in-progress','delivered','pending'])
                ->default('pending')
                ->change(); //b دي بتستخدم عشان لارافيل تعرف انه بيعدل ع الجدول ومش بيضيف حقل جديد change  الميثود
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status',['in-progress','delivered'])->default('in-progress')->change();

        });
    }
};
