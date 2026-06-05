<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiCubitSeeder extends Seeder
{
    public function run()
    {
        // 1. Kabupaten / Kota
        $dataKabupaten = [
            ['id' => '3201', 'nama' => 'Kabupaten Bogor', 'tipe' => 'Kabupaten', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => '3271', 'nama' => 'Kota Bogor', 'tipe' => 'Kota', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('kabupaten_kota')->ignore(true)->insertBatch($dataKabupaten);

        // 2. Puskesmas
        $dataPuskesmas = [
            ['id' => 'P320101', 'id_kabkota' => '3201', 'nama' => 'Puskesmas Cibinong', 'alamat' => 'Jl. Tegar Beriman', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 'P327101', 'id_kabkota' => '3271', 'nama' => 'Puskesmas Bogor Tengah', 'alamat' => 'Jl. Pajajaran', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('puskesmas')->ignore(true)->insertBatch($dataPuskesmas);

        // 3. Users (Admin dan Ibu)
        $dataUsers = [
            [
                'nama' => 'Admin Utama',
                'role' => 'admin',
                'status_kehamilan' => null,
                'umur' => 30,
                'pekerjaan' => 'PNS',
                'jumlah_anak' => 0,
                'no_telp' => '081234567890',
                'alamat' => 'Kantor Dinkes',
                'id_kabkota' => '3271',
                'id_puskesmas' => null,
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Ibu Siti Aminah',
                'role' => 'ibu',
                'status_kehamilan' => 'pasca_melahirkan',
                'umur' => 28,
                'pekerjaan' => 'Ibu Rumah Tangga',
                'jumlah_anak' => 1,
                'no_telp' => '081298765432',
                'alamat' => 'Perumahan Asri Indah No 10',
                'id_kabkota' => '3201',
                'id_puskesmas' => 'P320101',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('users')->insertBatch($dataUsers);

        // Ambil ID ibu yang baru diinsert
        $ibuId = $this->db->insertID(); 

        // 4. Artikel
        $dataArtikel = [
            [
                'judul' => 'Cara Menyusui yang Benar',
                'slug' => 'cara-menyusui-yang-benar',
                'thumbnail_url' => 'default.png',
                'isi_konten' => 'Menyusui adalah proses alami... (konten edukasi)',
                'id_penulis' => 1, // ID Admin
                'status' => 'published',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('artikel')->insertBatch($dataArtikel);

        // 5. Video
        $dataVideo = [
            [
                'judul' => 'Video Panduan Laktasi',
                'video_url' => 'https://youtube.com/watch?v=dummy',
                'deskripsi' => 'Panduan lengkap cara memposisikan bayi saat menyusu',
                'id_penulis' => 1, // ID Admin
                'status' => 'published',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('video')->insertBatch($dataVideo);

        // 6. Riwayat Pra Kehamilan
        $dataRiwayatPraHamil = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'bb_sebelum_hamil' => 55.5,
                'riwayat_penyakit' => 'Tidak ada',
                'riwayat_abortus' => 'Tidak',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('riwayat_pra_kehamilan')->insertBatch($dataRiwayatPraHamil);

        // 7. Riwayat Kehamilan
        $dataRiwayatHamil = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'kehamilan_ke' => 1,
                'umur_kehamilan' => 38,
                'bb' => 65.0,
                'kadar_hb' => 11.5,
                'ukuran_lila' => 24.5,
                'kunjungan_anc' => 6,
                'konsumsi_ttd' => 'Ya',
                'periksa_hiv' => 'Ya',
                'periksa_hbsag' => 'Ya',
                'info_kespro' => 'Ya',
                'status_bahagia' => 'Ya',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('riwayat_kehamilan')->insertBatch($dataRiwayatHamil);

        // 8. Riwayat Persalinan
        $dataRiwayatSalin = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'cara_persalinan' => 'Normal',
                'umur_kehamilan_salin' => 39,
                'imd' => 'Ya',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('riwayat_persalinan')->insertBatch($dataRiwayatSalin);

        // 9. Data Bayi
        $dataBayi = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'nama_bayi' => 'Budi',
                'jenis_kelamin' => 'L',
                'tgl_lahir' => date('Y-m-d', strtotime('-1 month')),
                'golongan_darah' => 'O',
                'bb' => 3.2,
                'pb' => 50.0,
                'lingkar_kepala' => 35.0,
                'lingkar_dada' => 33.0,
                'lingkar_lengan' => 11.0,
                'suhu' => 36.5,
                'reflek_mencari_puting' => 'Ya',
                'reflek_mengisap' => 'Ya',
                'reflek_menelan' => 'Ya',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('data_bayi')->insertBatch($dataBayi);

        // 10. Kondisi Kejiwaan Ibu
        $dataKejiwaan = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'khawatir_berlebihan' => 'Tidak',
                'gelisah' => 'Tidak',
                'gemetar' => 'Tidak',
                'tidak_dapat_rileks' => 'Tidak',
                'ketegangan_otot' => 'Tidak',
                'sakit_kepala' => 'Tidak',
                'jantung_berdebar' => 'Tidak',
                'berkeringat_berlebihan' => 'Tidak',
                'sesak_napas' => 'Tidak',
                'kepala_terasa_ringan' => 'Tidak',
                'keluhan_ulu_hati' => 'Tidak',
                'lelah_sulit_tidur' => 'Ya', // Contoh ada sedikit kelelahan
                'mudah_tersinggung' => 'Tidak',
                'perubahan_hubungan_suami' => 'Tidak',
                'skor_kejiwaan' => 1,
                'status_kejiwaan' => 'Normal',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('kondisi_kejiwaan_ibu')->insertBatch($dataKejiwaan);

        // 11. Cek Kelancaran ASI
        $dataKelancaranAsi = [
            [
                'user_id' => $ibuId,
                'tgl_pengisian' => date('Y-m-d'),
                'kondisi_puting' => 'Normal',
                'frekuensi_menyusui' => 10,
                'lama_menyusui' => 15,
                'frekuensi_bab_bayi' => 4,
                'frekuensi_bak_bayi' => 6,
                'support_suami_menyusui' => 'Ya',
                'support_suami_gizi' => 'Ya',
                'bayi_tidur_12jam' => 'Ya',
                'bayi_tenang_setelah_menyusu' => 'Ya',
                'warna_urin_bayi' => 'Jernih',
                'payudara_penuh' => 'Ya',
                'volume_pumping' => 50.0,
                'bb_naik_sesuai_usia' => 'Ya',
                'kondisi_lainnya' => 'Lancar dan tidak ada kendala',
                'status_kecukupan_asi' => 'Ya',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('cek_kelancaran_asi')->insertBatch($dataKelancaranAsi);
    }
}
