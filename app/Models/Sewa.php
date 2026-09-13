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
        'customer_id',
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
        'verifikasi',
    ];

    public function getHargaMobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    /**
     * Check if an overlap exists for a mobil or supir during the given time range.
     */
    public static function hasOverlap(string $type, string $name, string $waktuPjm, string $waktuBalik): bool
    {
        $column = $type === 'mobil' ? 'nama_mobil' : 'nama_supir';

        return self::query()
            ->whereIn('verifikasi', ['Requested', 'DITERIMA'])
            ->where($column, $name)
            ->where(function ($q) use ($waktuPjm, $waktuBalik) {
                $q->whereBetween('tanggal_pinjam', [$waktuPjm, $waktuBalik])
                    ->orWhereBetween('tanggal_kembali', [$waktuPjm, $waktuBalik])
                    ->orWhere(function ($q2) use ($waktuPjm, $waktuBalik) {
                        $q2->where('tanggal_pinjam', '<=', $waktuPjm)
                            ->where('tanggal_kembali', '>=', $waktuBalik);
                    });
            })
            ->exists();
    }
}
