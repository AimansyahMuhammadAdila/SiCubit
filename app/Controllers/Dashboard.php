<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title'    => 'Dashboard SI CUBIT',
            'nama_ibu' => $session->get('nama') // Mengambil nama asli dari session
        ];

        return view('dashboard/index', $data);
    }

    public function indexAdmin()
    {
        $session = session();
        // Opsional: Tambahkan pengecekan role admin di sini jika ada
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title'      => 'Admin Dashboard - SI CUBIT',
            'admin_name' => 'Bidan Nurul',
            'puskesmas'  => 'Puskesmas Rantau',
            'stats'      => [
                'total_bunda'        => 124,
                'pending_validation' => 12,
                'high_risk'          => 5
            ]
        ];
        return view('admin/dashboard', $data);
    }

    public function dataIbu()
    {
        $session = session();
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title'     => 'Data Ibu & Anak - SI CUBIT',
            'puskesmas' => 'Puskesmas Rantau'
        ];
        return view('admin/data_ibu', $data);
    }

    public function detail($id)
    {
        $session = session();
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $data = ['id' => $id];
        return view('admin/detail_ibu', $data);
    }

    public function statistik()
    {
        $session = session();
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Statistik - SI CUBIT'
        ];
        return view('statistik/index', $data);
    }
}