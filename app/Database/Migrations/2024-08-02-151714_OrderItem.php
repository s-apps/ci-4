<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrderItem extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type'      => 'INT',
                'constraint' => 14,
            ],
            'product_id' => [
                'type'      => 'INT',
                'constraint' => 11,
            ],
            'package_id' => [
                'type'      => 'INT',
                'constraint' => 11,
            ],
            'amount' => [
                'type'          => 'INT',
                'constraint'    => 11
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint'    => 100
            ],
            'unitary_value' => [
                'type'           => 'DECIMAL',
                'constraint'     => '9,2',
                'null' => false,
                'default' => 0.00
            ],
            'cost_value' => [
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
        $this->forge->addKey('item_id', true);
        $this->forge->createTable('order_item'); 
    }

    public function down()
    {
        $this->forge->dropTable('order_item');
    }
}
