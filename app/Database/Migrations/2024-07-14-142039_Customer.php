<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Customer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '60'
            ],
            'nickname' => [
                'type'           => 'VARCHAR',
                'constraint'     => '45',
                'null' => true
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['sale', 'resale'],
                'default'    => 'resale',
            ],
            'address' => [
                'type'           => 'VARCHAR',
                'constraint'     => '80',
                'null' => true
            ],
            'address_number'     => [
                'type'           => 'VARCHAR',
                'constraint'     => '8',
                'null' => true
            ],
            'address_complement' => [
                'type'           => 'VARCHAR',
                'constraint'     => '60',
                'null' => true
            ],
            'city'               => [
                'type'           => 'VARCHAR',
                'constraint'     => '60',
                'null' => true   
            ],
            'state'              => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
                'null' => true
            ],
            'zip_code'           => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null' => true
            ],
            'phone'              => [
                'type'           => 'VARCHAR',
                'constraint'     => '13',
                'null' => true
            ],
            'cell_phone'         => [
                'type'           => 'VARCHAR',
                'constraint'     => '14',
                'null' => true
            ],
            'email'              => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
                'null' => true   
            ],
            'comments'           => [
                'type'           => 'TEXT',
                'constraint'     => '250',
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
        $this->forge->addKey('customer_id', true);
        $this->forge->createTable('customer');
    }

    public function down()
    {
        $this->forge->dropTable('customer');
    }
}
