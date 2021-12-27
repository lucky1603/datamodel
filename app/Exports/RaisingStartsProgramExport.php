<?php

namespace App\Exports;

use App\Business\Program;
use App\Business\RaisingStartsProgram;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RaisingStartsProgramExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        return Program::find(['program_type' => Program::$RAISING_STARTS])->map(function($program) {
            return $program->getAttributeTexts();
        });
    }


    public function headings(): array
    {
        // TODO: Implement headings() method.
        $attributes = RaisingStartsProgram::getAttributesDefinition();
        $labels = [];
        foreach($attributes->first() as $attribute) {
            $labels[] = $attribute->label;
        }

        return $labels;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14
                ]
            ]
        ];
    }
}
