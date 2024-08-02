<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Order extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'customer_id' => [
                'type'      => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'number' => [
                'type'       => 'VARCHAR',
                'constraint' => '14'
            ],
            'request_date' => [
                'type'       => 'DATE',
                'null' => true
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
        $this->forge->addKey('order_id', true);
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order'); 
    }

    public function down()
    {
        $this->forge->dropTable('order');
    }
}
