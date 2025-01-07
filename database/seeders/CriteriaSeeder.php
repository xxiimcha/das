<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'criteria_name' => '1.1 Receiving Room',
                'values' => json_encode([
                    'Limited space / No receiving room available',
                    'Small receiving room is available',
                    'Adequate space for receiving room',
                    'Receiving room with sala set and reading materials'
                ])
            ]
        ];

        Criteria::insert($rows);
    }
}
