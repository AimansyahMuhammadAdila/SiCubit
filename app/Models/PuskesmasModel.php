<?php

namespace App\Models;

use CodeIgniter\Model;

class PuskesmasModel extends Model
{
    protected $table            = 'puskesmas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'id',
        'id_kabkota',
        'nama',
        'alamat',
    ];

    // ---------------------------------------------------------------
    // Validation Rules
    // ---------------------------------------------------------------

    protected $validationRules = [
        'id'         => 'required|max_length[20]',
        'id_kabkota' => 'required|max_length[10]',
        'nama'       => 'required|max_length[150]',
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'Kode puskesmas wajib diisi.',
        ],
        'id_kabkota' => [
            'required' => 'Kabupaten/kota wajib dipilih.',
        ],
        'nama' => [
            'required' => 'Nama puskesmas wajib diisi.',
        ],
    ];

    // ---------------------------------------------------------------
    // Custom Query Methods
    // ---------------------------------------------------------------

    /**
     * Ambil semua puskesmas, diurutkan berdasarkan nama.
     */
    public function getAllSorted(): array
    {
        return $this->orderBy('nama', 'ASC')->findAll();
    }

    /**
     * Ambil puskesmas berdasarkan kabupaten/kota.
     */
    public function getByKabkota(string $idKabkota): array
    {
        return $this->where('id_kabkota', $idKabkota)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil data puskesmas lengkap dengan nama kabupaten/kota.
     */
    public function getWithKabkota(string $id): ?array
    {
        return $this->select('puskesmas.*, kabupaten_kota.nama as nama_kabkota, kabupaten_kota.tipe')
                    ->join('kabupaten_kota', 'kabupaten_kota.id = puskesmas.id_kabkota', 'left')
                    ->where('puskesmas.id', $id)
                    ->first();
    }

    /**
     * Ambil semua puskesmas lengkap dengan nama kabupaten/kota.
     */
    public function getAllWithKabkota(): array
    {
        return $this->select('puskesmas.*, kabupaten_kota.nama as nama_kabkota, kabupaten_kota.tipe')
                    ->join('kabupaten_kota', 'kabupaten_kota.id = puskesmas.id_kabkota', 'left')
                    ->orderBy('puskesmas.nama', 'ASC')
                    ->findAll();
    }
}
