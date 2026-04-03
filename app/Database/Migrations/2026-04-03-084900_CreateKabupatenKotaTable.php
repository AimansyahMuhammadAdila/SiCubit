<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKabupatenKotaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'comment'    => 'Kode BPS kabupaten/kota, misal: 3201, 3301',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['Kabupaten', 'Kota'],
                'default'    => 'Kabupaten',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kabupaten_kota', true);
    }

    public function down()
    {
        $this->forge->dropTable('kabupaten_kota', true);
    }
}
