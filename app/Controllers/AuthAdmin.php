<?php

namespace App\Controllers;

class AuthAdmin extends BaseController
{
    public function login()
    {
        if (session()->get("is_admin")) {
            return redirect()->to(base_url("admin/dashboard"));
        }
        return redirect()->to(base_url("login"));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url("login"));
    }
}
