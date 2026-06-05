<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'nama',
        'umur',
        'pekerjaan',
        'jumlah_anak',
        'no_telp',
        'alamat',
        'id_kabkota',
        'id_puskesmas',
        'role',
        'status_kehamilan',
        'password_hash'
    ];

    // ---------------------------------------------------------------
    // Validation Rules
    // ---------------------------------------------------------------

    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'umur' => 'permit_empty|integer|greater_than[0]|less_than[100]',
        'no_telp' => 'required|min_length[8]|max_length[20]|is_unique[users.no_telp,id,{id}]',
        'password_hash' => 'required',
        'status_kehamilan' => 'permit_empty|in_list[pra_kehamilan,hamil,pasca_melahirkan]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'no_telp' => [
            'required' => 'Nomor telepon wajib diisi.',
            'is_unique' => 'Nomor telepon sudah terdaftar.',
        ],
    ];

    // ---------------------------------------------------------------
    // Custom Query Methods
    // ---------------------------------------------------------------

    /**
     * Cari ibu berdasarkan nomor telepon (untuk login).
     */
    public function findByNoTelp(string $noTelp): ?array
    {
        return $this->where('no_telp', $noTelp)->first();
    }

    /**
     * Ambil data ibu dengan riwayat singkat (summary).
     */
    public function getWithSummary(int $id): ?array
    {
        $ibu = $this->find($id);
        if (!$ibu) {
            return null;
        }

        $db = \Config\Database::connect();

        $ibu['total_riwayat_kehamilan'] = $db->table('riwayat_kehamilan')
            ->where('user_id', $id)->countAllResults();

        $ibu['total_cek_asi'] = $db->table('cek_kelancaran_asi')
            ->where('user_id', $id)->countAllResults();

        return $ibu;
    }
    /**
     * Ambil data user lengkap dengan nama Kabupaten/Kota dan Puskesmas (JOIN)
     */
    public function getUserWithWilayah(int $id): ?array
    {
        return $this->select('users.*, kabupaten_kota.nama as nama_kabkota, kabupaten_kota.tipe as tipe_kabkota, puskesmas.nama as nama_puskesmas')
            ->join('kabupaten_kota', 'kabupaten_kota.id = users.id_kabkota', 'left')
            ->join('puskesmas', 'puskesmas.id = users.id_puskesmas', 'left')
            ->where('users.id', $id)
            ->first();
    }
}
