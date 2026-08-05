<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiCubitDatabase extends Migration
{
    public function up()
    {
        // 1. kabupaten_kota
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
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
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kabupaten_kota', true);

        // 2. puskesmas
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'id_kabkota' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kabkota', 'kabupaten_kota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('puskesmas', true);

        // 3. users
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'ibu',
            ],
            'status_kehamilan' => [
                'type'       => 'ENUM',
                'constraint' => ['pra_kehamilan', 'hamil', 'pasca_melahirkan'],
                'null'       => true,
                'default'    => null,
            ],
            'umur' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'null'       => true,
            ],
            'pekerjaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'jumlah_anak' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
                'null'       => true,
            ],
            'no_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_kabkota' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'id_puskesmas' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kabkota', 'kabupaten_kota', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_puskesmas', 'puskesmas', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('users', true);

        // 4. artikel
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'thumbnail_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'isi_konten' => ['type' => 'TEXT'],
            'id_penulis' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'published'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penulis', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('artikel', true);

        // 5. video
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'video_url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'id_penulis' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'published'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penulis', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('video', true);

        // 6. riwayat_pra_kehamilan
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'bb_sebelum_hamil' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'riwayat_penyakit' => ['type' => 'TEXT', 'null' => true],
            'riwayat_abortus' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_pra_kehamilan', true);

        // 7. riwayat_kehamilan
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'kehamilan_ke' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'umur_kehamilan' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'bb' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'kadar_hb' => ['type' => 'DECIMAL', 'constraint' => '4,1', 'null' => true],
            'ukuran_lila' => ['type' => 'DECIMAL', 'constraint' => '4,1', 'null' => true],
            'kunjungan_anc' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'default' => 0],
            'konsumsi_ttd' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'periksa_hiv' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'periksa_hbsag' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'info_kespro' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'status_bahagia' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_kehamilan', true);

        // 8. riwayat_persalinan
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'cara_persalinan' => ['type' => 'ENUM', 'constraint' => ['Normal', 'Sectio Caesarea']],
            'umur_kehamilan_salin' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'imd' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_persalinan', true);

        // 9. data_bayi
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'nama_bayi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => true],
            'tgl_lahir' => ['type' => 'DATE', 'null' => true],
            'golongan_darah' => ['type' => 'ENUM', 'constraint' => ['A', 'B', 'AB', 'O', 'Belum Tahu'], 'default' => 'Belum Tahu'],
            'bb' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'pb' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'lingkar_kepala' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'lingkar_dada' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'lingkar_lengan' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'suhu' => ['type' => 'DECIMAL', 'constraint' => '4,1', 'null' => true],
            'reflek_mencari_puting' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'reflek_mengisap' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'reflek_menelan' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_bayi', true);

        // 10. kondisi_kejiwaan_ibu
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'khawatir_berlebihan' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'gelisah' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'gemetar' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'tidak_dapat_rileks' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'ketegangan_otot' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'sakit_kepala' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'jantung_berdebar' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'berkeringat_berlebihan' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'sesak_napas' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'kepala_terasa_ringan' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'keluhan_ulu_hati' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'lelah_sulit_tidur' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'mudah_tersinggung' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'perubahan_hubungan_suami' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Tidak'],
            'skor_kejiwaan' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'default' => 0],
            'status_kejiwaan' => ['type' => 'ENUM', 'constraint' => ['Normal', 'Perlu Perhatian', 'Berisiko'], 'default' => 'Normal'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kondisi_kejiwaan_ibu', true);

        // 11. cek_kelancaran_asi
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pengisian' => ['type' => 'DATE'],
            'kondisi_puting' => ['type' => 'ENUM', 'constraint' => ['Normal', 'Lecet', 'Datar', 'Tenggelam', 'Menonjol', 'Pecah'], 'default' => 'Normal'],
            'frekuensi_menyusui' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'lama_menyusui' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'frekuensi_bab_bayi' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'frekuensi_bak_bayi' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'support_suami_menyusui' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'support_suami_gizi' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'bayi_tidur_12jam' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'bayi_tenang_setelah_menyusu' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'warna_urin_bayi' => ['type' => 'ENUM', 'constraint' => ['Jernih', 'Kuning Muda', 'Kuning Pekat'], 'default' => 'Jernih'],
            'payudara_penuh' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya'],
            'volume_pumping' => ['type' => 'DECIMAL', 'constraint' => '6,1', 'null' => true],
            'bb_naik_sesuai_usia' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak'], 'default' => 'Ya', 'null' => true],
            'kondisi_lainnya' => ['type' => 'TEXT', 'null' => true],
            'status_kecukupan_asi' => ['type' => 'ENUM', 'constraint' => ['Ya', 'Tidak']],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cek_kelancaran_asi', true);
    }

    public function down()
    {
        $this->forge->dropTable('cek_kelancaran_asi', true);
        $this->forge->dropTable('kondisi_kejiwaan_ibu', true);
        $this->forge->dropTable('data_bayi', true);
        $this->forge->dropTable('riwayat_persalinan', true);
        $this->forge->dropTable('riwayat_kehamilan', true);
        $this->forge->dropTable('riwayat_pra_kehamilan', true);
        $this->forge->dropTable('video', true);
        $this->forge->dropTable('artikel', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('puskesmas', true);
        $this->forge->dropTable('kabupaten_kota', true);
    }
}
