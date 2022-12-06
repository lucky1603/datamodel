<?php

namespace App\Exports;

use App\Business\Profile;
use Illuminate\Support\Facades\Session;
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
        $filterData = [];
        $profileState = Session::get('profile_state');
        if($profileState != null && $profileState != 0) {
            $filterData['profile_status'] = $profileState;
        }

        $is_company = Session::get('is_company');
        if(isset($is_company) && $is_company != -1) {
            $filterData['is_company'] = $is_company == 1;
        }

        $ntp = Session::get('ntp');
        if(isset($ntp) && $ntp != 0) {
            $filterData['ntp'] = $ntp;
        }

        return Profile::find(count($filterData) > 0 ? $filterData : null)->map(function($profile) {
           $filter = ['name', 'is_company', 'id_number', 'contact_person', 'contact_phone', 'contact_email','profile_status'];
           $attributes = $profile->getAttributes();
           $retData = [];
           foreach($filter as $filterItem) {
                $attribute = $attributes->where('name', $filterItem)->first();
                $retData[$attribute->name] = $attribute->getText();
           }
           return $retData;
        });
    }

    public function headings(): array
    {
        $attributes = Profile::getAttributesDefinition();
        $labels = [];
        $filter = ['name', 'is_company', 'id_number', 'contact_person', 'contact_phone', 'contact_email','profile_status'];
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
            $row['profile_status']
        ];
    }
}
