<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'abdulrahman',
            'email'=>'abd@ulrahman',
            'password'=>Hash::make('password'),
            'phone'=>'12345678',
        ]);//updated_at ,created_at هنا هنضيف ف التابل عن طريق الموديل وهو هيضيف عمود ال

        DB::table('users')->insert([
            'name'=>'boda',
            'email'=>'b@da',
            'password'=>Hash::make('password'),
            'phone'=>'12341234',
        ]); //updated_at ,created_at هنا هنضيف ف التابل بشكل مباشر وهو مش  هيضيف عمود ال
    }

}
