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
    // POST /api/data-bayi — Simpan data bayi
    // ---------------------------------------------------------------
    public function save(): ResponseInterface
    {
        $rules = [
            'tgl_pengisian'         => 'required|valid_date',
            'golongan_darah'        => 'permit_empty|in_list[A,B,AB,O]',
            'berat_badan'           => 'permit_empty|decimal',
            'panjang_badan'         => 'permit_empty|decimal',
            'lingkar_kepala'        => 'permit_empty|decimal',
            'lingkar_dada'          => 'permit_empty|decimal',
            'lingkar_lengan_atas'   => 'permit_empty|decimal',
            'suhu'                  => 'permit_empty|decimal',
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

        $data = [
            'user_id'               => $userId,
            'tgl_pengisian'         => $this->request->getPost('tgl_pengisian'),
            'golongan_darah'        => $this->request->getPost('golongan_darah'),
            'berat_badan'           => $this->request->getPost('berat_badan'),
            'panjang_badan'         => $this->request->getPost('panjang_badan'),
            'lingkar_kepala'        => $this->request->getPost('lingkar_kepala'),
            'lingkar_dada'          => $this->request->getPost('lingkar_dada'),
            'lingkar_lengan_atas'   => $this->request->getPost('lingkar_lengan_atas'),
            'suhu'                  => $this->request->getPost('suhu'),
            'reflek_mencari_puting' => $this->request->getPost('reflek_mencari_puting') ?? 'Ya',
            'reflek_mengisap'       => $this->request->getPost('reflek_mengisap') ?? 'Ya',
            'reflek_menelan'        => $this->request->getPost('reflek_menelan') ?? 'Ya',
        ];

        if (!$this->dataBayiModel->insert($data, false)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data bayi.',
                'errors'  => $this->dataBayiModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data bayi berhasil disimpan.',
            'data'    => ['id' => $this->dataBayiModel->getInsertID()],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // GET /api/data-bayi — Semua data bayi user
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
