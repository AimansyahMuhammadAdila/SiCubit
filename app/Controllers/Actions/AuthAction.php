<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KabupatenKotaModel;
use App\Models\PuskesmasModel;

class AuthAction extends BaseController
{
    protected ?UserModel $userModel = null;

    public function __construct()
    {
        try {
            $this->userModel = new UserModel();
        } catch (\Throwable $e) {}
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

        try {
            if (!$this->validate($rules, $messages)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Validasi gagal.',
                    'errors' => $this->validator ? $this->validator->getErrors() : [],
                ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Throwable $e) {}

        // Hash password
        $passwordHash = password_hash(
            $this->request->getPost('password'),
            PASSWORD_BCRYPT
        );

        // Siapkan data
        $idKabKota = $this->request->getPost('id_kabkota');
        $idPuskesmas = $this->request->getPost('id_puskesmas');
        $umur = $this->request->getPost('umur');
        $jumlahAnak = $this->request->getPost('jumlah_anak');
        $nama = trim($this->request->getPost('nama') ?? '');
        $noTelp = trim($this->request->getPost('no_telp') ?? '');

        $data = [
            'nama'             => $nama,
            'role'             => 'ibu',
            'umur'             => (!empty($umur) && is_numeric($umur)) ? (int) $umur : null,
            'pekerjaan'        => $this->request->getPost('pekerjaan') ?: null,
            'jumlah_anak'      => (!empty($jumlahAnak) && is_numeric($jumlahAnak)) ? (int) $jumlahAnak : 0,
            'no_telp'          => $noTelp,
            'alamat'           => $this->request->getPost('alamat') ?: null,
            'id_kabkota'       => !empty($idKabKota) ? $idKabKota : null,
            'id_puskesmas'     => !empty($idPuskesmas) ? $idPuskesmas : null,
            'status_kehamilan' => $this->request->getPost('status_kehamilan') ?: 'pasca_melahirkan',
            'password_hash'    => $passwordHash,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        // Simpan ke database secara langsung
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            
            // Cek duplikasi nomor telepon secara manual
            $existing = $builder->where('no_telp', $noTelp)->get()->getRowArray();
            if ($existing) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Nomor WhatsApp sudah terdaftar. Silakan langsung login.',
                ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
            }

            $inserted = $builder->insert($data);
            if (!$inserted) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan data pendaftaran ke database.',
                ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }
            $insertId = $db->insertID();
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Set session otomatis
        $sessData = [
            'is_logged_in' => true,
            'logged_in'    => true,
            'is_admin'     => false,
            'user_id'      => $insertId,
            'id'           => $insertId,
            'nama'         => $nama,
            'no_telp'      => $noTelp,
            'role'         => 'ibu',
        ];
        session()->set($sessData);
        if (session_status() === PHP_SESSION_ACTIVE) {
            foreach ($sessData as $k => $v) {
                $_SESSION[$k] = $v;
            }
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Registrasi berhasil. Selamat datang di SiCubit!',
            'data'    => [
                'id'   => $insertId,
                'role' => 'ibu',
                'user' => $sessData,
            ],
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    // ---------------------------------------------------------------
    // LOGIN — POST /api/login
    // ---------------------------------------------------------------

    public function login(): ResponseInterface
    {
        // Rate Limiter: Maksimal 25 percobaan login per menit per IP
        try {
            $throttler = \Config\Services::throttler();
            if ($throttler->check(md5($this->request->getIPAddress() . 'login'), 25, MINUTE) === false) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.',
                ])->setStatusCode(429);
            }
        } catch (\Throwable $e) {}

        $noTelp = trim($this->request->getPost('no_telp') ?? '');
        $password = trim($this->request->getPost('password') ?? '');

        if (empty($noTelp) || empty($password)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nomor WhatsApp / Username dan Password wajib diisi.',
            ])->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY);
        }

        // DUKUNGAN LOGIN KHUSUS ADMIN (Username 'Admin' / 'admin' / 'bidan')
        if (strcasecmp($noTelp, 'Admin') === 0 || strcasecmp($noTelp, 'admin') === 0 || strcasecmp($noTelp, 'bidan') === 0) {
            if ($password !== 'Admin123') {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Password Admin salah! Silakan gunakan password Admin123.',
                ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            $adminUser = null;
            try {
                $db = \Config\Database::connect();
                $adminUser = $db->table('users')->where('role', 'admin')->get()->getRowArray()
                          ?: $db->table('users')->where('no_telp', 'Admin')->get()->getRowArray();
            } catch (\Throwable $e) {}

            $adminId = $adminUser['id'] ?? 1;
            $adminName = $adminUser['nama'] ?? 'Admin Bidan SiCubit';

            $sessData = [
                'is_logged_in' => true,
                'logged_in'    => true,
                'is_admin'     => true,
                'user_id'      => $adminId,
                'id'           => $adminId,
                'nama'         => $adminName,
                'no_telp'      => 'Admin',
                'role'         => 'admin',
            ];

            session()->set($sessData);
            if (session_status() === PHP_SESSION_ACTIVE) {
                foreach ($sessData as $k => $v) {
                    $_SESSION[$k] = $v;
                }
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Login Admin Berhasil! Mengalihkan ke Panel Kendali Bidan...',
                'data'    => [
                    'role' => 'admin',
                    'user' => [
                        'id'      => $adminId,
                        'nama'    => $adminName,
                        'no_telp' => 'Admin',
                        'role'    => 'admin',
                    ],
                ],
            ]);
        }

        $cleanTelp = preg_replace('/[^0-9]/', '', $noTelp);
        $altTelp = '';
        if (str_starts_with($cleanTelp, '62')) {
            $altTelp = '0' . substr($cleanTelp, 2);
        } elseif (str_starts_with($cleanTelp, '0')) {
            $altTelp = '62' . substr($cleanTelp, 1);
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            
            $builder->groupStart()
                ->where('no_telp', $noTelp)
                ->orWhere('nama', $noTelp);
            
            if (!empty($cleanTelp)) {
                $builder->orWhere('no_telp', $cleanTelp);
            }
            if (!empty($altTelp)) {
                $builder->orWhere('no_telp', $altTelp);
            }
            $user = $builder->groupEnd()->get()->getRowArray();
        } catch (\Throwable $e) {
            $user = null;
        }

        if (!$user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Nomor WhatsApp atau Username tidak terdaftar. Silakan registrasi akun terlebih dahulu.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        if (!password_verify($password, $user['password_hash'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Password yang Anda masukkan salah.',
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        try {
            $sessData = [
                'is_logged_in' => true,
                'logged_in'    => true,
                'is_admin'     => ($user['role'] === 'admin' || $user['role'] === 'bidan'),
                'user_id'      => $user['id'],
                'id'           => $user['id'],
                'nama'         => $user['nama'],
                'no_telp'      => $user['no_telp'],
                'role'         => $user['role'],
            ];
            session()->set($sessData);
            if (session_status() === PHP_SESSION_ACTIVE) {
                foreach ($sessData as $k => $v) {
                    $_SESSION[$k] = $v;
                }
            }
        } catch (\Throwable $e) {}

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'data' => [
                'role' => $user['role'],
                'user' => [
                    'id' => $user['id'],
                    'nama' => $user['nama'],
                    'no_telp' => $user['no_telp'],
                    'role' => $user['role'],
                ],
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
