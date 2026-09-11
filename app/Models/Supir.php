<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    use HasFactory;

    protected $table = 'supirs';

    protected $primaryKey = 'noktp';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'noktp',
        'nama',
        'alamat',
        'nohpsupir',
        'image',
        'sewa',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'noktp';
    }
}
