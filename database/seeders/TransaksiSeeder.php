<?php

namespace Database\Seeders;

use App\Models\Sewa;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $transaksi = [
            // Transaksi SELESAI (sudah selesai)
            [
                'no_invoice' => 'INV-20260901-001',
                'nama_customer' => 'Rizki Pratama',
                'nohp' => '085612345678',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta Pusat',
                'nama_mobil' => 'Toyota Avanza',
                'nopol' => 'B 1234 DJV',
                'nama_supir' => 'Budi Santoso',
                'tanggal_pinjam' => '2026-09-01 08:00:00',
                'tanggal_kembali' => '2026-09-03 08:00:00',
                'jaminan' => 'KTP + SIM A',
                'total_biaya' => 750000,
                'verifikasi' => 'SELESAI',
                'bukti' => null,
                'created_at' => '2026-09-01 07:00:00',
            ],
            // Transaksi SELESAI (kedua)
            [
                'no_invoice' => 'INV-20260905-002',
                'nama_customer' => 'Maya Sari',
                'nohp' => '087812345678',
                'alamat' => 'Jl. Gatot Subroto No. 25, Jakarta Selatan',
                'nama_mobil' => 'Mitsubishi Xpander',
                'nopol' => 'B 3456 DJV',
                'nama_supir' => 'Andi Prasetyo',
                'tanggal_pinjam' => '2026-09-05 09:00:00',
                'tanggal_kembali' => '2026-09-07 09:00:00',
                'jaminan' => 'KTP + BPKB',
                'total_biaya' => 900000,
                'verifikasi' => 'SELESAI',
                'bukti' => null,
                'created_at' => '2026-09-05 08:00:00',
            ],
            // Transaksi DITERIMA (sedang berlangsung)
            [
                'no_invoice' => 'INV-20260910-003',
                'nama_customer' => 'Ahmad Fauzi',
                'nohp' => '081234567899',
                'alamat' => 'Jl. Thamrin No. 15, Jakarta Pusat',
                'nama_mobil' => 'Toyota Innova',
                'nopol' => 'B 2345 DJV',
                'nama_supir' => 'Dedi Kurniawan',
                'tanggal_pinjam' => '2026-09-10 07:00:00',
                'tanggal_kembali' => '2026-09-15 07:00:00',
                'jaminan' => 'KTP + STNK',
                'total_biaya' => 2750000,
                'verifikasi' => 'DITERIMA',
                'bukti' => null,
                'created_at' => '2026-09-10 06:30:00',
            ],
            // Transaksi Requested (menunggu verifikasi)
            [
                'no_invoice' => 'INV-20260912-004',
                'nama_customer' => 'Dewi Lestari',
                'nohp' => '082345678900',
                'alamat' => 'Jl. Kuningan No. 30, Jakarta Selatan',
                'nama_mobil' => 'Honda Civic',
                'nopol' => 'B 4567 DJV',
                'nama_supir' => 'TANPA SUPIR',
                'tanggal_pinjam' => '2026-09-13 10:00:00',
                'tanggal_kembali' => '2026-09-14 10:00:00',
                'jaminan' => 'KTP',
                'total_biaya' => 450000,
                'verifikasi' => 'Requested',
                'bukti' => null,
                'created_at' => '2026-09-12 15:00:00',
            ],
            // Transaksi Requested (kedua)
            [
                'no_invoice' => 'INV-20260914-005',
                'nama_customer' => 'Hendra Wijaya',
                'nohp' => '083456789011',
                'alamat' => 'Jl. Alternatif Cibubur No. 5, Jakarta Timur',
                'nama_mobil' => 'Toyota Avanza',
                'nopol' => 'B 1234 DJV',
                'nama_supir' => 'Budi Santoso',
                'tanggal_pinjam' => '2026-09-15 08:00:00',
                'tanggal_kembali' => '2026-09-16 08:00:00',
                'jaminan' => 'KTP + SIM A',
                'total_biaya' => 400000,
                'verifikasi' => 'Requested',
                'bukti' => null,
                'created_at' => '2026-09-14 09:00:00',
            ],
            // Transaksi DITOLAK
            [
                'no_invoice' => 'INV-20260908-006',
                'nama_customer' => 'Siti Nurhaliza',
                'nohp' => '084567890122',
                'alamat' => 'Jl. Raya Bogor Km 30, Jakarta Timur',
                'nama_mobil' => 'Toyota Innova',
                'nopol' => 'B 2345 DJV',
                'nama_supir' => 'TANPA SUPIR',
                'tanggal_pinjam' => '2026-09-09 08:00:00',
                'tanggal_kembali' => '2026-09-10 08:00:00',
                'jaminan' => 'KTP',
                'total_biaya' => 500000,
                'verifikasi' => 'DITOLAK',
                'bukti' => null,
                'created_at' => '2026-09-08 20:00:00',
            ],
        ];

        foreach ($transaksi as $item) {
            Sewa::create($item);
        }

        if ($this->command) {
            $this->command->info('✅ ' . count($transaksi) . ' transaksi berhasil ditambahkan.');
        }
    }
}
