<?php

namespace App\Controllers;

use App\Models\AsiModel;
use App\Models\KondisiKejiwaanIbuModel;
use App\Models\RiwayatPersalinanModel;

class Laktasi extends BaseController
{
    public function cek()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Cek Kelancaran ASI - SI CUBIT',
        ];
        
        return view('laktasi/kelancaran_asi', $data);
    }

    public function formBayi()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Data Bayi - SI CUBIT',
        ];
        return view('laktasi/form_bayi', $data);
    }

    public function kejiwaan()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Screening Kondisi Kejiwaan - SI CUBIT',
        ];
        return view('assessment/kejiwaan', $data);
    }

    public function hasilAsi()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $userId = session('user_id');
        $asiModel = new AsiModel();
        $persalinanModel = new RiwayatPersalinanModel();
        
        $latest = $asiModel->getLatestByUser($userId);
        $persalinan = $persalinanModel->where('user_id', $userId)->orderBy('tgl_pengisian', 'DESC')->first();
        
        $data = [
            'title' => 'Hasil Evaluasi Kelancaran ASI - SI CUBIT',
            'latest' => $latest,
            'persalinan' => $persalinan,
        ];
        
        return view('laktasi/hasil_asi', $data);
    }

    public function hasilKejiwaan()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $userId = session('user_id');
        $kejiwaanModel = new KondisiKejiwaanIbuModel();
        
        $latest = $kejiwaanModel->getLatestByUser($userId);
        
        $data = [
            'title' => 'Hasil Screening Kejiwaan - SI CUBIT',
            'latest' => $latest,
        ];
        
        return view('assessment/hasil_kejiwaan', $data);
    }
}