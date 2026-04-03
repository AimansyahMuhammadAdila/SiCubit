<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

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
            'nama'          => 'required|min_length[3]|max_length[100]',
            'umur'          => 'required|integer|greater_than[0]|less_than[100]',
            'no_telp'       => 'required|min_length[8]|max_length[20]|is_unique[users.no_telp]',
            'password'      => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password]',
            'pekerjaan'     => 'permit_empty|max_length[100]',
            'jumlah_anak'   => 'permit_empty|integer|greater_than_equal_to[0]',
            'alamat'        => 'permit_empty',
            'id_kabkota'    => 'permit_empty|max_length[10]',
            'id_puskesmas'  => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama wajib diisi.',
                'min_length' => 'Nama minimal 3 karakter.',
            ],
            'no_telp' => [
                'required'  => 'Nomor telepon wajib diisi.',
                'is_unique' => 'Nomor telepon sudah terdaftar.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
            'konfirmasi_password' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Hash password
        $passwordHash = password_hash(
            $this->request->getPost('password'),
            PASSWORD_BCRYPT
        );

        // Siapkan data
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'umur'          => (int) $this->request->getPost('umur'),
            'pekerjaan'     => $this->request->getPost('pekerjaan'),
            'jumlah_anak'   => (int) ($this->request->getPost('jumlah_anak') ?? 0),
            'no_telp'       => $this->request->getPost('no_telp'),
            'alamat'        => $this->request->getPost('alamat'),
            'id_kabkota'    => $this->request->getPost('id_kabkota'),
            'id_puskesmas'  => $this->request->getPost('id_puskesmas'),
            'password_hash' => $passwordHash,
        ];

        // Simpan ke database
        if (!$this->userModel->insert($data, false)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data.',
                'errors'  => $this->userModel->errors(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Registrasi berhasil.',
            'data'    => ['id' => $this->userModel->getInsertID()],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // LOGIN — POST /api/login
    // ---------------------------------------------------------------

    public function login(): ResponseInterface
    {
        $rules = [
            'no_telp'  => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nomor telepon dan password wajib diisi.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        $noTelp   = $this->request->getPost('no_telp');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan no_telp
        $user = $this->userModel->findByNoTelp($noTelp);

        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nomor telepon tidak ditemukan.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Verifikasi password
        if (!password_verify($password, $user['password_hash'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Password salah.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Set session
        $session = session();
        $session->set([
            'user_id'   => $user['id'],
            'nama'      => $user['nama'],
            'no_telp'   => $user['no_telp'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Login berhasil.',
            'data'    => [
                'id'     => $user['id'],
                'nama'   => $user['nama'],
                'no_telp' => $user['no_telp'],
                'role'   => $user['role'],
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
            'status'  => 'success',
            'message' => 'Logout berhasil.',
        ]);
    }
}
