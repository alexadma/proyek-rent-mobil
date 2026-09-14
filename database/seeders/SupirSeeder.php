<?php

namespace Database\Seeders;

use App\Models\Supir;
use Illuminate\Database\Seeder;

class SupirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supirs = [
            [
                'noktp' => '3201234567890001',
                'nama' => 'Budi Santoso',
                'alamat' => 'Jakarta Selatan',
                'nohpsupir' => '081234567890',
                'image' => 'foto-supir/sY9YzqUAY5OSOhq2TbyUilNmY2fCspbBec5vj09a.jpg',
                'sewa' => 50000,
                'status' => 'TERSEDIA',
            ],
            [
                'noktp' => '3201234567890002',
                'nama' => 'Andi Prasetyo',
                'alamat' => 'Jakarta Barat',
                'nohpsupir' => '082345678901',
                'image' => 'foto-supir/Gj0N6X6sUf6L5Cxq3oztDsVqF7wIs5fXVyjO8FCN.jpg',
                'sewa' => 50000,
                'status' => 'TERSEDIA',
            ],
            [
                'noktp' => '3201234567890003',
                'nama' => 'Dedi Kurniawan',
                'alamat' => 'Jakarta Timur',
                'nohpsupir' => '083456789012',
                'image' => 'foto-supir/G3e979eiyYJ6kd7bMATGXpcRExrBE3N7fdj2txoO.jpg',
                'sewa' => 50000,
                'status' => 'TERSEDIA',
            ],
        ];

        foreach ($supirs as $supir) {
            Supir::updateOrCreate(
                ['noktp' => $supir['noktp']],
                $supir
            );
        }

        if ($this->command) {
            $this->command->info('✅ ' . count($supirs) . ' supir berhasil ditambahkan.');
        }
    }
}
