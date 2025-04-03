<?php

namespace App\Imports;

use App\Models\Dormitory;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DormitoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::firstOrCreate(
            ['name' => $row['owner']],
            [
                'email' => $row['email'],
                'password' => bcrypt('password'),
                'role' => 'owner',
            ]
        );

        return new Dormitory([
            'user_id' => $user->id,
            'name' => $row['dorm_name'],
            'contact_number' => $row['contact_number'],
            'email' => $row['email'],
            'location' => $row['dorm_location'],
            'owner_address' => $row["owner's_address"],
            'status' => 'pending',
        ]);
    }
}

