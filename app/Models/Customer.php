<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'username', 'password', 'nama', 'alamat', 'email', 'nohp', 'foto',
    ];

    protected $hidden = [
        'password',
    ];

    public function sewa(): HasMany
    {
        return $this->hasMany(Sewa::class);
    }
}
