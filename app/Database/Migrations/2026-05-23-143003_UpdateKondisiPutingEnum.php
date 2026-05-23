<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKondisiPutingEnum extends Migration
{
    public function up()
    {
        // Ubah ENUM kondisi_puting: gabungkan nilai lama + baru
        $this->forge->modifyColumn('cek_kelancaran_asi', [
            'kondisi_puting' => [
                'type'       => 'ENUM',
                'constraint' => ['Normal', 'Lecet', 'Datar', 'Tenggelam', 'Menonjol', 'Pecah'],
                'default'    => 'Normal',
            ],
        ]);
    }

    public function down()
    {
        // Kembalikan ke ENUM asli
        $this->forge->modifyColumn('cek_kelancaran_asi', [
            'kondisi_puting' => [
                'type'       => 'ENUM',
                'constraint' => ['Normal', 'Lecet', 'Datar', 'Tenggelam'],
                'default'    => 'Normal',
            ],
        ]);
    }
}
