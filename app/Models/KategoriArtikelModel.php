<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriArtikelModel extends Model
{
    protected $table            = 'kategori_artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    protected $validationRules = [
        'nama_kategori' => 'required|min_length[2]|max_length[100]',
        'slug'          => 'required|min_length[2]|max_length[100]',
        'deskripsi'     => 'permit_empty',
    ];
}
