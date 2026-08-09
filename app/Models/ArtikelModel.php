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
        'id_kategori',
        'isi_konten',
        'id_penulis',
        'status',
    ];

    protected $validationRules = [
        'judul'         => 'required|min_length[3]|max_length[255]',
        'slug'          => 'required|max_length[255]',
        'thumbnail_url' => 'permit_empty|max_length[255]',
        'isi_konten'    => 'required',
        'id_penulis'    => 'permit_empty|integer',
        'status'        => 'permit_empty|in_list[draft,published]',
    ];

    /**
     * Ambil data artikel beserta nama penulis
     */
    public function getArtikelWithAuthor($idOrSlug = null)
    {
        $builder = $this->select('artikel.*, users.nama as nama_penulis, users.role as role_penulis')
                        ->join('users', 'users.id = artikel.id_penulis', 'left');

        if ($idOrSlug !== null) {
            if (is_numeric($idOrSlug)) {
                return $builder->where('artikel.id', $idOrSlug)->first();
            }
            return $builder->where('artikel.slug', $idOrSlug)->first();
        }

        return $builder->orderBy('artikel.created_at', 'DESC')->findAll();
    }
}
