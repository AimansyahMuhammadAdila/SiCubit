<?php

namespace App\Controllers;

use App\Models\VideoModel;

class Edukasi extends BaseController
{
    public function video()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $videoModel = new VideoModel();
        
        // Ambil semua video yang statusnya published, urutkan dari yang terbaru
        $videos = $videoModel->where('status', 'published')
                             ->orderBy('created_at', 'DESC')
                             ->findAll();

        $data = [
            'title'  => 'Video Edukasi - SI CUBIT',
            'videos' => $videos
        ];

        return view('edukasi/video', $data);
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