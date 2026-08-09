<?php

namespace App\Controllers;

use App\Models\RiwayatPraKehamilanModel;
use App\Models\RiwayatKehamilanModel;

class Riwayat extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) return redirect()->to(base_url('login'));

        $userId = $session->get('user_id') ?? $session->get('id');
        $statusKehamilan = $session->get('status_kehamilan') ?? 'pasca_melahirkan';

        $praModel = new RiwayatPraKehamilanModel();
        $hamilModel = new RiwayatKehamilanModel();

        $hasPraKehamilan = false;
        $hasKehamilan = false;

        if ($userId) {
            $hasPraKehamilan = !empty($praModel->getByUser($userId));
            $hasKehamilan = !empty($hamilModel->getByUser($userId));
        }

        $data = [
            'title'             => 'Riwayat Medis Ibu - SI CUBIT',
            'status_kehamilan'  => $statusKehamilan,
            'has_pra_kehamilan' => $hasPraKehamilan,
            'has_kehamilan'     => $hasKehamilan,
        ];

        return view('riwayat/index', $data);
    }
} 