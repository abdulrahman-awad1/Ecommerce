<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    public function __construct(){
    //    $this->middleware('auth:sanctum')->except(''); ممكن نستخدم الميدل وير هنا بدل الراوت
    }

     public function store(Request $request){
         $request->validate([
             'email'=>'required|email',
             'password'=>'required|string|min:6',
             'device_name'=>'string|min:3',
         ]);
         $user = User::where('email',$request->email)->first();
         if ($user && Hash::check($request->password,$user->password )){
             $deviceName = $request->post('device_name',$request->userAgent());
             $token =$user->createToken($deviceName);
             return Response::json([
                 'code'=>'1',
                 'token'=>$token->plainTextToken,
                 'user'=>$user,
             ],201);
         }
         return Response::json([
             'code'=>'0',
             'message'=>'invalid credentials'
         ],401);

   }

   public function destroy($token = null)
   {
       $user = Auth::guard('sanctum')->user();
      /* if ($token===null)
       {
       $user->currentAccessToken()->delete(); //n لو التوكين متبعتش استخدم الفانكشن دي ال بتعرف التوكن الحالي عشان تحذفه
       return Response::json('token is deleted');
       }*/
       $personAccessToken= PersonalAccessToken::findToken($token);
       if ($user->id == $personAccessToken->tokenable_id && get_class($user) == $personAccessToken->tokenable_type){
           $personAccessToken->delete();
           return Response::json('token is deletedmmm');
       }


   }
    public function localLanguage(Request $request)
    {
        $message = __('messages.welcome'); // سيتم عرض الرسالة المترجمة بناءً على اللغة
        return response()->json(['message' => $message]);
    }


}
