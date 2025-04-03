<?php

namespace App\Exports;

use App\Models\Dormitory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DormitoriesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Dormitory::with('owner')->get()->map(function ($dorm) {
            return [
                'Dorm Name' => $dorm->name,
                'Owner' => $dorm->owner->name ?? 'N/A',
                'Contact Number' => $dorm->contact_number,
                'Email' => $dorm->email,
                'Dorm Location' => $dorm->location,
                "Owner's Address" => $dorm->owner_address,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Dorm Name',
            'Owner',
            'Contact Number',
            'Email',
            'Dorm Location',
            "Owner's Address",
        ];
    }
}
