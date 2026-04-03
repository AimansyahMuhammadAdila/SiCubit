<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatKehamilanModel extends Model
{
    protected $table            = 'riwayat_kehamilan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'tgl_pengisian',
        'kehamilan_ke',
        'umur_kehamilan',
        'bb',
        'kadar_hb',
        'ukuran_lila',
        'kunjungan_anc',
        'konsumsi_ttd',
        'periksa_hiv',
        'periksa_hbsag',
        'info_kespro',
        'status_bahagia',
    ];

    protected $validationRules = [
        'user_id'          => 'required|integer',
        'tgl_pengisian'   => 'required|valid_date',
        'kehamilan_ke'    => 'required|integer|greater_than[0]',
        'umur_kehamilan'  => 'required|integer|greater_than[0]|less_than[46]',
        'bb'              => 'permit_empty|decimal',
        'kadar_hb'        => 'permit_empty|decimal',
        'ukuran_lila'     => 'permit_empty|decimal',
        'kunjungan_anc'   => 'permit_empty|integer',
        'konsumsi_ttd'    => 'permit_empty|in_list[Ya,Tidak]',
        'periksa_hiv'     => 'permit_empty|in_list[Ya,Tidak]',
        'periksa_hbsag'   => 'permit_empty|in_list[Ya,Tidak]',
        'info_kespro'     => 'permit_empty|in_list[Ya,Tidak]',
        'status_bahagia'  => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua riwayat kehamilan berdasarkan ID user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil riwayat kehamilan terakhir.
     */
    public function getLatestByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->first();
    }

    /**
     * Ambil data riwayat kehamilan.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getRiwayatKehamilan($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
