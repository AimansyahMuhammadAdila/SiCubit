<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriArtikelTable extends Migration
{
    public function up()
    {
        // 1. Buat Tabel kategori_artikel
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
        $this->forge->createTable('kategori_artikel', true);

        // Insert beberapa kategori default
        $db = \Config\Database::connect();
        $db->table('kategori_artikel')->insertBatch([
            ['nama_kategori' => 'Laktasi & Menyusui', 'slug' => 'laktasi-menyusui', 'deskripsi' => 'Artikel panduan posisi menyusui, manajemen ASI, dan perawatan payudara', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Nutrisi & MPASI', 'slug' => 'nutrisi-mpasi', 'deskripsi' => 'Berita dan tips pemenuhan gizi ibu serta makanan pendamping ASI anak', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Kesehatan Ibu & Kehamilan', 'slug' => 'kesehatan-ibu-kehamilan', 'deskripsi' => 'Panduan kesehatan masa kehamilan, pasca persalinan, dan kejiwaan ibu', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Tumbuh Kembang Anak', 'slug' => 'tumbuh-kembang-anak', 'deskripsi' => 'Artikel seputar stimulasi motorik, kesehatan bayi, dan tumbuh kembang balita', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        // 2. Tambahkan kolom id_kategori ke tabel artikel (jika belum ada)
        if (!$db->fieldExists('id_kategori', 'artikel')) {
            $fields = [
                'id_kategori' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'thumbnail_url'
                ]
            ];
            $this->forge->addColumn('artikel', $fields);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->fieldExists('id_kategori', 'artikel')) {
            $this->forge->dropColumn('artikel', 'id_kategori');
        }
        $this->forge->dropTable('kategori_artikel', true);
    }
}
