<?php

namespace App\Controllers;

class Riwayat extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $statusKehamilan = session()->get('status_kehamilan') ?? 'pasca_melahirkan';

        $data = [
            'title' => 'Riwayat Medis Ibu - SI CUBIT',
            'status_kehamilan' => $statusKehamilan
        ];
        return view('riwayat/index', $data);
    }
} 