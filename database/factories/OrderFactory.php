<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => \App\Models\Store::inRandomOrder()->first()->id,  // استرجاع store عشوائي
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,    // استرجاع user عشوائي
            'number' => $this->faker->unique()->numerify('ORD-#####'),      // إنشاء رقم طلب فريد
           // 'status' => $this->faker->randomElement(['pending',]), // الحالة
            'payment_status' => $this->faker->randomElement(['paid',  'pending']),  // حالة الدفع
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),  // طريقة الدفع
            'shipping' => $this->faker->randomFloat(2, 5, 20),  // تكلفة الشحن
            'tax' => $this->faker->randomFloat(2, 1, 10),      // الضرائب
            'discount' => $this->faker->randomFloat(2, 0, 10),  // الخصم
            'total' => $this->faker->randomFloat(2, 50, 200),  // المجموع الكلي
            'created_at' => $this->faker->dateTimeThisYear(),  // تاريخ الإنشاء
            'updated_at' => $this->faker->dateTimeThisYear(),  // تاريخ التحديث
        ];
    }
}
