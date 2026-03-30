<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\IbuModel;
use App\Models\RiwayatPraKehamilanModel;
use App\Models\RiwayatKehamilanModel;
use App\Models\RiwayatPersalinanModel;
use App\Models\AsiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataReadAction extends BaseController
{
    protected IbuModel                 $ibuModel;
    protected RiwayatPraKehamilanModel $praKehamilanModel;
    protected RiwayatKehamilanModel    $kehamilanModel;
    protected RiwayatPersalinanModel   $persalinanModel;
    protected AsiModel                 $asiModel;

    public function __construct()
    {
        $this->ibuModel          = new IbuModel();
        $this->praKehamilanModel = new RiwayatPraKehamilanModel();
        $this->kehamilanModel    = new RiwayatKehamilanModel();
        $this->persalinanModel   = new RiwayatPersalinanModel();
        $this->asiModel          = new AsiModel();
    }

    // ---------------------------------------------------------------
    // GET /api/profil — Data profil ibu yang sedang login
    // ---------------------------------------------------------------
    public function profil(): ResponseInterface
    {
        $idIbu = session('id_ibu');
        $ibu   = $this->ibuModel->find($idIbu);

        if (!$ibu) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data ibu tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Hapus password_hash dari response
        unset($ibu['password_hash']);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $ibu,
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/riwayat — Semua riwayat (pra-hamil, hamil, persalinan)
    // ---------------------------------------------------------------
    public function riwayat(): ResponseInterface
    {
        $idIbu = session('id_ibu');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'pra_kehamilan' => $this->praKehamilanModel->getByIbu($idIbu),
                'kehamilan'     => $this->kehamilanModel->getByIbu($idIbu),
                'persalinan'    => $this->persalinanModel->getByIbu($idIbu),
            ],
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/cek-asi — Semua riwayat cek kelancaran ASI
    // ---------------------------------------------------------------
    public function cekAsi(): ResponseInterface
    {
        $idIbu = session('id_ibu');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $this->asiModel->getByIbu($idIbu),
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/cek-asi/latest — Cek ASI terakhir
    // ---------------------------------------------------------------
    public function cekAsiLatest(): ResponseInterface
    {
        $idIbu  = session('id_ibu');
        $latest = $this->asiModel->getLatestByIbu($idIbu);

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
        $idIbu = session('id_ibu');
        $ibu   = $this->ibuModel->find($idIbu);

        unset($ibu['password_hash']);

        $latestAsi       = $this->asiModel->getLatestByIbu($idIbu);
        $latestKehamilan = $this->kehamilanModel->getLatestByIbu($idIbu);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'ibu'               => $ibu,
                'total_cek_asi'     => count($this->asiModel->getByIbu($idIbu)),
                'total_kehamilan'   => count($this->kehamilanModel->getByIbu($idIbu)),
                'latest_asi'        => $latestAsi,
                'latest_kehamilan'  => $latestKehamilan,
            ],
        ]);
    }
}
