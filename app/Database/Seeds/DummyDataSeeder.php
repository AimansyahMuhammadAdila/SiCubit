<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        
        $names = ['Aminah', 'Aisyah', 'Budi', 'Cantika', 'Diana', 'Euis', 'Fitri', 'Gita', 'Hani', 'Indah', 'Juleha', 'Kartini', 'Lestari', 'Marni', 'Nina'];
        $last_names = ['Sari', 'Lestari', 'Wijaya', 'Putri', 'Ramadhani', 'Kusuma', 'Permata'];
        $jobs = ['Ibu Rumah Tangga', 'Guru', 'Karyawan Swasta', 'PNS', 'Bidan', 'Pedagang'];
        $kabkotas = ['6371', '6372', '6303', '6301'];
        $puskesmas_map = [
            '6371' => ['P637101', 'P637102', 'P637103'],
            '6372' => ['P637201', 'P637202', 'P637203'],
            '6303' => ['P630301', 'P630302', 'P630303'],
            '6301' => ['P630101', 'P630102', 'P630103']
        ];
        
        // Generate 20 Dummy Users Ibu
        for ($i = 0; $i < 20; $i++) {
            $id_kabkota = $kabkotas[array_rand($kabkotas)];
            $id_puskesmas = $puskesmas_map[$id_kabkota][array_rand($puskesmas_map[$id_kabkota])];
            $status_kehamilan = ['pra_kehamilan', 'hamil', 'pasca_melahirkan'][array_rand(['pra_kehamilan', 'hamil', 'pasca_melahirkan'])];
            
            $userData = [
                'nama' => 'Ibu ' . $names[array_rand($names)] . ' ' . $last_names[array_rand($last_names)],
                'role' => 'user',
                'status_kehamilan' => $status_kehamilan,
                'umur' => rand(20, 40),
                'pekerjaan' => $jobs[array_rand($jobs)],
                'jumlah_anak' => rand(0, 3),
                'no_telp' => '08' . rand(100000000, 999999999),
                'alamat' => 'Jl. Mawar No. ' . rand(1, 100) . ', RT ' . rand(1, 10),
                'id_kabkota' => $id_kabkota,
                'id_puskesmas' => $id_puskesmas,
                'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => $now,
                'updated_at' => $now,
            ];
            
            $this->db->table('users')->insert($userData);
            $userId = $this->db->insertID();
            
            // 1. Riwayat Kehamilan
            $this->db->table('riwayat_kehamilan')->insert([
                'user_id' => $userId,
                'tgl_pengisian' => date('Y-m-d', strtotime('-' . rand(0, 30) . ' days')),
                'kehamilan_ke' => rand(1, 3),
                'umur_kehamilan' => rand(10, 40),
                'bb' => rand(500, 800) / 10,
                'kadar_hb' => rand(100, 140) / 10,
                'ukuran_lila' => rand(230, 300) / 10,
                'kunjungan_anc' => rand(0, 6),
                'konsumsi_ttd' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                'periksa_hiv' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                'periksa_hbsag' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                'info_kespro' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                'status_bahagia' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                'created_at' => $now,
            ]);
            
            // 2. Data Bayi & ASI (Jika pasca melahirkan)
            if ($status_kehamilan == 'pasca_melahirkan') {
                $this->db->table('data_bayi')->insert([
                    'user_id' => $userId,
                    'tgl_pengisian' => $now,
                    'nama_bayi' => 'Bayi ' . $names[array_rand($names)],
                    'jenis_kelamin' => ['L', 'P'][array_rand(['L', 'P'])],
                    'tgl_lahir' => date('Y-m-d', strtotime('-' . rand(1, 300) . ' days')),
                    'golongan_darah' => ['A', 'B', 'AB', 'O', 'Belum Tahu'][array_rand(['A', 'B', 'AB', 'O', 'Belum Tahu'])],
                    'bb' => rand(25, 40) / 10,
                    'pb' => rand(45, 55),
                    'suhu' => rand(365, 375) / 10,
                    'created_at' => $now,
                ]);
                
                $this->db->table('cek_kelancaran_asi')->insert([
                    'user_id' => $userId,
                    'tgl_pengisian' => $now,
                    'kondisi_puting' => ['Normal', 'Lecet'][array_rand(['Normal', 'Lecet'])],
                    'frekuensi_menyusui' => rand(6, 12),
                    'lama_menyusui' => rand(10, 30),
                    'frekuensi_bab_bayi' => rand(2, 6),
                    'frekuensi_bak_bayi' => rand(4, 8),
                    'status_kecukupan_asi' => ['Ya', 'Tidak'][array_rand(['Ya', 'Tidak'])],
                    'created_at' => $now,
                ]);
            }
            
            // 3. Kondisi Kejiwaan Ibu
            $statusKejiwaan = ['Normal', 'Perlu Perhatian', 'Berisiko'][array_rand(['Normal', 'Perlu Perhatian', 'Berisiko'])];
            $this->db->table('kondisi_kejiwaan_ibu')->insert([
                'user_id' => $userId,
                'tgl_pengisian' => $now,
                'status_kejiwaan' => $statusKejiwaan,
                'skor_kejiwaan' => $statusKejiwaan == 'Berisiko' ? rand(8, 14) : rand(0, 5),
                'created_at' => $now,
            ]);
        }
        
        echo "Berhasil menggenerate 20 data dummy untuk user beserta seluruh riwayatnya (kehamilan, bayi, dll)!\n";
    }
}
