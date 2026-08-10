<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RiwayatPraKehamilanModel;
use App\Models\RiwayatKehamilanModel;
use App\Models\RiwayatPersalinanModel;
use App\Models\AsiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataReadAction extends BaseController
{
    protected ?UserModel                $userModel = null;
    protected ?RiwayatPraKehamilanModel $praKehamilanModel = null;
    protected ?RiwayatKehamilanModel    $kehamilanModel = null;
    protected ?RiwayatPersalinanModel   $persalinanModel = null;
    protected ?AsiModel                 $asiModel = null;

    public function __construct()
    {
        try {
            $this->userModel         = new UserModel();
            $this->praKehamilanModel = new RiwayatPraKehamilanModel();
            $this->kehamilanModel    = new RiwayatKehamilanModel();
            $this->persalinanModel   = new RiwayatPersalinanModel();
            $this->asiModel          = new AsiModel();
        } catch (\Throwable $e) {}
    }

    // ---------------------------------------------------------------
    // GET /api/profil — Data profil ibu yang sedang login
    // ---------------------------------------------------------------
    public function profil(): ResponseInterface
    {
        $userId = session('user_id') ?: 1;
        try {
            $user = $this->userModel ? ($this->userModel->getUserWithWilayah($userId) ?: $this->userModel->find($userId)) : null;
        } catch (\Throwable $e) {
            $user = null;
        }

        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data user tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Hapus password_hash dari response
        unset($user['password_hash']);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $user,
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/riwayat — Semua riwayat (pra-hamil, hamil, persalinan)
    // ---------------------------------------------------------------
    public function riwayat(): ResponseInterface
    {
        $userId = session('user_id');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'pra_kehamilan' => $this->praKehamilanModel->getByUser($userId),
                'kehamilan'     => $this->kehamilanModel->getByUser($userId),
                'persalinan'    => $this->persalinanModel->getByUser($userId),
            ],
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/cek-asi — Semua riwayat cek kelancaran ASI
    // ---------------------------------------------------------------
    public function cekAsi(): ResponseInterface
    {
        $userId = session('user_id');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $this->asiModel->getByUser($userId),
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/cek-asi/latest — Cek ASI terakhir
    // ---------------------------------------------------------------
    public function cekAsiLatest(): ResponseInterface
    {
        $userId = session('user_id');
        $latest = $this->asiModel->getLatestByUser($userId);

        if (!$latest) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Belum ada data cek ASI.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $latest,
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/dashboard — Ringkasan data ibu
    // ---------------------------------------------------------------
    public function dashboard(): ResponseInterface
    {
        $userId = session('user_id');
        $user   = $this->userModel->find($userId);

        unset($user['password_hash']);

        $latestAsi       = $this->asiModel->getLatestByUser($userId);
        $latestKehamilan = $this->kehamilanModel->getLatestByUser($userId);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'user'              => $user,
                'total_cek_asi'     => count($this->asiModel->getByUser($userId)),
                'total_kehamilan'   => count($this->kehamilanModel->getByUser($userId)),
                'latest_asi'        => $latestAsi,
                'latest_kehamilan'  => $latestKehamilan,
            ],
        ]);
    }
}
