<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKondisiKejiwaanIbuTable extends Migration
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
            // Pertanyaan 1: Khawatir berlebihan
            'khawatir_berlebihan' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            // Pertanyaan 2a-j: Ketegangan fisik
            'gelisah' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'gemetar' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'tidak_dapat_rileks' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'ketegangan_otot' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'sakit_kepala' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'jantung_berdebar' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'berkeringat_berlebihan' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'sesak_napas' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'kepala_terasa_ringan' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            'keluhan_ulu_hati' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            // Pertanyaan 3: Lelah tapi sulit tidur
            'lelah_sulit_tidur' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            // Pertanyaan 4: Mudah tersinggung dan marah
            'mudah_tersinggung' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            // Pertanyaan 5: Perubahan hubungan dengan suami
            'perubahan_hubungan_suami' => [
                'type'       => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default'    => 'Tidak',
            ],
            // Skor dan status hasil screening
            'skor_kejiwaan' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
                'comment'    => 'Skor total dari semua pertanyaan',
            ],
            'status_kejiwaan' => [
                'type'       => 'ENUM',
                'constraint' => ['Normal', 'Perlu Perhatian', 'Berisiko'],
                'default'    => 'Normal',
                'comment'    => 'Hasil screening kondisi kejiwaan',
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
        $this->forge->createTable('kondisi_kejiwaan_ibu', true);
    }

    public function down()
    {
        $this->forge->dropTable('kondisi_kejiwaan_ibu', true);
    }
}
