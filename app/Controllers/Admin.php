<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        // PROTEKSI: Jika bukan admin, tendang ke login admin
        if (!session()->get('is_admin')) {
            // Gunakan redirect dengan script atau session flash agar user tahu
            header('Location: ' . base_url('admin/login'));
            exit;
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Statistik Dinamis
        $data = [
            'title'        => 'Panel Kendali Bidan - SI CUBIT',
            'totalIbu'     => $db->table('users')->where('role', 'user')->countAllResults(),
            'perluCek'     => $db->table('riwayat_kehamilan')->countAllResults(),
            'resikoTinggi' => $db->table('kondisi_kejiwaan_ibu')->where('status_kejiwaan', 'Berisiko')->countAllResults(),
            // Ambil data ibu terbaru dengan join wilayah
            'users'        => $this->getLatestUsers()
        ];

        return view('admin/dashboard', $data);
    }

    public function dataIbu()
    {
        $db = \Config\Database::connect();
        $data = [
            'title'     => 'Data Ibu & Anak - SI CUBIT',
            'users'     => $this->getLatestUsers(),
            'wilayah'   => $db->table('kabupaten_kota')->orderBy('nama', 'ASC')->get()->getResultArray(),
            'puskesmas' => $db->table('puskesmas')->orderBy('nama', 'ASC')->get()->getResultArray()
        ];
        return view('admin/data_ibu', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        
        // Find user by id
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ibu tidak ditemukan.");
        }
        
        // Find Puskesmas & Kabkota names
        $puskesmas = $db->table('puskesmas')->where('id', $user['id_puskesmas'])->get()->getRowArray();
        $kabkota = $db->table('kabupaten_kota')->where('id', $user['id_kabkota'])->get()->getRowArray();
        $user['nama_puskesmas'] = $puskesmas['nama'] ?? '-';
        $user['nama_kabkota'] = $kabkota['nama'] ?? '-';

        // Retrieve historical checks
        $asiModel = new \App\Models\AsiModel();
        $kejiwaanModel = new \App\Models\KondisiKejiwaanIbuModel();
        $dataBayiModel = new \App\Models\DataBayiModel();
        $persalinanModel = new \App\Models\RiwayatPersalinanModel();
        $kehamilanModel = new \App\Models\RiwayatKehamilanModel();
        $praKehamilanModel = new \App\Models\RiwayatPraKehamilanModel();

        $data = [
            'title' => 'Detail Informasi Ibu - SI CUBIT',
            'user' => $user,
            'riwayat_asi' => $asiModel->getByUser($id),
            'riwayat_kejiwaan' => $kejiwaanModel->getByUser($id),
            'riwayat_bayi' => $dataBayiModel->getByUser($id),
            'persalinan' => $persalinanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
            'kehamilan' => $kehamilanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
            'pra_kehamilan' => $praKehamilanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
        ];
        
        return view('admin/detail_ibu', $data);
    }

    private function getLatestUsers()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.*, puskesmas.nama as nama_puskesmas, kabupaten_kota.nama as nama_kabkota');
        $builder->join('puskesmas', 'puskesmas.id = users.id_puskesmas', 'left');
        $builder->join('kabupaten_kota', 'kabupaten_kota.id = users.id_kabkota', 'left');
        $builder->where('users.role', 'user');
        $builder->orderBy('users.created_at', 'DESC');
        
        $users = $builder->get()->getResultArray();

        // Tambahkan status ASI terakhir
        foreach ($users as &$u) {
            $asi = $db->table('cek_kelancaran_asi')
                      ->where('user_id', $u['id'])
                      ->orderBy('tgl_pengisian', 'DESC')
                      ->get()->getRowArray();
            $u['status_asi'] = $asi['status_kecukupan_asi'] ?? 'BELUM ISI';
        }

        return $users;
    }
}