<?php

namespace App\Controllers;

class AuthAdmin extends BaseController
{
    public function login()
    {
        // Jika sudah login admin, langsung lempar ke dashboard admin
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        $data = [
            'title' => 'Login Petugas - SI CUBIT'
        ];
        return view('admin/auth/login_admin', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}