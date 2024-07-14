<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitMeasurementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'description' => 'LT', 
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'ML', 
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];
        foreach ($data as $value) {
            $this->db->table('unit_measurement')->insert($value);
        }
    }
}
