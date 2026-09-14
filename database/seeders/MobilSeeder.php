<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        $mobils = [
            [
                'nopol' => 'B 1234 DJV',
                'nama_mobil' => 'Toyota Avanza',
                'type' => 'MPV',
                'tgl_pjk' => '2026-12-31',
                'status' => 'TERSEDIA',
                'warna' => 'Merah',
                'sewa' => 350000,
                'foto' => 'foto-mobil/6RNw7fTSD5Kgz9wA1NceUywyGAiQPY0lDC1Yy8lS.jpg',
            ],
            [
                'nopol' => 'B 2345 DJV',
                'nama_mobil' => 'Toyota Innova',
                'type' => 'MPV',
                'tgl_pjk' => '2026-11-30',
                'status' => 'TERSEDIA',
                'warna' => 'Hitam',
                'sewa' => 500000,
                'foto' => 'foto-mobil/Zx1aIk8YX7BxvktIRYf6owbogYl0HnuKdaUAsOOY.jpg',
            ],
            [
                'nopol' => 'B 3456 DJV',
                'nama_mobil' => 'Mitsubishi Xpander',
                'type' => 'MPV',
                'tgl_pjk' => '2027-01-15',
                'status' => 'TERSEDIA',
                'warna' => 'Putih',
                'sewa' => 400000,
                'foto' => 'foto-mobil/fZUmoZa4QrJfmyFVMyJPu6P2YYTly8LXtAkhwKfA.jpg',
            ],
            [
                'nopol' => 'B 4567 DJV',
                'nama_mobil' => 'Honda Civic',
                'type' => 'Sedan',
                'tgl_pjk' => '2026-10-31',
                'status' => 'TERSEDIA',
                'warna' => 'Hitam',
                'sewa' => 450000,
                'foto' => 'foto-mobil/714P02Jok4IyqfRbxMgUkdBl4Bz6LyMYyZFZvMgg.jpg',
            ],
        ];

        foreach ($mobils as $mobil) {
            Mobil::updateOrCreate(
                ['nopol' => $mobil['nopol']],
                $mobil
            );
        }

        if ($this->command) {
            $this->command->info('✅ ' . count($mobils) . ' mobil berhasil ditambahkan.');
        }
    }
}
