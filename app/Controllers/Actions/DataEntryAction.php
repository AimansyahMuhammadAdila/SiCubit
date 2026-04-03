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
    protected RiwayatKehamilanModel $kehamilanModel;
    protected RiwayatPersalinanModel $persalinanModel;
    protected AsiModel $asiModel;

    public function __construct()
    {
        $this->praKehamilanModel = new RiwayatPraKehamilanModel();
        $this->kehamilanModel = new RiwayatKehamilanModel();
        $this->persalinanModel = new RiwayatPersalinanModel();
        $this->asiModel = new AsiModel();
    }

    // ---------------------------------------------------------------
    // SAVE DATA — POST /api/save-riwayat
    // Menyimpan 4 tabel sekaligus dalam 1 database transaction
    // ---------------------------------------------------------------

    public function saveData(): ResponseInterface
    {
        $idIbu = session('id_ibu');
        if (!$idIbu) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi habis, silakan login ulang.'])->setStatusCode(401);
        }

        $rules = [
            // Pra Kehamilan
            'bb_sebelum_hamil' => 'permit_empty|decimal',
            'riwayat_abortus' => 'permit_empty|in_list[Ya,Tidak]',
            // Kehamilan
            'kehamilan_ke' => 'required|integer|greater_than[0]',
            'umur_kehamilan' => 'required|integer|greater_than[0]|less_than[46]',
            'bb' => 'permit_empty|decimal',
            'kadar_hb' => 'permit_empty|decimal',
            'ukuran_lila' => 'permit_empty|decimal',
            'kunjungan_anc' => 'permit_empty|integer',
            'konsumsi_ttd' => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hiv' => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hbsag' => 'permit_empty|in_list[Ya,Tidak]',
            'status_bahagia' => 'permit_empty|in_list[Ya,Tidak]',
            // Persalinan
            'cara_persalinan' => 'required|in_list[Normal,Sectio Caesarea]',
            'umur_kehamilan_salin' => 'required|integer|greater_than[0]|less_than[46]',
            'imd' => 'permit_empty|in_list[Ya,Tidak]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $this->validator->getErrors(),
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
            'id_ibu' => $idIbu,
            'tgl_pengisian' => $tglPengisian,
            'bb_sebelum_hamil' => $this->request->getPost('bb_sebelum_hamil'),
            'riwayat_penyakit' => $penyakitStr,
            'riwayat_abortus' => $this->request->getPost('riwayat_abortus'),
        ], false);

        // 2. Simpan Kehamilan
        $this->kehamilanModel->insert([
            'id_ibu' => $idIbu,
            'tgl_pengisian' => $tglPengisian,
            'kehamilan_ke' => (int) $this->request->getPost('kehamilan_ke'),
            'umur_kehamilan' => (int) $this->request->getPost('umur_kehamilan'),
            'bb' => $this->request->getPost('bb'),
            'kadar_hb' => $this->request->getPost('kadar_hb'),
            'ukuran_lila' => $this->request->getPost('ukuran_lila'),
            'kunjungan_anc' => (int) $this->request->getPost('kunjungan_anc'),
            'konsumsi_ttd' => $this->request->getPost('konsumsi_ttd'),
            'periksa_hiv' => $this->request->getPost('periksa_hiv'),
            'periksa_hbsag' => $this->request->getPost('periksa_hbsag'),
            'info_kespro' => 'Ya', // Default
            'status_bahagia' => $this->request->getPost('status_bahagia'),
        ], false);

        // 3. Simpan Persalinan
        $this->persalinanModel->insert([
            'id_ibu' => $idIbu,
            'tgl_pengisian' => $tglPengisian,
            'cara_persalinan' => $this->request->getPost('cara_persalinan'),
            'umur_kehamilan_salin' => (int) $this->request->getPost('umur_kehamilan_salin'),
            'imd' => $this->request->getPost('imd'),
        ], false);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database.',
            ])->setStatusCode(500);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data riwayat medis berhasil disimpan.',
        ])->setStatusCode(201);
    }


    public function saveAsiOnly(): ResponseInterface
    {
        $idIbu = session('id_ibu');
        if (!$idIbu) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi habis, silakan login ulang.'])->setStatusCode(401);
        }

        $dataAsiInput = [
            'tgl_pengisian' => $this->request->getPost('tgl_pengisian'),
            'kondisi_puting' => $this->request->getPost('kondisi_puting'),
            'frekuensi_menyusui' => (int) $this->request->getPost('frekuensi_menyusui'),
            'lama_menyusui' => (int) $this->request->getPost('lama_menyusui'),
            'frekuensi_bab_bayi' => (int) $this->request->getPost('frekuensi_bab_bayi'),
            'frekuensi_bak_bayi' => (int) $this->request->getPost('frekuensi_bak_bayi'),
            'support_suami_menyusui' => $this->request->getPost('support_suami_menyusui') ?? 'Tidak',
            'support_suami_gizi' => $this->request->getPost('support_suami_gizi') ?? 'Tidak',
            'bayi_tidur_12jam' => $this->request->getPost('bayi_tidur_12jam') ?? 'Ya',
            'bayi_tenang_setelah_menyusu' => $this->request->getPost('bayi_tenang_setelah_menyusu'),
            'warna_urin_bayi' => $this->request->getPost('warna_urin_bayi'),
            'payudara_penuh' => $this->request->getPost('payudara_penuh'),
            'volume_pumping' => $this->request->getPost('volume_pumping'),
        ];

        // Kalkulasi kecukupan ASI berdasarkan model
        $statusAsi = $this->asiModel->hitungKecukupanAsi($dataAsiInput);

        // Gabungkan id_ibu dan status kecukupan untuk disimpan ke database
        $dataAsi = array_merge($dataAsiInput, [
            'id_ibu' => $idIbu,
            'status_kecukupan_asi' => $statusAsi,
        ]);

        if (!$this->asiModel->insert($dataAsi, false)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $this->asiModel->errors()
            ])->setStatusCode(422);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Evaluasi ASI berhasil dicatat.',
            'data' => [
                'status_kecukupan_asi' => $statusAsi
            ]
        ])->setStatusCode(201);
    }
}