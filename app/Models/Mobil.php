<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils';

    protected $fillable = [
        'nopol',
        'nama_mobil',
        'type',
        'tgl_pjk',
        'status',
        'warna',
        'sewa',
        'foto',
    ];
}
