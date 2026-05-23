<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToCekKelancaranAsiTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('cek_kelancaran_asi', [
            'bb_naik_sesuai_usia' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'null'       => true,
                'after'      => 'volume_pumping',
                'comment'    => 'Berat badan bayi naik sesuai usia',
            ],
            'kondisi_lainnya' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'bb_naik_sesuai_usia',
                'comment' => 'Kondisi lainnya yang mendukung kelancaran ASI',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('cek_kelancaran_asi', 'bb_naik_sesuai_usia');
        $this->forge->dropColumn('cek_kelancaran_asi', 'kondisi_lainnya');
    }
}
