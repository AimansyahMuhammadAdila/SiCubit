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
        'id_ibu',
        'tgl_pengisian',
        'cara_persalinan',
        'umur_kehamilan_salin',
        'imd',
    ];

    protected $validationRules = [
        'id_ibu'                => 'required|integer',
        'tgl_pengisian'         => 'required|valid_date',
        'cara_persalinan'       => 'required|in_list[Normal,Sectio Caesarea]',
        'umur_kehamilan_salin'  => 'required|integer|greater_than[0]|less_than[46]',
        'imd'                   => 'permit_empty|in_list[Ya,Tidak]',
    ];

    /**
     * Ambil semua riwayat persalinan berdasarkan ID ibu.
     */
    public function getByIbu(int $idIbu): array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }
}
