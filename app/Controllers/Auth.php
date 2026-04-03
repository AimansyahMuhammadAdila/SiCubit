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
        return view('welcome', $data); 
    }

    public function login()
    {
        // Menampilkan file login.php
        $data = [
            'title' => 'Login - SI CUBIT'
        ];
        return view('auth/login', $data); 
    }

    public function register()
    {
        // Menampilkan file register.php
        $data = [
            'title' => 'Register - SI CUBIT'
        ];
        return view('auth/register', $data); 
    }
}