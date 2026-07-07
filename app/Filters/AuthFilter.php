<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Cek apakah user sudah login sebelum mengakses rute yang dilindungi.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah session user_id tidak ada (belum login / sesi habis)
        if (!session()->get('user_id')) {

            // 1. Jika request meminta API atau dikirim via AJAX (Fetch/Axios)
            if ($request->isAJAX() || str_contains($request->getUri()->getPath(), 'api/')) {
                return service('response')->setJSON([
                    'status' => 'error',
                    'message' => 'Anda belum login. Silakan login terlebih dahulu.'
                ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            // 2. Jika request adalah akses halaman WEB biasa (seperti laktasi/cek)
            // Simpan pesan ke flashdata agar bisa ditangkap SweetAlert di halaman login
            session()->setFlashdata('error_session', 'Sesi Bunda telah berakhir. Yuk, login kembali!');

            // Redirect paksa secara halus ke halaman login
            return redirect()->to(base_url('login'));
        }
    }

    /**
     * After filter — tidak digunakan.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}
