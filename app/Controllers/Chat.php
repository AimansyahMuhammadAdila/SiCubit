<?php

namespace App\Controllers;

class Chat extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to(base_url('login'));

        $data = ['title' => 'Bidan AI - SI CUBIT'];
        return view('chat/index', $data);
    }
}