<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\KondisiKejiwaanIbuModel;
use CodeIgniter\HTTP\ResponseInterface;

class KondisiKejiwaanAction extends BaseController
{
    protected ?KondisiKejiwaanIbuModel $kejiwaanModel = null;

    public function __construct()
    {
        try {
            $this->kejiwaanModel = new KondisiKejiwaanIbuModel();
        } catch (\Throwable $e) {}
    }

    // ---------------------------------------------------------------
    // POST /api/kondisi-kejiwaan — Simpan hasil screening kejiwaan
    // ---------------------------------------------------------------
    public function save(): ResponseInterface
    {
        $postData = $this->request->getPost();
        $userId   = session('user_id');

        if (!$userId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Sesi login telah berakhir. Silakan login kembali.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $tglPengisian = $postData['tgl_pengisian'] ?? date('Y-m-d');
        $data = [
            'user_id'       => $userId,
            'tgl_pengisian' => $tglPengisian,
        ];

        // 1. Jika ada input EPDS
        if (isset($postData['epds_q1'])) {
            $hasilEpds = $this->kejiwaanModel->hitungEpds($postData);
            $data['epds_skor']   = $hasilEpds['epds_skor'];
            $data['epds_status'] = $hasilEpds['epds_status'];
            for ($i = 1; $i <= 10; $i++) {
                if (isset($postData["epds_q$i"])) {
                    $data["epds_q$i"] = (int)$postData["epds_q$i"];
                }
            }
        }

        // 2. Jika ada input Gejala Cemas & Fisik
        $somaticFields = [
            'khawatir_berlebihan', 'gelisah', 'gemetar', 'tidak_dapat_rileks',
            'ketegangan_otot', 'sakit_kepala', 'jantung_berdebar',
            'berkeringat_berlebihan', 'sesak_napas', 'kepala_terasa_ringan',
            'keluhan_ulu_hati', 'lelah_sulit_tidur', 'mudah_tersinggung',
            'perubahan_hubungan_suami'
        ];

        $hasSomaticInput = false;
        foreach ($somaticFields as $field) {
            if (isset($postData[$field])) {
                $hasSomaticInput = true;
                $data[$field] = $postData[$field];
            }
        }

        if ($hasSomaticInput) {
            $hasilScreening = $this->kejiwaanModel->hitungKondisiKejiwaan($postData);
            $data['skor_kejiwaan']   = $hasilScreening['skor_kejiwaan'];
            $data['status_kejiwaan'] = $hasilScreening['status_kejiwaan'];
        }

        // Cek record lama untuk pengisian hari ini
        $existingRecord = $this->kejiwaanModel
                               ->where('user_id', $userId)
                               ->where('tgl_pengisian', $tglPengisian)
                               ->orderBy('id', 'DESC')
                               ->first();

        if ($existingRecord) {
            $this->kejiwaanModel->skipValidation(true);
            $execution = $this->kejiwaanModel->update($existingRecord['id'], $data);
            $insertId  = $existingRecord['id'];
        } else {
            $this->kejiwaanModel->skipValidation(true);
            $execution = $this->kejiwaanModel->insert($data, false);
            $insertId  = $this->kejiwaanModel->getInsertID();
        }

        if (!$execution) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data kondisi kejiwaan.',
                'errors'  => $this->kejiwaanModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data kondisi kejiwaan berhasil disinkronisasi.',
            'data'    => [
                'id'              => $insertId,
                'epds_skor'       => $data['epds_skor'] ?? null,
                'epds_status'     => $data['epds_status'] ?? null,
                'skor_kejiwaan'   => $data['skor_kejiwaan'] ?? null,
                'status_kejiwaan' => $data['status_kejiwaan'] ?? null,
            ],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // GET /api/kondisi-kejiwaan — Semua riwayat kejiwaan user
    // ---------------------------------------------------------------
    public function index(): ResponseInterface
    {
        $userId = session('user_id');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $this->kejiwaanModel->getByUser($userId),
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/kondisi-kejiwaan/latest — Hasil screening terakhir
    // ---------------------------------------------------------------
    public function latest(): ResponseInterface
    {
        $userId = session('user_id');
        $latest = $this->kejiwaanModel->getLatestByUser($userId);

        if (!$latest) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Belum ada data screening kondisi kejiwaan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $latest,
        ]);
    }
}
