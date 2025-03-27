<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use phpseclib3\Crypt\Random;

class SocialLoginController extends Controller
{
    public function redirect()
    {


        // إعادة التوجيه إلى جوجل للحصول على الـ Authorization code
        return Socialite::driver('google')->stateless()->redirect();
    }

    // التعامل مع رد جوجل بعد تسجيل الدخول
    public function callback(Request $request)
    {
        try {
            // الحصول على بيانات المستخدم من جوجل باستخدام الـ Code
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to authenticate with Google', 'message' => $e->getMessage()], 400);
        }

        // التحقق إذا كان المستخدم موجودًا بالفعل في قاعدة البيانات بناءً على Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        // إذا لم يكن موجودًا، نقوم بإنشائه
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'provider' => 'google',
                'password'=> Hash::make(12345678)

            ]);
        }

        // تسجيل الدخول للمستخدم
        Auth::login($user, true);

        // توليد توكن API للمستخدم باستخدام Sanctum
        $token = $user->createToken('GoogleLoginToken')->plainTextToken;

        // إرجاع التوكن مع بيانات المستخدم في استجابة JSON
        return response()->json([
            'token' => $token,  // هذا هو توكن Sanctum الذي يمكنك استخدامه في المستقبل
            'user' => $user
        ]);
    }
    public function google_login(Request $request)
    {

        $token = $request->token;
        $providerUser = Socialite::driver("google")->userFromToken($token);
        $userProviderId = $providerUser->id;

        $user = User::where('provider_name', 'google')->where('provider_id', $userProviderId)->first();

        if (!$user) {
            $user = User::create([
                "name" => $providerUser->name,
                "provider_name" => "google",
                "provider_id" => $userProviderId,


            ]);
        }
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "status" => "success",
            "access_token" => $accessToken
        ]);
    }

}

