<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Admin extends User // AUTH دا مش موديل اليوزر ولكن دا خاص ب
{
    use HasFactory ,Notifiable;
    protected $fillable = [
        'name','email','password','username','phone_number','super_admin','status'

    ];
}
