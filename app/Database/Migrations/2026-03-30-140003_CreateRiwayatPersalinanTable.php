<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatPersalinanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_ibu' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tgl_pengisian' => [
                'type' => 'DATE',
            ],
            'cara_persalinan' => [
                'type'       => 'ENUM',
                'constraint' => ['Normal', 'Sectio Caesarea'],
            ],
            'umur_kehamilan_salin' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Umur kehamilan saat persalinan (minggu)',
            ],
            'imd' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
                'comment'    => 'Inisiasi Menyusu Dini',
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
        $this->forge->addForeignKey('id_ibu', 'ibu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_persalinan', true);
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_persalinan', true);
    }
}
