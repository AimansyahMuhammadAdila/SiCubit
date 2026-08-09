<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriVideoTable extends Migration
{
    public function up()
    {
        // 1. Buat Tabel kategori_video
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
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
        $this->forge->createTable('kategori_video', true);

        // Insert beberapa kategori default
        $db = \Config\Database::connect();
        $db->table('kategori_video')->insertBatch([
            ['nama_kategori' => 'Laktasi & Menyusui', 'slug' => 'laktasi-menyusui', 'deskripsi' => 'Panduan lengkap seputar posisi menyusui, perlekatan, dan kelancaran ASI', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Nutrisi & MPASI', 'slug' => 'nutrisi-mpasi', 'deskripsi' => 'Resep dan tips pemberian makanan pendamping ASI untuk tumbuh kembang bayi', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Kesehatan Ibu & Kehamilan', 'slug' => 'kesehatan-ibu-kehamilan', 'deskripsi' => 'Edukasi perawatan masa hamil, persalinan, dan nifas', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Tumbuh Kembang Anak', 'slug' => 'tumbuh-kembang-anak', 'deskripsi' => 'Stimulasi dan pemantauan perkembangan motorik bayi & anak', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        // 2. Tambahkan kolom id_kategori ke tabel video (jika belum ada)
        if (!$db->fieldExists('id_kategori', 'video')) {
            $fields = [
                'id_kategori' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'video_url'
                ]
            ];
            $this->forge->addColumn('video', $fields);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->fieldExists('id_kategori', 'video')) {
            $this->forge->dropColumn('video', 'id_kategori');
        }
        $this->forge->dropTable('kategori_video', true);
    }
}
