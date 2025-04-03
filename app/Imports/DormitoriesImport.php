<?php

namespace App\Imports;

use App\Models\Dormitory;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DormitoriesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row
        $rows->shift();

        foreach ($rows as $row) {
            $owner = User::firstOrCreate(
                ['email' => $row[3]],
                ['name' => $row[1], 'contact_number' => $row[2], 'address' => $row[5], 'role' => 'owner', 'password' => bcrypt('default123')]
            );

            Dormitory::create([
                'user_id' => $owner->id,
                'name' => $row[0],
                'location' => $row[4],
                'price_range' => '0', // default
                'capacity' => 0, // default
                'status' => 'pending',
            ]);
        }
    }
}
