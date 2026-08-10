<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // Add index on user_id + tgl_pengisian for fast query lookup
        $this->db->query("ALTER TABLE kondisi_kejiwaan_ibu ADD INDEX idx_user_tgl (user_id, tgl_pengisian);");
        $this->db->query("ALTER TABLE cek_kelancaran_asi ADD INDEX idx_user_asi_tgl (user_id, tgl_pengisian);");
        $this->db->query("ALTER TABLE data_bayi ADD INDEX idx_user_bayi_tgl (user_id, tgl_pengisian);");
        $this->db->query("ALTER TABLE riwayat_kehamilan ADD INDEX idx_user_hamil_tgl (user_id, tgl_pengisian);");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE kondisi_kejiwaan_ibu DROP INDEX idx_user_tgl;");
        $this->db->query("ALTER TABLE cek_kelancaran_asi DROP INDEX idx_user_asi_tgl;");
        $this->db->query("ALTER TABLE data_bayi DROP INDEX idx_user_bayi_tgl;");
        $this->db->query("ALTER TABLE riwayat_kehamilan DROP INDEX idx_user_hamil_tgl;");
    }
}
