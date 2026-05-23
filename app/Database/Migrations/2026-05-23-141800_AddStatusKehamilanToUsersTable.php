<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusKehamilanToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'status_kehamilan' => [
                'type'       => 'ENUM',
                'constraint' => ['pra_kehamilan', 'hamil', 'pasca_melahirkan'],
                'null'       => true,
                'default'    => null,
                'after'      => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'status_kehamilan');
    }
}
