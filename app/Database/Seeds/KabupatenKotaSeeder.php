<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KabupatenKotaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => '6371', 'nama' => 'Banjarmasin',         'tipe' => 'Kota'],
            ['id' => '6372', 'nama' => 'Banjarbaru',           'tipe' => 'Kota'],
            ['id' => '6301', 'nama' => 'Tanah Laut',           'tipe' => 'Kabupaten'],
            ['id' => '6302', 'nama' => 'Tapin',                'tipe' => 'Kabupaten'],
            ['id' => '6303', 'nama' => 'Banjar',               'tipe' => 'Kabupaten'],
            ['id' => '6304', 'nama' => 'Barito Kuala',         'tipe' => 'Kabupaten'],
            ['id' => '6305', 'nama' => 'Kotabaru',             'tipe' => 'Kabupaten'],
            ['id' => '6306', 'nama' => 'Hulu Sungai Selatan',  'tipe' => 'Kabupaten'],
            ['id' => '6307', 'nama' => 'Hulu Sungai Tengah',   'tipe' => 'Kabupaten'],
            ['id' => '6308', 'nama' => 'Tabalong',             'tipe' => 'Kabupaten'],
            ['id' => '6309', 'nama' => 'Hulu Sungai Utara',    'tipe' => 'Kabupaten'],
            ['id' => '6310', 'nama' => 'Tanah Bumbu',          'tipe' => 'Kabupaten'],
            ['id' => '6311', 'nama' => 'Balangan',             'tipe' => 'Kabupaten'],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        $this->db->table('kabupaten_kota')->insertBatch($data);
    }
}
