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
        'id_ibu',
        'tgl_pengisian',
        'bb_sebelum_hamil',
        'riwayat_penyakit',
        'riwayat_abortus',
    ];

    protected $validationRules = [
        'id_ibu'          => 'required|integer',
        'tgl_pengisian'   => 'required|valid_date',
        'bb_sebelum_hamil' => 'permit_empty|decimal',
        'riwayat_abortus' => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua riwayat pra-kehamilan berdasarkan ID ibu.
     */
    public function getByIbu(int $idIbu): array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }
}
