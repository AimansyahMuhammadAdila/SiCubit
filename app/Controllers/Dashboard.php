<?php

namespace App\Controllers;
use App\Models\AsiModel;
class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Cek apakah user sudah login
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // 1b. Jika role admin/bidan, arahkan ke dashboard admin
        $role = $session->get('role');
        if ($role === 'admin' || $role === 'bidan') {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $userId = $session->get('user_id');
        $namaIbu = $session->get('nama'); // Ambil nama dari session

        // 2. Ambil data Evaluasi ASI Terakhir
        $asiModel = new AsiModel();
        $latestAsi = $asiModel->getLatestByUser($userId);

        // 3. Ambil data status kehamilan dari DB
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();
        $statusKehamilan = $user['status_kehamilan'] ?? 'pasca_melahirkan';

        // 4. Buat kumpulan Tips Acak agar dinamis
        $kumpulanTips = [
            [
                'judul' => 'Jangan berkecil hati Bunda!',
                'isi' => 'Yuk cukupi kebutuhan ASI si kecil. Tonton video edukasi memperlancar ASI sekarang.'
            ],
            [
                'judul' => 'Tetap Terhidrasi ya Bun!',
                'isi' => 'Pastikan Bunda minum air minimal 3 liter sehari agar produksi ASI tetap lancar dan melimpah.'
            ],
            [
                'judul' => 'Keajaiban Pijat Oksitosin',
                'isi' => 'Minta bantuan suami untuk pijat punggung ya Bun, sangat ampuh memicu hormon bahagia untuk ASI.'
            ],
            [
                'judul' => 'Posisi Menentukan Prestasi',
                'isi' => 'Pastikan pelekatan (latch on) mulut bayi sudah benar agar puting Bunda tidak lecet.'
            ]
        ];
        $tipAcak = $kumpulanTips[array_rand($kumpulanTips)];

        // 5. Kirim data ke View
        $data = [
            'title' => 'Dashboard - SI CUBIT',
            'nama_ibu' => $namaIbu,
            'latestAsi' => $latestAsi,
            'status_kehamilan' => $statusKehamilan,
            'tip' => $tipAcak
        ];

        return view('dashboard/index', $data); // Sesuaikan lokasi view jika ada di dalam folder
    }

    public function indexAdmin()
    {
        $db = \Config\Database::connect();

        // 1. Hitung Statistik
        $totalIbu = $db->table('users')->where('role', 'user')->countAllResults();
        $perluCek = $db->table('riwayat_kehamilan')->countAllResults();
        $resikoTinggi = $db->table('kondisi_kejiwaan_ibu')->where('status_kejiwaan', 'Berisiko')->countAllResults();

        // 2. Ambil Data Tabel (JOIN dengan Puskesmas dan Kabkota)
        $builder = $db->table('users');
        $builder->select('users.*, puskesmas.nama as nama_puskesmas, kabupaten_kota.nama as nama_kabkota');
        $builder->join('puskesmas', 'puskesmas.id = users.id_puskesmas', 'left');
        $builder->join('kabupaten_kota', 'kabupaten_kota.id = users.id_kabkota', 'left');
        $builder->where('users.role', 'user');
        $builder->orderBy('users.created_at', 'DESC');
        $users = $builder->get()->getResultArray();

        // 3. Ambil data Kelancaran ASI terbaru untuk setiap user
        foreach ($users as &$u) {
            $asi = $db->table('cek_kelancaran_asi')
                ->where('user_id', $u['id'])
                ->orderBy('tgl_pengisian', 'DESC')
                ->get()->getRowArray();
            $u['status_asi'] = $asi['status_kecukupan_asi'] ?? 'BELUM ISI';
        }

        $data = [
            'title' => 'Panel Kendali Admin - SI CUBIT',
            'totalIbu' => $totalIbu,
            'perluCek' => $perluCek,
            'resikoTinggi' => $resikoTinggi,
            'users' => $users
        ];

        return view('admin/dashboard', $data);
    }

    public function dataIbu()
    {
        $session = session();
        if (!$session->get('logged_in'))
            return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Data Ibu & Anak - SI CUBIT',
            'puskesmas' => 'Puskesmas Rantau'
        ];
        return view('admin/data_ibu', $data);
    }

    public function detail($id)
    {
        $session = session();
        if (!$session->get('logged_in'))
            return redirect()->to(base_url('login'));

        $data = ['id' => $id];
        return view('admin/detail_ibu', $data);
    }

    public function statistik()
    {
        $session = session();
        if (!$session->get('logged_in'))
            return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Statistik - SI CUBIT'
        ];
        return view('statistik/index', $data);
    }
}