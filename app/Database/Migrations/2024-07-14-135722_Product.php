<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Product extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'package_id' => [
                'type'      => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
            ],
            'cost_value' => [
                'type'           => 'DECIMAL',
                'constraint'     => '9,2',
                'null' => false,
                'default' => 0.00
            ],
            'sale_value' => [
                'type'           => 'DECIMAL',
                'constraint'     => '9,2',
                'null' => false,
                'default' => 0.00
            ],
            'resale_value'     => [
                'type'           => 'DECIMAL',
                'constraint'     => '9,2',
                'null' => false,
                'default' => 0.00
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
        $this->forge->addKey('product_id', true);
        $this->forge->addUniqueKey(['package_id', 'description'], 'product_package_unique');
        $this->forge->addForeignKey('package_id', 'package', 'package_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product');        
    }

    public function down()
    {
        $this->forge->dropTable('product');
    }
}
