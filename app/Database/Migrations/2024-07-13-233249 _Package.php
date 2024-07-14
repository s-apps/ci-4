<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Package extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'package_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true
            ],
            'package_type_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
            ],
            'capacity'      => [
                'type'      => 'INT',
                'constraint' => 11
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
        $this->forge->addKey('package_id', true);
        $this->forge->addForeignKey('package_type_id', 'package_type', 'packahe_type_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('package');
    }

    public function down()
    {
        $this->forge->dropTable('package');
    }
}
