<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'unit_measurement_id' => 1,
                'capacity' => 5,
                'description' => 'GALÃO',
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'unit_measurement_id' => 1,
                'capacity' => 2,
                'description' => 'GARRAFA PET',
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'unit_measurement_id' => 1,
                'capacity' => 1,
                'description' => 'FRASCO',
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'unit_measurement_id' => 2,
                'capacity' => 1,
                'description' => 'FRASCO',
                'created_at'  => date('Y-m-d H:i:s')
            ],

        ];
        
        foreach ($data as $value) {
            $this->db->table('package')->insert($value);
        }
    }
}
