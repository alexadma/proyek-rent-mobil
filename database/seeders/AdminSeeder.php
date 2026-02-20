<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin1',
            'password' => bcrypt('123456'),
        ]);

        Admin::create([
            'username' => 'admin1',
            'nama' => 'Fajar',
            'alamat' => 'Gamping',
            'password' => bcrypt('123456'),
        ]);
    }
}
