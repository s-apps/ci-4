<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'description' => 'GALÃO', 
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'GARRAFA PET', 
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($data as $value) {
            $this->db->table('package_type')->insert($value);
        }

    }
}
