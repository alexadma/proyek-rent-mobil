<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'Admin@123456';

        Admin::updateOrCreate(
            ['username' => 'admin1'],
            [
                'nama' => 'Admin',
                'alamat' => 'Jakarta',
                'password' => bcrypt($password),
            ]
        );

        if ($this->command) {
            $this->command->warn('Login admin => username: admin1, password: '.$password);
        }
    }
}
