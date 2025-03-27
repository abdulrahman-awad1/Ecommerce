<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();
      //  \App\Models\Admin::factory(3)->create();

      /*   \App\Models\User::factory()->create([
             'password' => Hash::make('12345678') ,
       'email' => 'teFFt@example.com',
        ]);*/
       // Store::factory(5)->create();
      //  Category::factory(10)->create();
      //  Product::factory(100)->create();
        Order::factory(10)->create();
     //   $this->call(UserSeeder::class);
    }
}
