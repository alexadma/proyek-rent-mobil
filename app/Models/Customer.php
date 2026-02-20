<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class customer extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ='customers';

    protected $fillable = [
        'username', 'password', 'nama', 'alamat', 'email', 'nohp', 'password'
    ];

}