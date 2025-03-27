<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit(){
        $user = Auth::user();
        return view('dashboard.profile.edit',[
            'user'=>$user,
            'countries'=> Countries::getNames(),
            'languages'=>Languages::getNames()//composer require symfony/intl السطر دا و ال فوق عن طريق باكدج الخاصه باللغات ال متحمله
            //n دا بيرجع ارراي بكل اللغات
        ]);
    }
    public function update(Request $request){
        $request->validate([
            'first_name'=>['required','string',],
            'last_name'=>['required','string',],
            'birthdate'=>['nullable','date','before:today'],
            'gender'=>['in:male,female'],
            'country'=>['required','string','size:2'],
        ]);
        $user = Auth::user();
     //   $user = request()->user(); نفس السطر ال فوق
        $user->profile()->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')->with('success','profile update');


    }


}

