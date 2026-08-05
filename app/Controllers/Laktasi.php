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
        
        $allRecords = $kejiwaanModel->getByUser($userId);
        $latest = !empty($allRecords) ? $allRecords[0] : null;

        if ($latest) {
            // Gabungkan nilai EPDS jika record paling atas belum memilikinya
            if (!isset($latest['epds_skor']) || $latest['epds_skor'] === null) {
                foreach ($allRecords as $rec) {
                    if (isset($rec['epds_skor']) && $rec['epds_skor'] !== null && $rec['epds_skor'] > 0) {
                        $latest['epds_skor'] = $rec['epds_skor'];
                        $latest['epds_status'] = $rec['epds_status'];
                        $latest['epds_q10'] = $rec['epds_q10'];
                        for ($i = 1; $i <= 10; $i++) {
                            $latest["epds_q$i"] = $rec["epds_q$i"];
                        }
                        break;
                    }
                }
            }

            // Gabungkan nilai Gejala Cemas & Fisik jika record paling atas belum memilikinya
            if (!isset($latest['skor_kejiwaan']) || $latest['skor_kejiwaan'] === null) {
                foreach ($allRecords as $rec) {
                    if (isset($rec['skor_kejiwaan']) && $rec['skor_kejiwaan'] !== null) {
                        $latest['skor_kejiwaan'] = $rec['skor_kejiwaan'];
                        $latest['status_kejiwaan'] = $rec['status_kejiwaan'];
                        break;
                    }
                }
            }
        }
        
        $data = [
            'title' => 'Hasil Screening Kejiwaan - SI CUBIT',
            'latest' => $latest,
        ];
        
        return view('assessment/hasil_kejiwaan', $data);
    }
}