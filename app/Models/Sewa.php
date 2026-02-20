<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'no_invoice',
        'nama_customer',
        'nohp',
        'alamat',
        'nama_mobil',
        'nopol',
        'nama_supir',
        'tanggal_pinjam',
        'jaminan',
        'tanggal_kembali',
        'total_biaya',
        'bukti',
        'verifikasi'
    ];

    public function getHargaMobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}
