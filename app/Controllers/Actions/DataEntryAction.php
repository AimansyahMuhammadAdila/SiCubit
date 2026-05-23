<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\RiwayatPraKehamilanModel;
use App\Models\RiwayatKehamilanModel;
use App\Models\RiwayatPersalinanModel;
use App\Models\AsiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataEntryAction extends BaseController
{
    protected RiwayatPraKehamilanModel $praKehamilanModel;
    protected RiwayatKehamilanModel    $kehamilanModel;
    protected RiwayatPersalinanModel   $persalinanModel;
    protected AsiModel                 $asiModel;

    public function __construct()
    {
        $this->praKehamilanModel = new RiwayatPraKehamilanModel();
        $this->kehamilanModel    = new RiwayatKehamilanModel();
        $this->persalinanModel   = new RiwayatPersalinanModel();
        $this->asiModel          = new AsiModel();
    }

    // ---------------------------------------------------------------
    // SAVE DATA — POST /api/save-riwayat
    // Menyimpan 4 tabel sekaligus dalam 1 database transaction
    // ---------------------------------------------------------------

    public function saveData(): ResponseInterface
    {
        // ---- Validasi semua input sekaligus ----
        $rules = [
            // Pra Kehamilan
            'tgl_pengisian'       => 'required|valid_date',
            'bb_sebelum_hamil'    => 'permit_empty|decimal',
            'riwayat_penyakit'    => 'permit_empty|string',
            'riwayat_abortus'     => 'permit_empty|in_list[Ya,Tidak]',

            // Kehamilan
            'kehamilan_ke'        => 'required|integer|greater_than[0]',
            'umur_kehamilan'      => 'required|integer|greater_than[0]|less_than[46]',
            'bb'                  => 'permit_empty|decimal',
            'kadar_hb'            => 'permit_empty|decimal',
            'ukuran_lila'         => 'permit_empty|decimal',
            'kunjungan_anc'       => 'permit_empty|integer',
            'konsumsi_ttd'        => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hiv'         => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hbsag'       => 'permit_empty|in_list[Ya,Tidak]',
            'info_kespro'         => 'permit_empty|in_list[Ya,Tidak]',
            'status_bahagia'      => 'permit_empty|in_list[Ya,Tidak]',

            // Persalinan
            'cara_persalinan'       => 'required|in_list[Normal,Sectio Caesarea]',
            'umur_kehamilan_salin'  => 'required|integer|greater_than[0]|less_than[46]',
            'imd'                   => 'permit_empty|in_list[Ya,Tidak]',

            // Cek ASI
            'kondisi_puting'      => 'permit_empty|in_list[Normal,Lecet,Datar,Tenggelam,Menonjol,Pecah]',
            'frekuensi_menyusui'  => 'required|integer|greater_than_equal_to[0]',
            'lama_menyusui'       => 'required|integer|greater_than_equal_to[0]',
            'frekuensi_bab_bayi'  => 'required|integer|greater_than_equal_to[0]',
            'frekuensi_bak_bayi'  => 'required|integer|greater_than_equal_to[0]',
            'support_suami_menyusui'      => 'permit_empty|in_list[Ya,Tidak]',
            'support_suami_gizi'          => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tidur_12jam'            => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tenang_setelah_menyusu' => 'permit_empty|in_list[Ya,Tidak]',
            'warna_urin_bayi'             => 'permit_empty|in_list[Jernih,Kuning Muda,Kuning Pekat]',
            'payudara_penuh'              => 'permit_empty|in_list[Ya,Tidak]',
            'volume_pumping'              => 'permit_empty|decimal',
            'bb_naik_sesuai_usia'         => 'permit_empty|in_list[Ya,Tidak]',
            'kondisi_lainnya'             => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Ambil user_id dari session
        $userId       = session('user_id');
        $tglPengisian = $this->request->getPost('tgl_pengisian');

        // ---- Mulai Database Transaction ----
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan Riwayat Pra Kehamilan
        $dataPraKehamilan = [
            'user_id'          => $userId,
            'tgl_pengisian'    => $tglPengisian,
            'bb_sebelum_hamil' => $this->request->getPost('bb_sebelum_hamil'),
            'riwayat_penyakit' => $this->request->getPost('riwayat_penyakit'),
            'riwayat_abortus'  => $this->request->getPost('riwayat_abortus') ?? 'Tidak',
        ];
        $this->praKehamilanModel->insert($dataPraKehamilan, false);

        // 2. Simpan Riwayat Kehamilan
        $dataKehamilan = [
            'user_id'         => $userId,
            'tgl_pengisian'   => $tglPengisian,
            'kehamilan_ke'    => (int) $this->request->getPost('kehamilan_ke'),
            'umur_kehamilan'  => (int) $this->request->getPost('umur_kehamilan'),
            'bb'              => $this->request->getPost('bb'),
            'kadar_hb'        => $this->request->getPost('kadar_hb'),
            'ukuran_lila'     => $this->request->getPost('ukuran_lila'),
            'kunjungan_anc'   => (int) ($this->request->getPost('kunjungan_anc') ?? 0),
            'konsumsi_ttd'    => $this->request->getPost('konsumsi_ttd') ?? 'Tidak',
            'periksa_hiv'     => $this->request->getPost('periksa_hiv') ?? 'Tidak',
            'periksa_hbsag'   => $this->request->getPost('periksa_hbsag') ?? 'Tidak',
            'info_kespro'     => $this->request->getPost('info_kespro') ?? 'Tidak',
            'status_bahagia'  => $this->request->getPost('status_bahagia') ?? 'Ya',
        ];
        $this->kehamilanModel->insert($dataKehamilan, false);

        // 3. Simpan Riwayat Persalinan
        $dataPersalinan = [
            'user_id'               => $userId,
            'tgl_pengisian'         => $tglPengisian,
            'cara_persalinan'       => $this->request->getPost('cara_persalinan'),
            'umur_kehamilan_salin'  => (int) $this->request->getPost('umur_kehamilan_salin'),
            'imd'                   => $this->request->getPost('imd') ?? 'Tidak',
        ];
        $this->persalinanModel->insert($dataPersalinan, false);

        // 4. Hitung kecukupan ASI lalu simpan
        $dataAsiInput = [
            'kondisi_puting'               => $this->request->getPost('kondisi_puting') ?? 'Normal',
            'frekuensi_menyusui'           => (int) $this->request->getPost('frekuensi_menyusui'),
            'lama_menyusui'                => (int) $this->request->getPost('lama_menyusui'),
            'frekuensi_bab_bayi'           => (int) $this->request->getPost('frekuensi_bab_bayi'),
            'frekuensi_bak_bayi'           => (int) $this->request->getPost('frekuensi_bak_bayi'),
            'support_suami_menyusui'       => $this->request->getPost('support_suami_menyusui') ?? 'Ya',
            'support_suami_gizi'           => $this->request->getPost('support_suami_gizi') ?? 'Ya',
            'bayi_tidur_12jam'             => $this->request->getPost('bayi_tidur_12jam') ?? 'Ya',
            'bayi_tenang_setelah_menyusu'  => $this->request->getPost('bayi_tenang_setelah_menyusu') ?? 'Ya',
            'warna_urin_bayi'              => $this->request->getPost('warna_urin_bayi') ?? 'Jernih',
            'payudara_penuh'               => $this->request->getPost('payudara_penuh') ?? 'Ya',
            'volume_pumping'               => $this->request->getPost('volume_pumping'),
            'bb_naik_sesuai_usia'          => $this->request->getPost('bb_naik_sesuai_usia') ?? 'Ya',
            'kondisi_lainnya'              => $this->request->getPost('kondisi_lainnya'),
        ];

        // Hitung status kecukupan ASI menggunakan service logic
        $statusAsi = $this->asiModel->hitungKecukupanAsi($dataAsiInput);

        $dataAsi = array_merge($dataAsiInput, [
            'user_id'             => $userId,
            'tgl_pengisian'       => $tglPengisian,
            'status_kecukupan_asi' => $statusAsi,
        ]);
        $this->asiModel->insert($dataAsi, false);

        // ---- Selesai Transaction ----
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data. Transaksi di-rollback.',
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data riwayat berhasil disimpan.',
            'data'    => [
                'status_kecukupan_asi' => $statusAsi,
            ],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // SAVE ASI ONLY — POST /api/save-asi
    // Menyimpan data cek kelancaran ASI saja
    // ---------------------------------------------------------------
    public function saveAsiOnly(): ResponseInterface
    {
        $rules = [
            'tgl_pengisian'               => 'required|valid_date',
            'kondisi_puting'              => 'permit_empty|in_list[Normal,Lecet,Datar,Tenggelam,Menonjol,Pecah]',
            'frekuensi_menyusui'          => 'required|integer|greater_than_equal_to[0]',
            'lama_menyusui'               => 'required|integer|greater_than_equal_to[0]',
            'frekuensi_bab_bayi'          => 'required|integer|greater_than_equal_to[0]',
            'frekuensi_bak_bayi'          => 'required|integer|greater_than_equal_to[0]',
            'support_suami_menyusui'      => 'permit_empty|in_list[Ya,Tidak]',
            'support_suami_gizi'          => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tidur_12jam'            => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tenang_setelah_menyusu' => 'permit_empty|in_list[Ya,Tidak]',
            'warna_urin_bayi'             => 'permit_empty|in_list[Jernih,Kuning Muda,Kuning Pekat]',
            'payudara_penuh'              => 'permit_empty|in_list[Ya,Tidak]',
            'volume_pumping'              => 'permit_empty|decimal',
            'bb_naik_sesuai_usia'         => 'permit_empty|in_list[Ya,Tidak]',
            'kondisi_lainnya'             => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId       = session('user_id');
        $tglPengisian = $this->request->getPost('tgl_pengisian');

        $dataAsiInput = [
            'kondisi_puting'              => $this->request->getPost('kondisi_puting') ?? 'Normal',
            'frekuensi_menyusui'          => (int) $this->request->getPost('frekuensi_menyusui'),
            'lama_menyusui'               => (int) $this->request->getPost('lama_menyusui'),
            'frekuensi_bab_bayi'          => (int) $this->request->getPost('frekuensi_bab_bayi'),
            'frekuensi_bak_bayi'          => (int) $this->request->getPost('frekuensi_bak_bayi'),
            'support_suami_menyusui'      => $this->request->getPost('support_suami_menyusui') ?? 'Ya',
            'support_suami_gizi'          => $this->request->getPost('support_suami_gizi') ?? 'Ya',
            'bayi_tidur_12jam'            => $this->request->getPost('bayi_tidur_12jam') ?? 'Ya',
            'bayi_tenang_setelah_menyusu' => $this->request->getPost('bayi_tenang_setelah_menyusu') ?? 'Ya',
            'warna_urin_bayi'             => $this->request->getPost('warna_urin_bayi') ?? 'Jernih',
            'payudara_penuh'              => $this->request->getPost('payudara_penuh') ?? 'Ya',
            'volume_pumping'              => $this->request->getPost('volume_pumping'),
            'bb_naik_sesuai_usia'         => $this->request->getPost('bb_naik_sesuai_usia') ?? 'Ya',
            'kondisi_lainnya'             => $this->request->getPost('kondisi_lainnya'),
        ];

        $statusAsi = $this->asiModel->hitungKecukupanAsi($dataAsiInput);

        $dataAsi = array_merge($dataAsiInput, [
            'user_id'              => $userId,
            'tgl_pengisian'        => $tglPengisian,
            'status_kecukupan_asi' => $statusAsi,
        ]);

        if (!$this->asiModel->insert($dataAsi, false)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data kelancaran ASI.',
                'errors'  => $this->asiModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data kelancaran ASI berhasil disimpan.',
            'data'    => [
                'id'                   => $this->asiModel->getInsertID(),
                'status_kecukupan_asi' => $statusAsi,
            ],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }
}

