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
            'perluCek'     => $db->table('riwayat_kehamilan')->where('status_validasi', 'pending')->countAllResults(),
            'resikoTinggi' => $db->table('riwayat_kehamilan')->where('kategori_resiko', 'Tinggi')->countAllResults(),
            // Ambil data ibu terbaru dengan join wilayah
            'users'        => $this->getLatestUsers()
        ];

        return view('admin/dashboard', $data);
    }

    public function dataIbu()
    {
        $data = [
            'title' => 'Data Ibu & Anak - SI CUBIT',
            'users' => $this->getLatestUsers()
        ];
        return view('admin/data_ibu', $data);
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