<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataBayiTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tgl_pengisian' => [
                'type' => 'DATE',
            ],
            'golongan_darah' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'AB', 'O'],
                'null'       => true,
            ],
            'berat_badan' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,2',
                'null'       => true,
                'comment'    => 'Berat badan bayi (gram)',
            ],
            'panjang_badan' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Panjang badan bayi (cm)',
            ],
            'lingkar_kepala' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Lingkar kepala bayi (cm)',
            ],
            'lingkar_dada' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Lingkar dada bayi (cm)',
            ],
            'lingkar_lengan_atas' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Lingkar lengan atas bayi (cm)',
            ],
            'suhu' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
                'comment'    => 'Suhu tubuh bayi (Celsius)',
            ],
            'reflek_mencari_puting' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'comment'    => 'Rooting reflex',
            ],
            'reflek_mengisap' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'comment'    => 'Sucking reflex',
            ],
            'reflek_menelan' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'comment'    => 'Swallowing reflex',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_bayi', true);
    }

    public function down()
    {
        $this->forge->dropTable('data_bayi', true);
    }
}
