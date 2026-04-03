<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCekKelancaranAsiTable extends Migration
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
            'kondisi_puting' => [
                'type'       => 'ENUM',
                'constraint' => ['Normal', 'Lecet', 'Datar', 'Tenggelam'],
                'default'    => 'Normal',
            ],
            'frekuensi_menyusui' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Frekuensi menyusui per hari',
            ],
            'lama_menyusui' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Durasi menyusui per sesi (menit)',
            ],
            'frekuensi_bab_bayi' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Frekuensi BAB bayi per hari',
            ],
            'frekuensi_bak_bayi' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'comment'    => 'Frekuensi BAK bayi per hari',
            ],
            'support_suami_menyusui' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
            ],
            'support_suami_gizi' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
            ],
            'bayi_tidur_12jam' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'comment'    => 'Bayi tidur minimal 12 jam per hari',
            ],
            'bayi_tenang_setelah_menyusu' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
            ],
            'warna_urin_bayi' => [
                'type'       => 'ENUM',
                'constraint' => ['Jernih', 'Kuning Muda', 'Kuning Pekat'],
                'default'    => 'Jernih',
            ],
            'payudara_penuh' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Ya',
                'comment'    => 'Payudara terasa penuh sebelum menyusui',
            ],
            'volume_pumping' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,1',
                'null'       => true,
                'comment'    => 'Volume ASI perah (ml)',
            ],
            'status_kecukupan_asi' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'comment'    => 'Hasil kalkulasi kecukupan ASI',
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
        $this->forge->createTable('cek_kelancaran_asi', true);
    }

    public function down()
    {
        $this->forge->dropTable('cek_kelancaran_asi', true);
    }
}
