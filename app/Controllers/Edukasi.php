<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\KategoriVideoModel;
use App\Models\VideoModel;

class Edukasi extends BaseController
{
    public function video()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $videoModel    = new VideoModel();
        $kategoriModel = new KategoriVideoModel();

        $activeKategori = $this->request->getGet('kategori');
        $searchQuery    = trim($this->request->getGet('q') ?? '');

        $builder = $videoModel->select('video.*, kategori_video.nama_kategori, kategori_video.slug as kategori_slug')
                              ->join('kategori_video', 'kategori_video.id = video.id_kategori', 'left')
                              ->where('video.status', 'published')
                              ->orderBy('video.created_at', 'DESC');

        if (!empty($activeKategori)) {
            $builder->groupStart()
                    ->where('kategori_video.slug', $activeKategori)
                    ->orWhere('video.id_kategori', $activeKategori)
                    ->groupEnd();
        }

        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('video.judul', $searchQuery)
                    ->orLike('video.deskripsi', $searchQuery)
                    ->groupEnd();
        }

        $videos = $builder->findAll();

        foreach ($videos as &$vid) {
            $vid['youtube_id'] = \App\Controllers\Admin::extractYoutubeId($vid['video_url'] ?? '');
        }

        $data = [
            'title'          => 'Video Edukasi - SI CUBIT',
            'videos'         => $videos,
            'categories'     => $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
            'activeKategori' => $activeKategori,
            'searchQuery'    => $searchQuery,
            'activeTab'      => 'video',
        ];

        return view('edukasi/video', $data);
    }

    public function artikel()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $artikelModel  = new ArtikelModel();
        $kategoriModel = new KategoriArtikelModel();

        $activeKategori = $this->request->getGet('kategori');
        $searchQuery    = trim($this->request->getGet('q') ?? '');

        $builder = $artikelModel->select('artikel.*, users.nama as nama_penulis, users.role as role_penulis, kategori_artikel.nama_kategori, kategori_artikel.slug as kategori_slug')
                                ->join('users', 'users.id = artikel.id_penulis', 'left')
                                ->join('kategori_artikel', 'kategori_artikel.id = artikel.id_kategori', 'left')
                                ->where('artikel.status', 'published')
                                ->orderBy('artikel.created_at', 'DESC');

        if (!empty($activeKategori)) {
            $builder->groupStart()
                    ->where('kategori_artikel.slug', $activeKategori)
                    ->orWhere('artikel.id_kategori', $activeKategori)
                    ->groupEnd();
        }

        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('artikel.judul', $searchQuery)
                    ->orLike('artikel.isi_konten', $searchQuery)
                    ->groupEnd();
        }

        $artikels = $builder->findAll();

        $data = [
            'title'          => 'Artikel Edukasi & Berita - SI CUBIT',
            'artikels'       => $artikels,
            'categories'     => $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
            'activeKategori' => $activeKategori,
            'searchQuery'    => $searchQuery,
            'activeTab'      => 'artikel',
        ];

        return view('edukasi/artikel', $data);
    }

    public function detailArtikel($slugOrId)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $artikelModel = new ArtikelModel();

        $builder = $artikelModel->select('artikel.*, users.nama as nama_penulis, users.role as role_penulis')
                                ->join('users', 'users.id = artikel.id_penulis', 'left')
                                ->where('artikel.status', 'published');

        if (is_numeric($slugOrId)) {
            $artikel = $builder->where('artikel.id', $slugOrId)->first();
        } else {
            $artikel = $builder->where('artikel.slug', $slugOrId)->first();
        }

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        $data = [
            'title'   => esc($artikel['judul']) . ' - SI CUBIT Artikel',
            'artikel' => $artikel,
        ];

        return view('edukasi/detail_artikel', $data);
    }

    public function faq()
    {
        // Menyiapkan data yang akan dikirim ke view
        $data = [
            'title' => 'FAQ Laktasi - SiCubit'
        ];

        // Memanggil file view yang baru saja kita buat (app/Views/edukasi/faq.php)
        return view('edukasi/faq', $data);
    }
}