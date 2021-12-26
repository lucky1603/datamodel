<?php

namespace App\Exports;

use App\Business\Profile;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfileExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        return Profile::find()->map(function($profile) {
           return $profile->getData();
        });
    }

    public function headings(): array
    {
        $attributes = Profile::getAttributesDefinition();
        $labels = [];
        $filter = ['name', 'is_company', 'id_number', 'contact_person', 'contact_phone', 'contact_email'];
        foreach($attributes as $attribute) {
            if(in_array($attribute->name, $filter)) {
                $labels[] = $attribute->label;
            }

        }

        return $labels;
    }

    public function styles(Worksheet $sheet): array
    {
        // TODO: Implement styles() method.
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14
                ]
            ]
        ];
    }

    public function map($row): array
    {
        return [
            $row['name'],
            $row['is_company'],
            $row['id_number'],
            $row['contact_person'],
            $row['contact_email'],
            $row['contact_phone'],
        ];
    }
}
