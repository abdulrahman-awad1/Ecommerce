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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();//c دا كدا عشان يعمل ريلاشن مع جدول اليوزر
            $table->primary('user_id');      // unique عشان اضمن ان الريلاشن دي هتكون وان تو وان خلبت العامود دا بريامري كي عشان قيمته متتكررش وكنت ممكن اخليه
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday')->nullable();
            $table->enum('gender',['male','female'])->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country',2);//a دا بيرمز للدوله
            $table->char('local',2)->default('en'); //a دا بيرمز ل اللغة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
