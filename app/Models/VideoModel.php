<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table            = 'video';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'judul',
        'video_url',
        'id_kategori',
        'deskripsi',
        'id_penulis',
        'status',
    ];

    protected $validationRules = [
        'judul'       => 'required|min_length[2]|max_length[255]',
        'video_url'   => 'required|max_length[255]',
        'id_kategori' => 'permit_empty|integer',
        'deskripsi'   => 'permit_empty',
        'id_penulis'  => 'required|integer',
        'status'      => 'permit_empty|in_list[draft,published]',
    ];

    /**
     * Ambil data video.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getVideo($id = false)
    {
        if ($id === false) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
