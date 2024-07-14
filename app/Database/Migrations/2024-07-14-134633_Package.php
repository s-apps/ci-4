<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Package extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'package_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'unit_measurement_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'capacity'      => [
                'type'      => 'INT',
                'constraint' => 11
            ],
            'description'   => [
                'type' => 'VARCHAR',
                'constraint' => '60'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('package_id', true);
        $this->forge->addForeignKey('unit_measurement_id', 'unit_measurement', 'measurement_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('package');
    }

    public function down()
    {
        $this->forge->dropTable('package');
    }
}
