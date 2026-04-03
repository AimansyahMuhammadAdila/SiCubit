<?php

namespace App\Controllers;

class Riwayat extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = ['title' => 'Riwayat Medis Ibu - SI CUBIT'];
        return view('riwayat/index', $data);
    }
} 