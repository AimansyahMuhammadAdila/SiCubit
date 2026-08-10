<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\VideoModel;
use CodeIgniter\HTTP\ResponseInterface;

class ContentAction extends BaseController
{
    protected ?ArtikelModel $artikelModel = null;
    protected ?VideoModel   $videoModel = null;

    public function __construct()
    {
        try {
            $this->artikelModel = new ArtikelModel();
            $this->videoModel   = new VideoModel();
        } catch (\Throwable $e) {}
    }

    // ---------------------------------------------------------------
    // ARTIKEL
    // ---------------------------------------------------------------

    public function listArtikel(): ResponseInterface
    {
        try {
            $artikel = $this->artikelModel ? $this->artikelModel->where('status', 'published')
                                          ->orderBy('created_at', 'DESC')
                                          ->findAll() : [];
        } catch (\Throwable $e) {
            $artikel = [];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $artikel,
        ]);
    }

    public function getArtikel($idOrSlug): ResponseInterface
    {
        // Bisa mengambil berdasarkan ID atau slug
        if (is_numeric($idOrSlug)) {
            $artikel = $this->artikelModel->where('status', 'published')->find($idOrSlug);
        } else {
            $artikel = $this->artikelModel->where('status', 'published')
                                          ->where('slug', $idOrSlug)
                                          ->first();
        }

        if (!$artikel) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Artikel tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $artikel,
        ]);
    }

    // ---------------------------------------------------------------
    // VIDEO
    // ---------------------------------------------------------------

    public function listVideo(): ResponseInterface
    {
        // Hanya menampilkan yang published
        $videos = $this->videoModel->where('status', 'published')
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $videos,
        ]);
    }

    public function getVideo($id): ResponseInterface
    {
        $video = $this->videoModel->where('status', 'published')->find($id);

        if (!$video) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Video tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $video,
        ]);
    }
}
