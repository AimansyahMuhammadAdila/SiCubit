<?php

namespace App\Models;

use CodeIgniter\Model;

class AsiModel extends Model
{
    protected $table            = 'cek_kelancaran_asi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'id_ibu',
        'tgl_pengisian',
        'kondisi_puting',
        'frekuensi_menyusui',
        'lama_menyusui',
        'frekuensi_bab_bayi',
        'frekuensi_bak_bayi',
        'support_suami_menyusui',
        'support_suami_gizi',
        'bayi_tidur_12jam',
        'bayi_tenang_setelah_menyusu',
        'warna_urin_bayi',
        'payudara_penuh',
        'volume_pumping',
        'status_kecukupan_asi',
    ];

    protected $validationRules = [
        'id_ibu'              => 'required|integer',
        'tgl_pengisian'       => 'required|valid_date',
        'kondisi_puting'      => 'permit_empty|in_list[Normal,Lecet,Datar,Tenggelam]',
        'frekuensi_menyusui'  => 'required|integer|greater_than_equal_to[0]',
        'lama_menyusui'       => 'required|integer|greater_than_equal_to[0]',
        'frekuensi_bab_bayi'  => 'required|integer|greater_than_equal_to[0]',
        'frekuensi_bak_bayi'  => 'required|integer|greater_than_equal_to[0]',
        'support_suami_menyusui'      => 'permit_empty|in_list[Ya,Tidak]',
        'support_suami_gizi'          => 'permit_empty|in_list[Ya,Tidak]',
        'bayi_tidur_12jam'            => 'permit_empty|in_list[Ya,Tidak]',
        'bayi_tenang_setelah_menyusu' => 'permit_empty|in_list[Ya,Tidak]',
        'warna_urin_bayi'             => 'permit_empty|in_list[Jernih,Kuning Muda,Kuning Pekat]',
        'payudara_penuh'              => 'permit_empty|in_list[Ya,Tidak]',
        'volume_pumping'              => 'permit_empty|decimal',
        'status_kecukupan_asi'        => 'required|in_list[Ya,Tidak]',
    ];

    // ---------------------------------------------------------------
    // Service Logic — Hitung Kecukupan ASI
    // ---------------------------------------------------------------

    /**
     * Menghitung status kecukupan ASI berdasarkan indikator klinis.
     *
     * Sistem penilaian berbasis skor:
     *   - Frekuensi menyusui >= 8x/hari          → +2
     *   - Lama menyusui >= 10 menit/sesi          → +2
     *   - Frekuensi BAB bayi >= 3x/hari           → +1
     *   - Frekuensi BAK bayi >= 6x/hari           → +2
     *   - Bayi tenang setelah menyusu = Ya         → +1
     *   - Bayi tidur >= 12 jam/hari = Ya           → +1
     *   - Warna urin bayi jernih/kuning muda       → +1
     *   - Payudara penuh sebelum menyusui = Ya     → +1
     *   - Kondisi puting normal                    → +1
     *
     * Skor maksimal = 12. Kecukupan ASI = "Ya" jika skor >= 7.
     *
     * @param array $data Data input dari form cek ASI
     * @return string "Ya" atau "Tidak"
     */
    public function hitungKecukupanAsi(array $data): string
    {
        $skor = 0;

        // 1. Frekuensi menyusui (minimal 8x/hari sesuai standar WHO)
        if (isset($data['frekuensi_menyusui']) && (int) $data['frekuensi_menyusui'] >= 8) {
            $skor += 2;
        }

        // 2. Lama/durasi menyusui (minimal 10 menit per sesi)
        if (isset($data['lama_menyusui']) && (int) $data['lama_menyusui'] >= 10) {
            $skor += 2;
        }

        // 3. Frekuensi BAB bayi (minimal 3x/hari)
        if (isset($data['frekuensi_bab_bayi']) && (int) $data['frekuensi_bab_bayi'] >= 3) {
            $skor += 1;
        }

        // 4. Frekuensi BAK bayi (minimal 6x/hari → indikator hidrasi cukup)
        if (isset($data['frekuensi_bak_bayi']) && (int) $data['frekuensi_bak_bayi'] >= 6) {
            $skor += 2;
        }

        // 5. Bayi tenang setelah menyusu
        if (isset($data['bayi_tenang_setelah_menyusu']) && $data['bayi_tenang_setelah_menyusu'] === 'Ya') {
            $skor += 1;
        }

        // 6. Bayi tidur minimal 12 jam/hari
        if (isset($data['bayi_tidur_12jam']) && $data['bayi_tidur_12jam'] === 'Ya') {
            $skor += 1;
        }

        // 7. Warna urin bayi (jernih atau kuning muda = baik)
        if (isset($data['warna_urin_bayi']) && in_array($data['warna_urin_bayi'], ['Jernih', 'Kuning Muda'])) {
            $skor += 1;
        }

        // 8. Payudara terasa penuh sebelum menyusui
        if (isset($data['payudara_penuh']) && $data['payudara_penuh'] === 'Ya') {
            $skor += 1;
        }

        // 9. Kondisi puting normal (tidak ada masalah)
        if (isset($data['kondisi_puting']) && $data['kondisi_puting'] === 'Normal') {
            $skor += 1;
        }

        // Threshold: skor >= 7 dari 12 → ASI cukup
        return $skor >= 7 ? 'Ya' : 'Tidak';
    }

    /**
     * Ambil semua riwayat cek ASI berdasarkan ID ibu.
     */
    public function getByIbu(int $idIbu): array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil cek ASI terakhir.
     */
    public function getLatestByIbu(int $idIbu): ?array
    {
        return $this->where('id_ibu', $idIbu)
                    ->orderBy('tgl_pengisian', 'DESC')
                    ->first();
    }
}
