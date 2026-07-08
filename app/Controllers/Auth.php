<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Welcome to SI CUBIT'
        ];
        return view('auth/welcome', $data);
    }

    public function login()
    {
        // Jika user sudah login (misal session id_user ada), langsung lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login - SI CUBIT'
        ];
        
        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Register - SI CUBIT'
        ];
        return view('auth/register', $data);
    }

    public function lupaPassword()
    {
        $data = [
            'title' => 'Lupa Password - SI CUBIT'
        ];
        return view('auth/lupa_password', $data);
    }
}