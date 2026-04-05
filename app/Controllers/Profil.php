<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        // 1. Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $userId = session()->get('user_id');
        
        // 2. Ambil data Ibu dari tabel users
        $ibu = $userModel->getUserWithWilayah($userId);

        // 3. JIKA DATA TIDAK DITEMUKAN, tendang balik ke login atau beri nilai default
        if (!$ibu) {
            session()->destroy(); // Hapus session yang nyangkut
            return redirect()->to(base_url('login'))->with('error', 'Sesi habis atau data tidak ditemukan.');
        }

        $data = [
            'title' => 'Profil Bunda - SI CUBIT',
            'ibu'   => $ibu
        ];

        return view('profil/index', $data);
    }
    public function edit()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new \App\Models\UserModel();
        $userId    = session()->get('user_id');
        $ibu       = $userModel->getUserWithWilayah($userId);

        if (!$ibu) {
            return redirect()->to(base_url('profil'))->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Profil - SI CUBIT',
            'ibu'   => $ibu
        ];

        return view('profil/edit', $data);
    }
}