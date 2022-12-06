<?php

namespace App\Exports;

use App\Business\IncubationProgram;
use App\Business\Program;
use App\Business\RaisingStartsProgram;
use App\Business\RastuceProgram;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RaisingStartsProgramExport implements FromCollection, WithHeadings, WithStyles
{

    private $programs;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {

        if($this->programs == null) {
            $this->programs = $this->getPrograms();
        }

        $attributeTexts = $this->programs->map(function($program) {
            return $program->getAttributeTexts();
        });

        return $attributeTexts;
    }


    public function headings(): array
    {
        if($this->programs == null) {
            $this->programs = $this->getPrograms();
        }

        // TODO: Implement headings() method.
        $labels = [];
        if($this->programs->count() != 0) {
            $attributes = $this->programs->first()->getAttributes();
            foreach($attributes as $attribute) {
                $labels[] = $attribute->label;
            }
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

    private function getPrograms() {
        $programType = Session::get("program_type", Program::$RAISING_STARTS);
        $programStatus = Session::get("program_status", 0);

        $filterData = [
            'program_type' => $programType,
        ];

        if($programStatus != 0) {
            $filterData['program_status'] = $programStatus;
        }

        $programs = Program::find( $filterData );

        $year = Session::get('year');
        if(isset($year) && $year != 0) {

            $programs = $programs->filter(function($program) use($year) {
                return $program->getYear() == $year;
            });
        }

        return $programs;
    }
}

