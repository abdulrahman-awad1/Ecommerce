<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_token',
        'provider_id',
        'provider'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [ // i date الي string  دي مسؤله عن تغيير نوع الداتا ال هتتخذن ف الداتا بيز  يعني هو هنا اتغير من cast
        'email_verified_at' => 'datetime',
    ];
    public function setProviderTokenAttribute($value){
        $this->attributes['provider_token'] = Crypt::encryptString($value);
    }
    public function getProviderTokenAttribute($value){
        return Crypt::decryptString($value);
    }
    public function profile(){
        return $this->hasOne(Profile::class,'user_id','id')
            ->withDefault();//withDefault ف حالة ان مفيش بروفايل لليوزر null دي بنستخدمها عشان نتجنب ان الناتج يكون
    }
}
