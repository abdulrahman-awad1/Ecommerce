<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{
    public function authenticate($request){
        $username=$request->post(config('fortify.username'));
        $password=$request->post('password');

        $user = Admin::where('username',$username)
            ->orWhere('email',$username)
            ->orWhere('phone_number',$username)
            ->first();         //m كدا بعمل لوجين للادمن من خلال اي شرط من دول

        if ($user && Hash::check($password,$user->password)){
            return $user; //b لو الشرط اتحقق قارن باسورد اليوزر من الجدول وباسورد اليوزر ال ف الريكويست

        }

    }

}
