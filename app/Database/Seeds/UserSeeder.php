<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nama'          => 'Administrator',
                'umur'          => null,
                'pekerjaan'     => null,
                'jumlah_anak'   => null,
                'no_telp'       => '08111111111',
                'alamat'        => 'Dinas Kesehatan Kota',
                'id_kabkota'    => null, // Admin tidak terikat puskesmas / wilayah secara default, atau bisa diset
                'id_puskesmas'  => null,
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'          => 'admin',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama'          => 'Ibu Contoh',
                'umur'          => 28,
                'pekerjaan'     => 'Ibu Rumah Tangga',
                'jumlah_anak'   => 1,
                'no_telp'       => '08222222222',
                'alamat'        => 'Jl. Contoh Alamat No 123',
                'id_kabkota'    => '6371', // Banjarmasin
                'id_puskesmas'  => 'P637101', // Puskesmas Cempaka
                'password_hash' => password_hash('ibu123', PASSWORD_BCRYPT),
                'role'          => 'ibu',
                'created_at'    => $now,
                'updated_at'    => $now,
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
