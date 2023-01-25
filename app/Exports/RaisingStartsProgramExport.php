<?php

namespace App\Exports;

use App\Business\Program;
use App\Business\ProgramFactory;
use App\Business\RastuceProgram;
use Illuminate\Support\Facades\DB;
use App\Business\IncubationProgram;
use App\Business\RaisingStartsProgram;
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
            $this->programs = $this->getPrograms1();
        }

        $attributeTexts = $this->programs->map(function($program) {
            return $program->getAttributeTexts();
        });

        return $attributeTexts;
    }


    public function headings(): array
    {
        if($this->programs == null) {
            $this->programs = $this->getPrograms1();
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

    private function getPrograms1() {
        $programType = Session::get("program_type", Program::$RAISING_STARTS);
        $programStatus = Session::get("program_status", 0);
        $year = Session::get("year");
        $profileName = Session::get("program_name");

        $filterData = [
            'program_type' => $programType,
        ];

        if($programStatus != 0) {
            $filterData['program_status'] = $programStatus;
        }

        if(isset($year)) {
            $filterData['year'] = $year;
        }

        $programRowsQuery = DB::table('program_caches');

        foreach($filterData as $key=>$value) {
            $programRowsQuery = $programRowsQuery->where($key, $value);
        }

        if(isset($profileName) && $profileName != '') {
            $programRowsQuery = $programRowsQuery->whereRaw('profile_name LIKE "'.$profileName.'%"');
        }

        $programRows = $programRowsQuery->get();

        return $programRows->map(function($programRow) {
            return ProgramFactory::resolve($programRow->program_id);
        });

    }
}

