<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class RSDStatisticsSheet implements FromCollection,WithTitle
{
    private $title;
    private $myCollection;

    public function __construct($title, $collection)
    {
        $this->title = $title;
        $this->myCollection = $collection;
    }

    public function collection() {
        return $this->myCollection;
    }

    public function title() : String
    {
        return $this->title;
    }
}
