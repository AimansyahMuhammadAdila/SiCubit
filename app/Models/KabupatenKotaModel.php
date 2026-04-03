<?php

namespace App\Models;

use CodeIgniter\Model;

class KabupatenKotaModel extends Model
{
    protected $table            = 'kabupaten_kota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'id',
        'nama',
        'tipe',
    ];

    // ---------------------------------------------------------------
    // Validation Rules
    // ---------------------------------------------------------------

    protected $validationRules = [
        'id'   => 'required|max_length[10]',
        'nama' => 'required|max_length[100]',
        'tipe' => 'required|in_list[Kabupaten,Kota]',
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'Kode kabupaten/kota wajib diisi.',
        ],
        'nama' => [
            'required' => 'Nama kabupaten/kota wajib diisi.',
        ],
    ];

    // ---------------------------------------------------------------
    // Custom Query Methods
    // ---------------------------------------------------------------

    /**
     * Ambil semua kabupaten/kota, diurutkan berdasarkan nama.
     */
    public function getAllSorted(): array
    {
        return $this->orderBy('nama', 'ASC')->findAll();
    }

    /**
     * Ambil kabupaten/kota berdasarkan tipe (Kabupaten / Kota).
     */
    public function getByTipe(string $tipe): array
    {
        return $this->where('tipe', $tipe)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil daftar puskesmas di kabupaten/kota ini.
     */
    public function getPuskesmas(string $idKabkota): array
    {
        return model(PuskesmasModel::class)
            ->where('id_kabkota', $idKabkota)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }
}
