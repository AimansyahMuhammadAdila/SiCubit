<?php

namespace App\Models;

use CodeIgniter\Model;

class KondisiKejiwaanIbuModel extends Model
{
    protected $table            = 'kondisi_kejiwaan_ibu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'tgl_pengisian',
        'khawatir_berlebihan',
        'gelisah',
        'gemetar',
        'tidak_dapat_rileks',
        'ketegangan_otot',
        'sakit_kepala',
        'jantung_berdebar',
        'berkeringat_berlebihan',
        'sesak_napas',
        'kepala_terasa_ringan',
        'keluhan_ulu_hati',
        'lelah_sulit_tidur',
        'mudah_tersinggung',
        'perubahan_hubungan_suami',
        'skor_kejiwaan',
        'status_kejiwaan',
        'epds_q1',
        'epds_q2',
        'epds_q3',
        'epds_q4',
        'epds_q5',
        'epds_q6',
        'epds_q7',
        'epds_q8',
        'epds_q9',
        'epds_q10',
        'epds_skor',
        'epds_status',
    ];

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        if (!$db->fieldExists('epds_skor', $this->table)) {
            $db->query("ALTER TABLE {$this->table} ADD COLUMN epds_q1 INT DEFAULT 0, ADD COLUMN epds_q2 INT DEFAULT 0, ADD COLUMN epds_q3 INT DEFAULT 0, ADD COLUMN epds_q4 INT DEFAULT 0, ADD COLUMN epds_q5 INT DEFAULT 0, ADD COLUMN epds_q6 INT DEFAULT 0, ADD COLUMN epds_q7 INT DEFAULT 0, ADD COLUMN epds_q8 INT DEFAULT 0, ADD COLUMN epds_q9 INT DEFAULT 0, ADD COLUMN epds_q10 INT DEFAULT 0, ADD COLUMN epds_skor INT DEFAULT 0, ADD COLUMN epds_status VARCHAR(100) DEFAULT NULL");
        }
    }

    protected $validationRules = [
        'user_id'                  => 'required|integer',
        'tgl_pengisian'            => 'required|valid_date',
        'khawatir_berlebihan'      => 'permit_empty|in_list[Ya,Tidak]',
        'gelisah'                  => 'permit_empty|in_list[Ya,Tidak]',
        'gemetar'                  => 'permit_empty|in_list[Ya,Tidak]',
        'tidak_dapat_rileks'       => 'permit_empty|in_list[Ya,Tidak]',
        'ketegangan_otot'          => 'permit_empty|in_list[Ya,Tidak]',
        'sakit_kepala'             => 'permit_empty|in_list[Ya,Tidak]',
        'jantung_berdebar'         => 'permit_empty|in_list[Ya,Tidak]',
        'berkeringat_berlebihan'   => 'permit_empty|in_list[Ya,Tidak]',
        'sesak_napas'              => 'permit_empty|in_list[Ya,Tidak]',
        'kepala_terasa_ringan'     => 'permit_empty|in_list[Ya,Tidak]',
        'keluhan_ulu_hati'         => 'permit_empty|in_list[Ya,Tidak]',
        'lelah_sulit_tidur'        => 'permit_empty|in_list[Ya,Tidak]',
        'mudah_tersinggung'        => 'permit_empty|in_list[Ya,Tidak]',
        'perubahan_hubungan_suami' => 'permit_empty|in_list[Ya,Tidak]',
        'epds_q1'                  => 'permit_empty|integer',
        'epds_q2'                  => 'permit_empty|integer',
        'epds_q3'                  => 'permit_empty|integer',
        'epds_q4'                  => 'permit_empty|integer',
        'epds_q5'                  => 'permit_empty|integer',
        'epds_q6'                  => 'permit_empty|integer',
        'epds_q7'                  => 'permit_empty|integer',
        'epds_q8'                  => 'permit_empty|integer',
        'epds_q9'                  => 'permit_empty|integer',
        'epds_q10'                 => 'permit_empty|integer',
    ];

    // ---------------------------------------------------------------
    // Daftar kolom pertanyaan untuk scoring
    // ---------------------------------------------------------------
    private array $pertanyaanFields = [
        'khawatir_berlebihan',
        'gelisah',
        'gemetar',
        'tidak_dapat_rileks',
        'ketegangan_otot',
        'sakit_kepala',
        'jantung_berdebar',
        'berkeringat_berlebihan',
        'sesak_napas',
        'kepala_terasa_ringan',
        'keluhan_ulu_hati',
        'lelah_sulit_tidur',
        'mudah_tersinggung',
        'perubahan_hubungan_suami',
    ];

    // ---------------------------------------------------------------
    // Service Logic — Hitung Skor Kondisi Kejiwaan
    // ---------------------------------------------------------------

    /**
     * Menghitung skor dan status EPDS.
     */
    public function hitungEpds(array $data): array
    {
        $skor = 0;
        for ($i = 1; $i <= 10; $i++) {
            $skor += (int)($data["epds_q$i"] ?? 0);
        }

        if ($skor <= 9) {
            $status = 'Normal / adaptasi emosional ringan';
        } elseif ($skor <= 12) {
            $status = 'Kemungkinan baby blues';
        } else {
            $status = 'Kemungkinan depresi postpartum';
        }

        $q10 = (int)($data['epds_q10'] ?? 0);
        $perhatianRujukan = ($skor >= 10 || $q10 > 0);

        return [
            'epds_skor'         => $skor,
            'epds_status'       => $status,
            'perhatian_rujukan' => $perhatianRujukan,
        ];
    }

    /**
     * Menghitung skor dan status kondisi kejiwaan ibu.
     *
     * Setiap jawaban "Ya" bernilai 1 poin.
     * Total pertanyaan = 14.
     *
     * Klasifikasi:
     *   - 0-4  → Normal
     *   - 5-9  → Perlu Perhatian
     *   - 10-14 → Berisiko
     *
     * @param array $data Data input dari form screening
     * @return array ['skor_kejiwaan' => int, 'status_kejiwaan' => string]
     */
    public function hitungKondisiKejiwaan(array $data): array
    {
        $skor = 0;

        foreach ($this->pertanyaanFields as $field) {
            if (isset($data[$field]) && $data[$field] === 'Ya') {
                $skor++;
            }
        }

        // Klasifikasi status
        if ($skor <= 4) {
            $status = 'Normal';
        } elseif ($skor <= 9) {
            $status = 'Perlu Perhatian';
        } else {
            $status = 'Berisiko';
        }

        return [
            'skor_kejiwaan'  => $skor,
            'status_kejiwaan' => $status,
        ];
    }

    /**
     * Ambil semua riwayat kondisi kejiwaan berdasarkan user.
     */
    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil data kejiwaan terakhir.
     */
    public function getLatestByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();
    }

    /**
     * Ambil data kondisi kejiwaan.
     * Jika $id false, ambil semua. Jika ada id, ambil satu.
     */
    public function getKondisiKejiwaan($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
