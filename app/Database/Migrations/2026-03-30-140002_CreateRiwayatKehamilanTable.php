<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatKehamilanTable extends Migration
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
            'kehamilan_ke' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
            ],
            'umur_kehamilan' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Dalam minggu',
            ],
            'bb' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'comment'    => 'Berat badan saat hamil (kg)',
            ],
            'kadar_hb' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
                'comment'    => 'Kadar Hemoglobin (g/dL)',
            ],
            'ukuran_lila' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
                'comment'    => 'Lingkar Lengan Atas (cm)',
            ],
            'kunjungan_anc' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
                'comment'    => 'Jumlah kunjungan ANC',
            ],
            'konsumsi_ttd' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
                'comment'    => 'Konsumsi Tablet Tambah Darah',
            ],
            'periksa_hiv' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'periksa_hbsag' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'info_kespro' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
                'comment'    => 'Mendapat info kesehatan reproduksi',
            ],
            'status_bahagia' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
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
        $this->forge->createTable('riwayat_kehamilan', true);
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_kehamilan', true);
    }
}
