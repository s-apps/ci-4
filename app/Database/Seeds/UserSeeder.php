<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->query('TRUNCATE TABLE users');
        $this->db->query('TRUNCATE TABLE auth_identities');
        
        $users = [
            [
                'id' => 1,
                'username' => 'edgar',
                'active' => 1
            ],
            [
                'id' => 2,
                'username' => 'debora',
                'active' => 1
            ]
        ];

        foreach ($users as $value) {
            $this->db->table('users')->insert($value);
        }

        $auth_identities = [
            [
                'user_id' => 1,
                'type' => 'email_password',
                'secret' => 'edgar@edgar.com',
                'secret2' => '$2y$12$SW8K8Rd.Y4WoPrclNtSameiqsKbrFA1/IaFyEY1UDo9l9Cfj/NwtS',
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'type' => 'email_password',
                'secret' => 'debora@debora.com',
                'secret2' => '$2y$12$SW8K8Rd.Y4WoPrclNtSameiqsKbrFA1/IaFyEY1UDo9l9Cfj/NwtS',
                'created_at'  => date('Y-m-d H:i:s')
            ],
        ];
        
        foreach ($auth_identities as $value) {
            $this->db->table('auth_identities')->insert($value);
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
