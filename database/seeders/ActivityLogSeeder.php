<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'type' => 'mobil',
                'action' => 'create',
                'description' => 'Menambahkan mobil baru: Toyota Avanza (B 1234 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDays(5)->subHours(3),
            ],
            [
                'type' => 'mobil',
                'action' => 'create',
                'description' => 'Menambahkan mobil baru: Toyota Innova (B 2345 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDays(5)->subHours(2),
            ],
            [
                'type' => 'mobil',
                'action' => 'create',
                'description' => 'Menambahkan mobil baru: Mitsubishi Xpander (B 3456 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDays(5)->subHours(1),
            ],
            [
                'type' => 'mobil',
                'action' => 'create',
                'description' => 'Menambahkan mobil baru: Honda Civic (B 4567 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDays(5),
            ],
            [
                'type' => 'supir',
                'action' => 'create',
                'description' => 'Menambahkan supir baru: Budi Santoso',
                'user' => 'Admin',
                'created_at' => now()->subDays(4)->subHours(5),
            ],
            [
                'type' => 'supir',
                'action' => 'create',
                'description' => 'Menambahkan supir baru: Andi Prasetyo',
                'user' => 'Admin',
                'created_at' => now()->subDays(4)->subHours(4),
            ],
            [
                'type' => 'supir',
                'action' => 'create',
                'description' => 'Menambahkan supir baru: Dedi Kurniawan',
                'user' => 'Admin',
                'created_at' => now()->subDays(4)->subHours(3),
            ],
            [
                'type' => 'mobil',
                'action' => 'update',
                'description' => 'Mengupdate data mobil: Toyota Avanza (B 1234 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDays(3),
            ],
            [
                'type' => 'supir',
                'action' => 'update',
                'description' => 'Mengupdate data supir: Budi Santoso',
                'user' => 'Admin',
                'created_at' => now()->subDays(2),
            ],
            [
                'type' => 'mobil',
                'action' => 'update',
                'description' => 'Mengupdate data mobil: Honda Civic (B 4567 DJV)',
                'user' => 'Admin',
                'created_at' => now()->subDay(),
            ],
        ];

        foreach ($activities as $activity) {
            ActivityLog::create($activity);
        }

        if ($this->command) {
            $this->command->info('✅ ' . count($activities) . ' activity log berhasil ditambahkan.');
        }
    }
}
