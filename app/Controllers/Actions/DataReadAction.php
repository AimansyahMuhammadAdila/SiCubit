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
    // ---------------------------------------------------------------
    // SAVE DATA RIWAYAT MEDIS SAJA — POST /api/save-riwayat-medis
    // ---------------------------------------------------------------
    public function saveRiwayatMedis(): ResponseInterface
    {
        $idIbu = session('id_ibu');
        if (!$idIbu) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi habis, silakan login ulang.'])->setStatusCode(401);
        }

        $rules = [
            // Pra Kehamilan
            'bb_sebelum_hamil'      => 'permit_empty|decimal',
            'riwayat_abortus'       => 'permit_empty|in_list[Ya,Tidak]',
            // Kehamilan
            'kehamilan_ke'          => 'required|integer|greater_than[0]',
            'umur_kehamilan'        => 'required|integer|greater_than[0]|less_than[46]',
            'bb'                    => 'permit_empty|decimal',
            'kadar_hb'              => 'permit_empty|decimal',
            'ukuran_lila'           => 'permit_empty|decimal',
            'kunjungan_anc'         => 'permit_empty|integer',
            'konsumsi_ttd'          => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hiv'           => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hbsag'         => 'permit_empty|in_list[Ya,Tidak]',
            'status_bahagia'        => 'permit_empty|in_list[Ya,Tidak]',
            // Persalinan
            'cara_persalinan'       => 'required|in_list[Normal,Sectio Caesarea]',
            'umur_kehamilan_salin'  => 'required|integer|greater_than[0]|less_than[46]',
            'imd'                   => 'permit_empty|in_list[Ya,Tidak]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(422);
        }

        $tglPengisian = $this->request->getPost('tgl_pengisian');

        // Gabungkan array riwayat penyakit jadi string pakai koma
        $penyakitArr = $this->request->getPost('riwayat_penyakit');
        $penyakitStr = is_array($penyakitArr) ? implode(', ', $penyakitArr) : '';

        // Mulai Transaksi Database
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan Pra Kehamilan
        $this->praKehamilanModel->insert([
            'id_ibu'           => $idIbu,
            'tgl_pengisian'    => $tglPengisian,
            'bb_sebelum_hamil' => $this->request->getPost('bb_sebelum_hamil'),
            'riwayat_penyakit' => $penyakitStr,
            'riwayat_abortus'  => $this->request->getPost('riwayat_abortus'),
        ], false);

        // 2. Simpan Kehamilan
        $this->kehamilanModel->insert([
            'id_ibu'          => $idIbu,
            'tgl_pengisian'   => $tglPengisian,
            'kehamilan_ke'    => (int) $this->request->getPost('kehamilan_ke'),
            'umur_kehamilan'  => (int) $this->request->getPost('umur_kehamilan'),
            'bb'              => $this->request->getPost('bb'),
            'kadar_hb'        => $this->request->getPost('kadar_hb'),
            'ukuran_lila'     => $this->request->getPost('ukuran_lila'),
            'kunjungan_anc'   => (int) $this->request->getPost('kunjungan_anc'),
            'konsumsi_ttd'    => $this->request->getPost('konsumsi_ttd'),
            'periksa_hiv'     => $this->request->getPost('periksa_hiv'),
            'periksa_hbsag'   => $this->request->getPost('periksa_hbsag'),
            'info_kespro'     => 'Ya', // Default
            'status_bahagia'  => $this->request->getPost('status_bahagia'),
        ], false);

        // 3. Simpan Persalinan
        $this->persalinanModel->insert([
            'id_ibu'                => $idIbu,
            'tgl_pengisian'         => $tglPengisian,
            'cara_persalinan'       => $this->request->getPost('cara_persalinan'),
            'umur_kehamilan_salin'  => (int) $this->request->getPost('umur_kehamilan_salin'),
            'imd'                   => $this->request->getPost('imd'),
        ], false);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data ke database.',
            ])->setStatusCode(500);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data riwayat medis berhasil disimpan.',
        ])->setStatusCode(201);
    }
}
