<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\KondisiKejiwaanIbuModel;
use CodeIgniter\HTTP\ResponseInterface;

class KondisiKejiwaanAction extends BaseController
{
    protected KondisiKejiwaanIbuModel $kejiwaanModel;

    public function __construct()
    {
        $this->kejiwaanModel = new KondisiKejiwaanIbuModel();
    }

    // ---------------------------------------------------------------
    // POST /api/kondisi-kejiwaan — Simpan hasil screening kejiwaan
    // ---------------------------------------------------------------
    public function save(): ResponseInterface
    {
        $postData = $this->request->getPost();

        // Check if it is EPDS form or the original checklist
        if (isset($postData['epds_q1'])) {
            $rules = [
                'tgl_pengisian' => 'required|valid_date',
                'epds_q1'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q2'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q3'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q4'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q5'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q6'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q7'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q8'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q9'       => 'required|integer|in_list[0,1,2,3]',
                'epds_q10'      => 'required|integer|in_list[0,1,2,3]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Validasi gagal.',
                    'errors'  => $this->validator->getErrors(),
                ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
            }

            $userId = session('user_id');
            $hasilEpds = $this->kejiwaanModel->hitungEpds($postData);

            $data = array_merge($postData, [
                'user_id'     => $userId,
                'epds_skor'   => $hasilEpds['epds_skor'],
                'epds_status' => $hasilEpds['epds_status'],
            ]);

            $insertId = $this->kejiwaanModel->insert($data, true);
            if (!$insertId) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan data EPDS.',
                    'errors'  => $this->kejiwaanModel->errors(),
                ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data EPDS berhasil disimpan.',
                'data'    => [
                    'id'          => $insertId,
                    'epds_skor'   => $hasilEpds['epds_skor'],
                    'epds_status' => $hasilEpds['epds_status'],
                ],
            ])->setStatusCode(ResponseInterface::HTTP_CREATED);

        } else {
            $rules = [
                'tgl_pengisian'            => 'required|valid_date',
                'khawatir_berlebihan'      => 'permit_empty|in_list[Ya,Tidak]',
                'gelisah'                  => 'permit_empty|in_list[Ya,Tidak]',
                'gemetar'                  => 'permit_empty|in_list[Ya,Tidak]',
                'tidak_dapat_rileks'       => 'permit_empty|in_list[Ya,Tidak]',
                'ketegangan_otot'          => 'permit_empty|in_list[Ya,Tidak]',
                'sakit_kepala'             => 'permit_empty|in_list[Ya,Tidak]',
                'jantung_berdebar'         => 'permit_empty|in_list[Ya,Tidak]',
                'berkeringat_berlebihan'   => 'permit_empty|in_list[Ya,Tidak]',
                'sesak_napas'              => 'permit_empty|in_list[Ya,Tidak]',
                'kepala_terasa_ringan'     => 'permit_empty|in_list[Ya,Tidak]',
                'keluhan_ulu_hati'         => 'permit_empty|in_list[Ya,Tidak]',
                'lelah_sulit_tidur'        => 'permit_empty|in_list[Ya,Tidak]',
                'mudah_tersinggung'        => 'permit_empty|in_list[Ya,Tidak]',
                'perubahan_hubungan_suami' => 'permit_empty|in_list[Ya,Tidak]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Validasi gagal.',
                    'errors'  => $this->validator->getErrors(),
                ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
            }

            $userId   = session('user_id');

            // Hitung skor dan status kejiwaan secara otomatis
            $hasilScreening = $this->kejiwaanModel->hitungKondisiKejiwaan($postData);

            $data = array_merge($postData, [
                'user_id'         => $userId,
                'skor_kejiwaan'   => $hasilScreening['skor_kejiwaan'],
                'status_kejiwaan' => $hasilScreening['status_kejiwaan'],
            ]);

            if (!$this->kejiwaanModel->insert($data, false)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan data kondisi kejiwaan.',
                    'errors'  => $this->kejiwaanModel->errors(),
                ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data kondisi kejiwaan berhasil disimpan.',
                'data'    => [
                    'id'              => $this->kejiwaanModel->getInsertID(),
                    'skor_kejiwaan'   => $hasilScreening['skor_kejiwaan'],
                    'status_kejiwaan' => $hasilScreening['status_kejiwaan'],
                ],
            ])->setStatusCode(ResponseInterface::HTTP_CREATED);
        }
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
