<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        // Menampilkan file welcome.php
        $data = [
            'title' => 'Welcome to SI CUBIT'
        ];
        return view('auth/welcome', $data);
    }

    public function login()
    {
        // Menampilkan file login.php
        $data = [
            'title' => 'Login - SI CUBIT'
        ];
        return view('auth/login', $data);
        if (!session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Silakan login sebagai petugas.');
        }
    }

    public function register()
    {
        // Menampilkan file register.php
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
        // Jika nama filenya lupa_password.php, maka tulisnya:
        return view('auth/lupa_password', $data);
    }
}