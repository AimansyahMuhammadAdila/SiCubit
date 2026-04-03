<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePuskesmasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'Kode puskesmas',
            ],
            'id_kabkota' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'comment'    => 'FK ke tabel kabupaten_kota',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('id_kabkota', 'kabupaten_kota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('puskesmas', true);
    }

    public function down()
    {
        $this->forge->dropTable('puskesmas', true);
    }
}
