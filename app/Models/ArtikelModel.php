<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'judul',
        'slug',
        'thumbnail_url',
        'isi_konten',
        'id_penulis',
        'status',
    ];

    protected $validationRules = [
        'judul'         => 'required|min_length[5]|max_length[255]',
        'slug'          => 'required|max_length[255]|is_unique[artikel.slug,id,{id}]',
        'thumbnail_url' => 'permit_empty|valid_url|max_length[255]',
        'isi_konten'    => 'required',
        'id_penulis'    => 'required|integer',
        'status'        => 'permit_empty|in_list[draft,published]',
    ];

    /**
     * Ambil data artikel.
     * Jika $slug false, ambil semua. Jika ada slug, ambil satu.
     */
    public function getArtikel($slug = false)
    {
        if ($slug === false) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
