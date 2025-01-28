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
            ],
            [
                'criteria_name' => '1.2 Kitchen',
                'values' => json_encode([
                    'No kitchen available',
                    'Kitchen with minimal equipment',
                    'Well-equipped kitchen',
                    'Fully equipped kitchen with dining area'
                ])
            ],
            [
                'criteria_name' => '1.3 Bathroom',
                'values' => json_encode([
                    'No bathroom available',
                    'Shared bathroom with limited facilities',
                    'Private bathroom with basic amenities',
                    'Bathroom with complete amenities and good ventilation'
                ])
            ],
            [
                'criteria_name' => '1.4 Bedroom',
                'values' => json_encode([
                    'Overcrowded bedroom / No bedroom available',
                    'Small bedroom with limited furniture',
                    'Adequate bedroom with basic furniture',
                    'Spacious bedroom with complete furniture'
                ])
            ],
            [
                'criteria_name' => '1.5 Safety Measures',
                'values' => json_encode([
                    'No safety measures in place',
                    'Basic safety measures like fire extinguisher',
                    'Safety measures with emergency exit plan',
                    'Comprehensive safety measures with CCTVs and alarms'
                ])
            ],
            [
                'criteria_name' => '1.6 Accessibility',
                'values' => json_encode([
                    'Not accessible for PWD',
                    'Limited accessibility for PWD',
                    'Accessible for PWD with some limitations',
                    'Fully accessible for PWD with ramps and elevators'
                ])
            ]
        ];

        Criteria::insert($rows);
    }
}
