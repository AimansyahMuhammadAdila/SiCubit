<?php

namespace App\Controllers;

class Edukasi extends BaseController
{
    public function video()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = [
            'title' => 'Video Edukasi ASI - SI CUBIT',
        ];
        
        return view('edukasi/video', $data);
    }
}