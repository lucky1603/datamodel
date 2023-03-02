<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpParser\Node\Expr\Cast\String_;

class RSDashboardExport implements WithMultipleSheets, WithTitle
{
    private $name;
    private $exportData;

    public function __construct($name, $exportData)
    {
        $this->name = $name;
        $this->exportData = $exportData;
    }

    public function sheets() : array
    {
        $sheets = [];

        // Prvi list.
        $prvaKolekcija = collect([]);

        // Tipovi klijenata.
        $startupTypes = $this->exportData['startupTypes'];
        $prvaKolekcija->add(["Tipovi klijenata"]);
        $prvaKolekcija->add([""]);
        foreach($startupTypes as $key=>$value) {
            $prvaKolekcija->add([__($key), $value]);
        }

        // Prazan red.
        $prvaKolekcija->add([""]);
        $prvaKolekcija->add([""]);

        // Statusi programa.
        $programStatuses = $this->exportData['programStatuses'];
        $prvaKolekcija->add(["Statusi programa"]);
        $prvaKolekcija->add([""]);
        foreach($programStatuses as $key=>$value) {
            $prvaKolekcija->add([__($key), $value]);
        }

        // Prazan red.
        $prvaKolekcija->add([""]);
        $prvaKolekcija->add([""]);

        // Statistika o radionicama i sesijama.
        $workshopsAndSessionStats = $this->exportData['workshopsAndSessionStats'];
        $prvaKolekcija->add(["Statistika o radionicama i sesijama"]);
        $prvaKolekcija->add([""]);
        foreach($workshopsAndSessionStats as $key=>$value) {
            $prvaKolekcija->add([__($key), $value]);
        }

        $sheets[] = new RSDStatisticsSheet("Opsti podaci", $prvaKolekcija);

        $prvaKolekcija->add([""]);
        $prvaKolekcija->add([""]);


        // Drugi list.
        $drugaKolekcija = collect([]);
        $ntps = $this->exportData['ntp'];
        foreach($ntps as $ntp) {
            $drugaKolekcija->add([$ntp->ntp, $ntp->count]);
        }

        $sheets[] = new RSDStatisticsSheet("Raspodela po NTP", $drugaKolekcija);


        // Treci list
        $trecaKolekcija = collect([]);
        $opstine = $this->exportData['prijavePoOpstinama'];
        foreach($opstine as $opstina) {
            $trecaKolekcija->add([$opstina->opstina, $opstina->count]);
        }

        $sheets[] = new RSDStatisticsSheet("Prijave po opštinama", $trecaKolekcija);

        // Četvrti list
        $cetvrtaKolekcija = collect([]);
        $gradovi = $this->exportData['prijavePoGradovima'];
        foreach($gradovi as $grad) {
            $cetvrtaKolekcija->add([$grad->ntp, $grad->count]);
        }

        $sheets[] = new RSDStatisticsSheet("Prijave po gradovima", $cetvrtaKolekcija);

        // Ostali listovi

        $parametri = [
            [
                'name' => 'how_innovative',
                'label' => __('gui.rs_dashboard_innovation_text'),
            ],
            [
                'name' => 'dev_phase_tech',
                'label' => __('gui.rs_dashboard_tech_progress_phase_text'),
            ],
            [
                'name' => 'dev_phase_business',
                'label' => __('gui.rs_dashboard_bus_progress_phase_text'),
            ],
            [
                'name' => 'howdiduhear',
                'label' => __('gui.rs_dashboard_way_of_finding_out_text'),
            ],
            [
                'name' => 'intellectual_property',
                'label' => __('gui.rs_dashboard_intellectual_property_text'),
            ],
            [
                'name' => 'innovative_area',
                'label' =>  __('gui.rs_dashboard_field_of_product_service_text'),
            ],
            [
                'name' => 'product_type',
                'label' => __('gui.rs_dashboard_type_of_product_service_text'),
            ],


        ];


        foreach($parametri as $parametar) {
            $kolekcija = collect([]);
            $stavke = $this->exportData[$parametar['name']]['items'];

            foreach($stavke as $stavka) {
                $kolekcija->add([$stavka['text'], $stavka['count']]);
            }

            $sheets[] = new RSDStatisticsSheet($parametar['label'], $kolekcija);
        }

        return $sheets;
    }

    public function title() : String
    {
        return $this->name." - ".$this->exportData['year'];
    }
}
