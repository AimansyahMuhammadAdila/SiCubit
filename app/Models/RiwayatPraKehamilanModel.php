<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPraKehamilanModel extends Model
{
    protected $table            = 'riwayat_pra_kehamilan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'tgl_pengisian',
        'bb_sebelum_hamil',
        'riwayat_penyakit',
        'riwayat_abortus',
    ];

    protected $validationRules = [
        'user_id'          => 'required|integer',
        'tgl_pengisian'   => 'required|valid_date',
        'bb_sebelum_hamil' => 'permit_empty|decimal',
        'riwayat_abortus' => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua riwayat pra-kehamilan berdasarkan ID user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil data riwayat pra-kehamilan.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getRiwayatPraKehamilan($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
