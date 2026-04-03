<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPersalinanModel extends Model
{
    protected $table            = 'riwayat_persalinan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'tgl_pengisian',
        'cara_persalinan',
        'umur_kehamilan_salin',
        'imd',
    ];

    protected $validationRules = [
        'user_id'                => 'required|integer',
        'tgl_pengisian'         => 'required|valid_date',
        'cara_persalinan'       => 'required|in_list[Normal,Sectio Caesarea]',
        'umur_kehamilan_salin'  => 'required|integer|greater_than[0]|less_than[46]',
        'imd'                   => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua riwayat persalinan berdasarkan ID user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil data riwayat persalinan.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getRiwayatPersalinan($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
