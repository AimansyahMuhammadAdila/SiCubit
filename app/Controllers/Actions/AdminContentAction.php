<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\VideoModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminContentAction extends BaseController
{
    protected ArtikelModel $artikelModel;
    protected VideoModel   $videoModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->videoModel   = new VideoModel();
    }

    // ---------------------------------------------------------------
    // ARTIKEL (CRUD Admin)
    // ---------------------------------------------------------------

    public function createArtikel(): ResponseInterface
    {
        $rules = $this->artikelModel->getValidationRules();
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->request->getPost();
        if (!$this->artikelModel->insert($data, false)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan artikel',
                'errors'  => $this->artikelModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Artikel berhasil ditambahkan.',
            'data'    => ['id' => $this->artikelModel->getInsertID()],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function updateArtikel($id): ResponseInterface
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Artikel tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $data = $this->request->getRawInput();
        
        // Pengecualian field is_unique jika slug tidak berubah
        if (isset($data['slug']) && $data['slug'] === $artikel['slug']) {
            $rules = $this->artikelModel->getValidationRules(['except' => ['slug']]);
            $rules['slug'] = 'required|max_length[255]'; 
        } else {
            $rules = $this->artikelModel->getValidationRules();
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->artikelModel->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal mengubah artikel',
                'errors'  => $this->artikelModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Artikel berhasil diubah.',
        ]);
    }

    public function deleteArtikel($id): ResponseInterface
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Artikel tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->artikelModel->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Artikel berhasil dihapus.',
        ]);
    }

    // ---------------------------------------------------------------
    // VIDEO (CRUD Admin)
    // ---------------------------------------------------------------

    public function createVideo(): ResponseInterface
    {
        $rules = $this->videoModel->getValidationRules();
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->request->getPost();
        if (!$this->videoModel->insert($data, false)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan video',
                'errors'  => $this->videoModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Video berhasil ditambahkan.',
            'data'    => ['id' => $this->videoModel->getInsertID()],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function updateVideo($id): ResponseInterface
    {
        $video = $this->videoModel->find($id);
        if (!$video) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Video tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $data = $this->request->getRawInput();
        $rules = $this->videoModel->getValidationRules();

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->videoModel->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal mengubah video',
                'errors'  => $this->videoModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Video berhasil diubah.',
        ]);
    }

    public function deleteVideo($id): ResponseInterface
    {
        $video = $this->videoModel->find($id);
        if (!$video) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Video tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->videoModel->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Video berhasil dihapus.',
        ]);
    }
}
