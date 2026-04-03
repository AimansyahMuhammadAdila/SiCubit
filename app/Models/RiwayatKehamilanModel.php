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
        'id_ibu',
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
        'id_ibu'          => 'required|integer',
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
     * Ambil semua riwayat kehamilan berdasarkan ID ibu.
     */
    public function getByIbu(int $idIbu): array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil riwayat kehamilan terakhir.
     */
    public function getLatestByIbu(int $idIbu): ?array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->first();
    }
}
