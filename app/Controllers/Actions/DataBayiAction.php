<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\DataBayiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataBayiAction extends BaseController
{
    protected DataBayiModel $dataBayiModel;

    public function __construct()
    {
        $this->dataBayiModel = new DataBayiModel();
    }

    // ---------------------------------------------------------------
    // POST /api/data-bayi — Simpan/Update data bayi (Mendukung Multi-step)
    // ---------------------------------------------------------------
    public function save(): ResponseInterface
    {
        // PERBAIKAN 1: Mengubah 'decimal' menjadi 'numeric' agar angka bulat tidak ditolak
        $rules = [
            'tgl_pengisian'         => 'required|valid_date',
            'golongan_darah'        => 'permit_empty|in_list[A,B,AB,O,Belum Tahu]',
            'bb'                    => 'permit_empty|numeric',
            'pb'                    => 'permit_empty|numeric',
            'lingkar_kepala'        => 'permit_empty|numeric',
            'lingkar_dada'          => 'permit_empty|numeric',
            'lingkar_lengan'        => 'permit_empty|numeric',
            'suhu'                  => 'permit_empty|numeric',
            'reflek_mencari_puting' => 'permit_empty|in_list[Ya,Tidak]',
            'reflek_mengisap'       => 'permit_empty|in_list[Ya,Tidak]',
            'reflek_menelan'        => 'permit_empty|in_list[Ya,Tidak]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId = session('user_id');
        $tglPengisian = $this->request->getPost('tgl_pengisian');

        // PERBAIKAN 2: Cek apakah user sudah mengisi data pada tanggal yang sama hari ini (untuk partial save)
        $existingRecord = $this->dataBayiModel
                               ->where('user_id', $userId)
                               ->where('tgl_pengisian', $tglPengisian)
                               ->first();

        // Menyusun data yang dikirim dari langkah form saat ini
        $data = [
            'user_id'       => $userId,
            'tgl_pengisian' => $tglPengisian,
        ];

        // Ambil field secara opsional. Jika field tidak dikirim oleh AJAX langkah tersebut, 
        // jangan masukkan ke dalam array agar data lama tidak ter-overwrite menjadi null/default.
        $fields = [
            'golongan_darah', 'bb', 'pb', 'lingkar_kepala', 
            'lingkar_dada', 'lingkar_lengan', 'suhu', 
            'reflek_mencari_puting', 'reflek_mengisap', 'reflek_menelan'
        ];

        foreach ($fields as $field) {
            if ($this->request->getPost($field) !== null) {
                $data[$field] = $this->request->getPost($field);
            }
        }

        // PERBAIKAN 3: Jika data hari ini sudah ada, lakukan UPDATE. Jika belum, lakukan INSERT.
        if ($existingRecord) {
            $id = $existingRecord['id'];
            $execution = $this->dataBayiModel->update($id, $data);
        } else {
            $execution = $this->dataBayiModel->insert($data, false);
            $id = $this->dataBayiModel->getInsertID();
        }

        if (!$execution) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data bayi.',
                'errors'  => $this->dataBayiModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data bayi berhasil disinkronisasi.',
            'data'    => ['id' => $id],
        ])->setStatusCode($existingRecord ? ResponseInterface::HTTP_OK : ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // GET /api/data-bayi — Semua data bayi milik user aktif
    // ---------------------------------------------------------------
    public function index(): ResponseInterface
    {
        $userId = session('user_id');

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $this->dataBayiModel->getByUser($userId),
        ]);
    }

    // ---------------------------------------------------------------
    // GET /api/data-bayi/(:num) — Detail data bayi
    // ---------------------------------------------------------------
    public function show($id): ResponseInterface
    {
        $dataBayi = $this->dataBayiModel->find($id);

        if (!$dataBayi) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data bayi tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $dataBayi,
        ]);
    }
}