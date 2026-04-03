<?php

namespace App\Controllers;

use App\Models\IbuModel;

class Profil extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Panggil model untuk mengambil data ibu dari database
        $ibuModel = new IbuModel();
        $ibuData  = $ibuModel->find($session->get('id_ibu'));

        $data = [
            'title' => 'Profil Bunda - SI CUBIT',
            'ibu'   => $ibuData // Kirim data mentah ke view
        ];
        
        return view('profil/index', $data);
    }
}