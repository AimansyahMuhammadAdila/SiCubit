<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KabupatenKotaModel;
use App\Models\PuskesmasModel;

class AuthAction extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ---------------------------------------------------------------
    // REGISTER — POST /api/register
    // ---------------------------------------------------------------

    public function register(): ResponseInterface
    {
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'umur' => 'permit_empty|integer|greater_than[0]|less_than[100]',
            'no_telp' => 'required|min_length[8]|max_length[20]|is_unique[users.no_telp]',
            'password' => 'required|min_length[6]',
            'konfirmasi_password' => 'permit_empty|matches[password]',
            'pekerjaan' => 'permit_empty|max_length[100]',
            'jumlah_anak' => 'permit_empty|integer|greater_than_equal_to[0]',
            'alamat' => 'permit_empty',
            'id_kabkota' => 'permit_empty|max_length[10]',
            'id_puskesmas' => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'nama' => [
                'required' => 'Nama wajib diisi.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
            'no_telp' => [
                'required' => 'Nomor telepon wajib diisi.',
                'is_unique' => 'Nomor telepon sudah terdaftar.',
            ],
            'password' => [
                'required' => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
            'konfirmasi_password' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Hash password
        $passwordHash = password_hash(
            $this->request->getPost('password'),
            PASSWORD_BCRYPT
        );

        // Siapkan data
        $data = [
            'nama' => $this->request->getPost('nama'),
            'umur' => (int) $this->request->getPost('umur'),
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'jumlah_anak' => (int) ($this->request->getPost('jumlah_anak') ?? 0),
            'no_telp' => $this->request->getPost('no_telp'),
            'alamat' => $this->request->getPost('alamat'),
            'id_kabkota' => $this->request->getPost('id_kabkota'),
            'id_puskesmas' => $this->request->getPost('id_puskesmas'),
            'status_kehamilan' => $this->request->getPost('status_kehamilan') ?: 'pasca_melahirkan',
            'password_hash' => $passwordHash,
        ];

        // Simpan ke database
        if (!$this->userModel->insert($data, false)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data.',
                'errors' => $this->userModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Registrasi berhasil.',
            'data' => ['id' => $this->userModel->getInsertID()],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // LOGIN — POST /api/login
    // ---------------------------------------------------------------

    public function login(): ResponseInterface
    {
        // Rate Limiter: Maksimal 15 percobaan login per menit per IP
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress() . 'login'), 15, MINUTE) === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.',
            ])->setStatusCode(429);
        }

        $rules = [
            'no_telp' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nomor telepon dan password wajib diisi.',
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $noTelp = $this->request->getPost('no_telp');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan no_telp
        $user = $this->userModel->findByNoTelp($noTelp);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nomor telepon tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Verifikasi password
        if (!password_verify($password, $user['password_hash'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Password salah.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Set session
        $session = session();
        $sessionData = [
            'user_id' => $user['id'],
            'nama' => $user['nama'],
            'no_telp' => $user['no_telp'],
            'role' => $user['role'],
            'status_kehamilan' => $user['status_kehamilan'],
            'logged_in' => true,
        ];

        // Jika role admin/bidan, set flag is_admin agar bisa akses panel admin
        if ($user['role'] === 'admin' || $user['role'] === 'bidan') {
            $sessionData['is_admin'] = true;
        }

        $session->set($sessionData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'data' => [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'no_telp' => $user['no_telp'],
                'role' => $user['role'],
            ],
        ]);
    }

    // ---------------------------------------------------------------
    // LOGOUT — POST /api/logout
    // ---------------------------------------------------------------

    public function logout(): ResponseInterface
    {
        $session = session();
        $session->destroy();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Logout berhasil.',
        ]);
    }
    // ---------------------------------------------------------------
    // GET WILAYAH — Untuk Dropdown Dinamis di Register
    // ---------------------------------------------------------------

    public function getKabkota(): ResponseInterface
    {
        $kabkotaModel = new KabupatenKotaModel();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $kabkotaModel->getAllSorted()
        ]);
    }

    public function getPuskesmas($idKabkota): ResponseInterface
    {
        $puskesmasModel = new PuskesmasModel();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $puskesmasModel->getByKabkota($idKabkota)
        ]);
    }

    // ---------------------------------------------------------------
    // RESET PASSWORD — POST /api/reset-password
    // ---------------------------------------------------------------
    public function resetPassword(): ResponseInterface
    {
        $rules = [
            'no_telp' => 'required',
            'password' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password]',
        ];

        $messages = [
            'password' => [
                'min_length' => 'Password baru minimal 6 karakter.'
            ],
            'konfirmasi_password' => [
                'matches' => 'Konfirmasi password tidak cocok dengan password baru.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $noTelp = $this->request->getPost('no_telp');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan nomor telepon
        $user = $this->userModel->findByNoTelp($noTelp);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nomor WhatsApp tidak terdaftar di sistem kami.',
            ]);
        }

        // Hash password baru dan update ke database
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if ($this->userModel->update($user['id'], ['password_hash' => $passwordHash])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Password berhasil direset. Silakan login kembali.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal mereset password. Terjadi kesalahan server.',
        ]);
    }
    public function adminLogin(): ResponseInterface
    {
        // Rate Limiter: Maksimal 10 percobaan login admin per menit per IP
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress() . 'adminLogin'), 10, MINUTE) === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login admin. Silakan tunggu 1 menit.',
            ])->setStatusCode(429);
        }

        $email = $this->request->getPost('email'); // Bisa NIP atau Email
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();

        // Cari berdasarkan no_telp (NIP) atau email (jika ada kolom email)
        // Di sini kita asumsikan NIP disimpan di kolom no_telp atau buat filter where
        $user = $userModel->where('no_telp', $email)
            ->orWhere('nama', $email) // Atau kolom identitas lain
            ->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            // CEK ROLE: Hanya 'admin' atau 'bidan' yang boleh masuk
            if ($user['role'] !== 'admin' && $user['role'] !== 'bidan') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Akses ditolak. Akun ini bukan akun Petugas Kesehatan.'
                ]);
            }

            // Set Session Admin
            session()->set([
                'user_id' => $user['id'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'logged_in' => true,
                'is_admin' => true
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Selamat bertugas, ' . $user['nama'],
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'ID Petugas atau Password salah.'
        ]);
    }
}
