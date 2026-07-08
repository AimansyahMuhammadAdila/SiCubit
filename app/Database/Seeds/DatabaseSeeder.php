<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan seeder gabungan
        $this->call('SiCubitSeeder');
        $this->call('KabupatenKotaSeeder');
        $this->call('PuskesmasSeeder');
        $this->call('UserSeeder');
    }
}
