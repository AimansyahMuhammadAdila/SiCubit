<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProfilAction extends BaseController
{
    public function update(): ResponseInterface
    {
        // 1. Ambil ID dari session
        $userId = session()->get('user_id');

        // 2. Atur Rules Validasi
        $rules = [
            'nama' => 'required|min_length[3]',
            'umur' => 'required|integer',
            // Gunakan format ini agar nomor sendiri tidak dianggap duplikat
            'no_telp' => "required|min_length[8]|is_unique[users.no_telp,id,{$userId}]",
            'pekerjaan' => 'permit_empty',
            'jumlah_anak' => 'permit_empty|integer',
            'alamat' => 'permit_empty',
            'id_kabkota' => 'permit_empty',
            'id_puskesmas' => 'permit_empty',
            'status_kehamilan' => 'permit_empty|in_list[pra_kehamilan,hamil,pasca_melahirkan]',
        ];

        // 3. Jalankan Validasi
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Kumpulkan data yang dikirim
        $dataUpdate = [
            'nama' => $this->request->getPost('nama'),
            'umur' => (int) $this->request->getPost('umur'),
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'jumlah_anak' => (int) ($this->request->getPost('jumlah_anak') ?? 0),
            'no_telp' => $this->request->getPost('no_telp'),
            'alamat' => $this->request->getPost('alamat'),
            'id_kabkota' => $this->request->getPost('id_kabkota'),
            'id_puskesmas' => $this->request->getPost('id_puskesmas'),
            'status_kehamilan' => $this->request->getPost('status_kehamilan'),
        ];

        // Jika Bunda mengisi password baru, maka perbarui juga passwordnya
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            if ($password !== $this->request->getPost('konfirmasi_password')) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['password' => 'Konfirmasi password tidak cocok!']
                ]);
            }
            $dataUpdate['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Simpan ke Database
        $userModel = new UserModel();
        $userModel->skipValidation(true);
        if ($userModel->update($userId, $dataUpdate)) {
            session()->set([
                'nama' => $dataUpdate['nama'],
                'status_kehamilan' => $dataUpdate['status_kehamilan']
            ]);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data diri berhasil diperbarui.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui data profil.'
            ]);
        }
    }
}