<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UnitMeasurement extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'measurement_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ]
        ]);
        $this->forge->addKey('measurement_id', true);
        $this->forge->createTable('unit_measurement');
    }

    public function down()
    {
        $this->forge->dropTable('unit_measurement');
    }
}
