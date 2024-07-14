<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PackageType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'package_type_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
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
        $this->forge->addKey('package_type_id', true);
        $this->forge->createTable('package_type');        
    }

    public function down()
    {
        $this->forge->dropTable('package_type');
    }
}
