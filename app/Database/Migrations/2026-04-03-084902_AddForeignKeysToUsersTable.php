<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysToUsersTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Kosongkan id_kabkota yang tidak valid (tidak ada di tabel kabupaten_kota)
        $db->query("UPDATE users SET id_kabkota = NULL WHERE id_kabkota IS NOT NULL AND id_kabkota NOT IN (SELECT id FROM kabupaten_kota)");

        // Kosongkan id_puskesmas yang tidak valid (tidak ada di tabel puskesmas)
        $db->query("UPDATE users SET id_puskesmas = NULL WHERE id_puskesmas IS NOT NULL AND id_puskesmas NOT IN (SELECT id FROM puskesmas)");

        // Tambahkan foreign key constraints
        $db->query("ALTER TABLE users ADD CONSTRAINT fk_users_kabkota FOREIGN KEY (id_kabkota) REFERENCES kabupaten_kota(id) ON DELETE SET NULL ON UPDATE CASCADE");
        $db->query("ALTER TABLE users ADD CONSTRAINT fk_users_puskesmas FOREIGN KEY (id_puskesmas) REFERENCES puskesmas(id) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_kabkota');
        $db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_puskesmas');
    }
}
