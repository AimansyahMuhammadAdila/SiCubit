<?php

namespace App\Controllers;

class Laktasi extends BaseController
{
    public function cek()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Cek Kelancaran ASI - SI CUBIT',
        ];
        
        return view('laktasi/cek', $data);
    }
}