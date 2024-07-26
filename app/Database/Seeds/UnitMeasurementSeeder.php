<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitMeasurementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'measurement_id' => 1,
                'description' => 'L', 
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'measurement_id' => 2,
                'description' => 'ML', 
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($data as $value) {
            $this->db->table('unit_measurement')->insert($value);
        }
    }
}
