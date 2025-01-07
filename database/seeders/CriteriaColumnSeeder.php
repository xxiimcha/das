<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CriteriaColumn;

class CriteriaColumnSeeder extends Seeder
{
    public function run()
    {
        $columns = [
            ['name' => 'Completely Acceptable (4)'],
            ['name' => 'Acceptable (3)'],
            ['name' => 'Slightly Acceptable (2)'],
            ['name' => 'Unacceptable (1)']
        ];

        CriteriaColumn::insert($columns);
    }
}
