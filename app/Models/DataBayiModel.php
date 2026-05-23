<?php

namespace App\Models;

use CodeIgniter\Model;

class DataBayiModel extends Model
{
    protected $table            = 'data_bayi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'tgl_pengisian',
        'golongan_darah',
        'berat_badan',
        'panjang_badan',
        'lingkar_kepala',
        'lingkar_dada',
        'lingkar_lengan_atas',
        'suhu',
        'reflek_mencari_puting',
        'reflek_mengisap',
        'reflek_menelan',
    ];

    protected $validationRules = [
        'user_id'               => 'required|integer',
        'tgl_pengisian'         => 'required|valid_date',
        'golongan_darah'        => 'permit_empty|in_list[A,B,AB,O]',
        'berat_badan'           => 'permit_empty|decimal',
        'panjang_badan'         => 'permit_empty|decimal',
        'lingkar_kepala'        => 'permit_empty|decimal',
        'lingkar_dada'          => 'permit_empty|decimal',
        'lingkar_lengan_atas'   => 'permit_empty|decimal',
        'suhu'                  => 'permit_empty|decimal',
        'reflek_mencari_puting' => 'permit_empty|in_list[Ya,Tidak]',
        'reflek_mengisap'       => 'permit_empty|in_list[Ya,Tidak]',
        'reflek_menelan'        => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua data bayi berdasarkan user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil data bayi terakhir.
     */
    public function getLatestByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->first();
    }

    /**
     * Ambil data bayi.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getDataBayi($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
