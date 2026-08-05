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

    /**
     * POST /api/save-riwayat
     * Menyimpan data rekam medis ibu (Pra-Kehamilan, Kehamilan, Persalinan, dan ASI Awal)
     */
    public function saveData(): ResponseInterface
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sesi login telah berakhir. Silakan login kembali.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $rules = [
            // Pra Kehamilan
            'tgl_pengisian' => 'required|valid_date',
            'bb_sebelum_hamil' => 'permit_empty|numeric',
            'riwayat_penyakit' => 'permit_empty|string',
            'riwayat_abortus' => 'permit_empty|in_list[Ya,Tidak]',

            // Kehamilan
            'kehamilan_ke' => 'permit_empty|integer|greater_than[0]',
            'umur_kehamilan' => 'permit_empty|integer|greater_than[0]|less_than[46]',
            'bb' => 'permit_empty|numeric',
            'kadar_hb' => 'permit_empty|numeric',
            'ukuran_lila' => 'permit_empty|numeric',
            'kunjungan_anc' => 'permit_empty|integer',
            'konsumsi_ttd' => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hiv' => 'permit_empty|in_list[Ya,Tidak]',
            'periksa_hbsag' => 'permit_empty|in_list[Ya,Tidak]',
            'info_kespro' => 'permit_empty|in_list[Ya,Tidak]',
            'status_bahagia' => 'permit_empty|in_list[Ya,Tidak]',

            // Persalinan
            'cara_persalinan' => 'permit_empty|in_list[Normal,Sectio Caesarea]',
            'umur_kehamilan_salin' => 'permit_empty|integer|greater_than[0]|less_than[46]',
            'imd' => 'permit_empty|in_list[Ya,Tidak]',

            // Cek ASI
            'kondisi_puting' => 'permit_empty|in_list[Normal,Lecet,Datar,Tenggelam,Menonjol,Pecah]',
            'frekuensi_menyusui' => 'permit_empty|numeric',
            'lama_menyusui' => 'permit_empty|numeric',
            'frekuensi_bab_bayi' => 'permit_empty|numeric',
            'frekuensi_bak_bayi' => 'permit_empty|numeric',
            'support_suami_menyusui' => 'permit_empty|in_list[Ya,Tidak]',
            'support_suami_gizi' => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tidur_12jam' => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tenang_setelah_menyusu' => 'permit_empty|in_list[Ya,Tidak]',
            'warna_urin_bayi' => 'permit_empty|in_list[Jernih,Kuning Muda,Kuning Pekat]',
            'payudara_penuh' => 'permit_empty|in_list[Ya,Tidak]',
            'hasil_pumping' => 'permit_empty|numeric',
            'volume_pumping' => 'permit_empty|numeric',
            'bb_naik_sesuai_usia' => 'permit_empty|in_list[Ya,Tidak]',
            'kondisi_lainnya' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tglPengisian = $this->request->getPost('tgl_pengisian') ?? date('Y-m-d');

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Riwayat Pra Kehamilan
        $bbSebelumHamil = $this->request->getPost('bb_sebelum_hamil');
        $riwayatPenyakit = $this->request->getPost('riwayat_penyakit');
        $riwayatAbortus = $this->request->getPost('riwayat_abortus');

        if ($bbSebelumHamil !== null || $riwayatPenyakit !== null || $riwayatAbortus !== null) {
            $dataPraKehamilan = [
                'user_id' => $userId,
                'tgl_pengisian' => $tglPengisian,
                'bb_sebelum_hamil' => ($bbSebelumHamil !== null && $bbSebelumHamil !== '') ? $bbSebelumHamil : null,
                'riwayat_penyakit' => $riwayatPenyakit ?? 'Tidak Ada',
                'riwayat_abortus' => $riwayatAbortus ?? 'Tidak',
            ];

            $existingPra = $this->praKehamilanModel
                                ->where('user_id', $userId)
                                ->where('tgl_pengisian', $tglPengisian)
                                ->first();
            if ($existingPra) {
                $this->praKehamilanModel->update($existingPra['id'], $dataPraKehamilan);
            } else {
                $this->praKehamilanModel->insert($dataPraKehamilan, false);
            }
        }

        // 2. Riwayat Kehamilan
        $kehamilanKe = $this->request->getPost('kehamilan_ke');
        $umurKehamilan = $this->request->getPost('umur_kehamilan');
        if (($kehamilanKe !== null && $kehamilanKe !== '') || ($umurKehamilan !== null && $umurKehamilan !== '')) {
            $dataKehamilan = [
                'user_id' => $userId,
                'tgl_pengisian' => $tglPengisian,
                'kehamilan_ke' => (int) $kehamilanKe,
                'umur_kehamilan' => (int) $umurKehamilan,
                'bb' => $this->request->getPost('bb') !== '' ? $this->request->getPost('bb') : null,
                'kadar_hb' => $this->request->getPost('kadar_hb') !== '' ? $this->request->getPost('kadar_hb') : null,
                'ukuran_lila' => $this->request->getPost('ukuran_lila') !== '' ? $this->request->getPost('ukuran_lila') : null,
                'kunjungan_anc' => (int) ($this->request->getPost('kunjungan_anc') ?? 0),
                'konsumsi_ttd' => $this->request->getPost('konsumsi_ttd') ?? 'Tidak',
                'periksa_hiv' => $this->request->getPost('periksa_hiv') ?? 'Tidak',
                'periksa_hbsag' => $this->request->getPost('periksa_hbsag') ?? 'Tidak',
                'info_kespro' => $this->request->getPost('info_kespro') ?? 'Tidak',
                'status_bahagia' => $this->request->getPost('status_bahagia') ?? 'Ya',
            ];

            $existingKehamilan = $this->kehamilanModel
                                      ->where('user_id', $userId)
                                      ->where('tgl_pengisian', $tglPengisian)
                                      ->first();
            if ($existingKehamilan) {
                $this->kehamilanModel->update($existingKehamilan['id'], $dataKehamilan);
            } else {
                $this->kehamilanModel->insert($dataKehamilan, false);
            }
        }

        // 3. Riwayat Persalinan
        $caraPersalinan = $this->request->getPost('cara_persalinan');
        $umurKehamilanSalin = $this->request->getPost('umur_kehamilan_salin');
        if (($caraPersalinan !== null && $caraPersalinan !== '') || ($umurKehamilanSalin !== null && $umurKehamilanSalin !== '')) {
            $dataPersalinan = [
                'user_id' => $userId,
                'tgl_pengisian' => $tglPengisian,
                'cara_persalinan' => $caraPersalinan,
                'umur_kehamilan_salin' => (int) $umurKehamilanSalin,
                'imd' => $this->request->getPost('imd') ?? 'Tidak',
            ];

            $existingPersalinan = $this->persalinanModel
                                       ->where('user_id', $userId)
                                       ->where('tgl_pengisian', $tglPengisian)
                                       ->first();
            if ($existingPersalinan) {
                $this->persalinanModel->update($existingPersalinan['id'], $dataPersalinan);
            } else {
                $this->persalinanModel->insert($dataPersalinan, false);
            }
        }

        // 4. Input ASI (jika data ASI dikirimkan)
        $frekuensiMenyusui = $this->request->getPost('frekuensi_menyusui');
        $lamaMenyusui = $this->request->getPost('lama_menyusui');
        $statusKecukupanAsi = null;

        if (($frekuensiMenyusui !== null && $frekuensiMenyusui !== '') && ($lamaMenyusui !== null && $lamaMenyusui !== '')) {
            $volumePumpingVal = $this->request->getPost('volume_pumping') ?? $this->request->getPost('hasil_pumping') ?? 0;

            $dataAsiInput = [
                'user_id' => $userId,
                'tgl_pengisian' => $tglPengisian,
                'frekuensi_menyusui' => $frekuensiMenyusui,
                'lama_menyusui' => $lamaMenyusui,
                'frekuensi_bab_bayi' => $this->request->getPost('frekuensi_bab_bayi') ?? 0,
                'frekuensi_bak_bayi' => $this->request->getPost('frekuensi_bak_bayi') ?? 0,
                'volume_pumping' => $volumePumpingVal,
            ];

            $fieldsOpsi = [
                'kondisi_puting',
                'support_suami_menyusui',
                'support_suami_gizi',
                'bayi_tidur_12jam',
                'bayi_tenang_setelah_menyusu',
                'warna_urin_bayi',
                'payudara_penuh',
                'bb_naik_sesuai_usia',
                'kondisi_lainnya'
            ];
            foreach ($fieldsOpsi as $field) {
                if ($this->request->getPost($field) !== null) {
                    $dataAsiInput[$field] = $this->request->getPost($field);
                }
            }

            $statusKecukupanAsi = $this->asiModel->hitungKecukupanAsi($dataAsiInput);
            $dataAsiInput['status_kecukupan_asi'] = $statusKecukupanAsi;

            $existingAsi = $this->asiModel
                                ->where('user_id', $userId)
                                ->where('tgl_pengisian', $tglPengisian)
                                ->first();
            if ($existingAsi) {
                $this->asiModel->update($existingAsi['id'], $dataAsiInput);
            } else {
                $this->asiModel->insert($dataAsiInput, false);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data rekam medis.',
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data riwayat berhasil disimpan.',
            'data' => ['status_kecukupan_asi' => $statusKecukupanAsi],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    /**
     * POST /api/save-asi
     * PERBAIKAN TOTAL: Menyimpan evaluasi kelancaran laktasi harian (Mendukung Multi-step Wizard)
     */
    /**
     * POST /api/save-asi
     * Menyimpan data evaluasi kelancaran laktasi harian milik ibu
     */
    public function saveAsiOnly(): ResponseInterface
    {
        $rules = [
            'tgl_pengisian'               => 'required|valid_date',
            'frekuensi_menyusui'          => 'required|numeric', 
            'lama_menyusui'               => 'required|numeric', 
            'frekuensi_bab_bayi'          => 'required|numeric', 
            'frekuensi_bak_bayi'          => 'required|numeric', 
            'kondisi_puting'              => 'permit_empty|in_list[Normal,Lecet,Datar,Tenggelam,Menonjol,Pecah]',
            'support_suami_menyusui'      => 'permit_empty|in_list[Ya,Tidak]',
            'support_suami_gizi'          => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tidur_12jam'            => 'permit_empty|in_list[Ya,Tidak]',
            'bayi_tenang_setelah_menyusu' => 'permit_empty|in_list[Ya,Tidak]',
            'warna_urin_bayi'             => 'permit_empty|in_list[Jernih,Kuning Muda,Kuning Pekat]',
            'payudara_penuh'              => 'permit_empty|in_list[Ya,Tidak]',
            'hasil_pumping'               => 'permit_empty|numeric',
            'volume_pumping'              => 'permit_empty|numeric',
            'bb_naik_sesuai_usia'         => 'permit_empty|in_list[Ya,Tidak]',
            'kondisi_lainnya'             => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Periksa rentang angka indikator kuantitatif ASI.',
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId = session('user_id');
        $tglPengisian = $this->request->getPost('tgl_pengisian');

        // Cari data lama untuk menghindari baris ganda hari ini
        $existingRecord = $this->asiModel
                               ->where('user_id', $userId)
                               ->where('tgl_pengisian', $tglPengisian)
                               ->first();

        // Tangkap volume dari form dinamis
        $volumePumpingVal = $this->request->getPost('volume_pumping') ?? $this->request->getPost('hasil_pumping') ?? 0;

        // FIX: Hapus field 'hasil_pumping' dari payload database karena kolomnya tidak ada di SQL!
        $dataAsi = [
            'user_id'            => $userId,
            'tgl_pengisian'      => $tglPengisian,
            'frekuensi_menyusui' => $this->request->getPost('frekuensi_menyusui'),
            'lama_menyusui'      => $this->request->getPost('lama_menyusui'),
            'frekuensi_bab_bayi' => $this->request->getPost('frekuensi_bab_bayi'),
            'frekuensi_bak_bayi' => $this->request->getPost('frekuensi_bak_bayi'),
            'volume_pumping'     => $volumePumpingVal, // Kolom asli database kamu
        ];

        // Masukkan field opsional kualitatif/dukungan langkah berikutnya
        $fieldsOpsi = [
            'kondisi_puting', 'support_suami_menyusui', 'support_suami_gizi',
            'bayi_tidur_12jam', 'bayi_tenang_setelah_menyusu', 'warna_urin_bayi',
            'payudara_penuh', 'bb_naik_sesuai_usia', 'kondisi_lainnya'
        ];

        foreach ($fieldsOpsi as $field) {
            if ($this->request->getPost($field) !== null) {
                $dataAsi[$field] = $this->request->getPost($field);
            }
        }

        // Kalkulasi skor kelancaran laktasi
        $kalkulasiPayload = array_merge($existingRecord ?? [], $dataAsi);
        $dataAsi['status_kecukupan_asi'] = $this->asiModel->hitungKecukupanAsi($kalkulasiPayload);

        // Eksekusi Simpan aman tanpa duplikasi validasi model
        if ($existingRecord) {
            $this->asiModel->skipValidation(true);
            $execution = $this->asiModel->update($existingRecord['id'], $dataAsi);
            $insertId = $existingRecord['id'];
        } else {
            $execution = $this->asiModel->insert($dataAsi, true);
            $insertId = $this->asiModel->getInsertID();
        }

        if (!$execution) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data kelancaran ASI ke database.',
                'errors' => $this->asiModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'success' => true,
            'message' => 'Data kelancaran ASI berhasil disinkronisasi.',
            'data' => [
                'id' => $insertId,
                'status_kecukupan_asi' => $dataAsi['status_kecukupan_asi'],
            ],
        ]);
    }
}