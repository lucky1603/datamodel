<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Business\Program;
use App\Business\Training;
use App\ProfileCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function raisingStartsDashboard() {
        return view('rstarts-dashboard');
    }

    /**
     * Raspodela programa po NTP.
     * @return array
     */
    public function ntp($program_type = 0): array
    {
        $query = DB::table('program_caches')
            ->selectRaw("ntp_text as ntp, COUNT(ntp) as count")
            ->groupBy(["ntp", "ntp_text"]);
        if($program_type != 0) {
            $query = $query->where('program_type', $program_type);
        }

        return $query->get()->toArray();

    }

    /**
     * Raspodela po tipovima startapa.
     * @return array
     */
    public function startupTypes(Request $request): array
    {
        $program_type = 0;
        if($request->post('program_type') !== null) {
            $program_type = $request->post('program_type');
        }

        $query = DB::table("program_caches")
            ->selectRaw("profile_type, COUNT(profile_type) as count")
            ->groupBy(["profile_type"]);

        if($program_type != 0) {
            $query = $query->where('program_type', $program_type);
        }

        $appliedGroups = $query->get();

        $startapi = $appliedGroups[0]->count;
        $kompanije = $appliedGroups[1]->count;

        return [
            'startupCount' => $startapi,
            'companyCount' => $kompanije,
            'total' => ($startapi + $kompanije)
        ];

    }

    /**
     * Raspodela po načinu kako su korisnici čuli za platformu.
     * @return array
     */
    public function howDidUHear(): array
    {
        $attr = Attribute::where('name', 'rstarts_howdiduhear')->first();
        $attrOptions = $attr->getOptions();

        $items = [];
        $total = 0;

        foreach($attrOptions as $key=>$value) {
            $count = Program::find(['rstarts_howdiduhear' => $key])->count();
            $name = $value;
            $items[] = [
                'text' => $name,
                'count' => $count
            ];

            $total += $count;
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function splitBusinessBranch() {

    }

    public function programStatuses($programType): array
    {
        $query = DB::table('program_caches')
            ->selectRaw('program_status as id, program_status_text as name, COUNT(program_status) as count')
            ->groupBy(['program_status', 'program_status_text']);

        if($programType != 0) {
            $query = $query->where('program_type', $programType);
        }

        $programStatuses = $query->get();

        $applied = 0;
        $sent = 0;
        $inProgram = 0;
        $outOfProgram = 0;
        $total = 0;
        foreach($programStatuses as $programStatus) {
            $total += $programStatus->count;
            if($programStatus->id == 1) {
                $applied = $programStatus->count;
            }

            if($programStatus->id == -1) {
                $inProgram = $programStatus->count;
            }

            if($programStatus->id < -1) {
                $outOfProgram = $programStatus->count;
            }
        }

        return [
            'applied' => $applied,
            'sent' => $total - $applied,
            'inProgram' => $inProgram,
            'outOfProgram' => $outOfProgram,
            'total' => $total
        ];

    }

    public function splitInterest() {
        $result = $this->howDidUHear();
        return $result['items'];
    }

    public function splitOptions($attributeName): array
    {
        $selectString = $attributeName.'_text as text, COUNT('. $attributeName.") as count";

        $rows = DB::table('raising_starts_caches')
            ->selectRaw($selectString)
            ->groupBy([$attributeName, $attributeName.'_text'])
            ->get();

        $items = [];
        $total = 0;
        foreach($rows as $row) {
            $items[] = [
                'text' => $row->text,
                'count' => $row->count,
            ];
            $total += $row->count;
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function getWorkshopAndSessionStats(Request $request): array
    {
        $program_type = 0;
        if($request->post('program_type') !== null) {
            $program_type = $request->post('program_type');
        }

        $query = DB::table('program_caches')->selectRaw("SUM(session_count) as sessions, SUM(workshop_count) as workshops");
        if($program_type != 0) {
            $query = $query->where('program_type', $program_type);
        }

        $counts = $query->get()->first();


        $workshops = Training::find()->filter(function($training) use($program_type){
            return $training->getValue('program_type') == $program_type && $training->getValue('training_type') == 1;
        })->count();

        return [
            'workshops' => $workshops,
            'sessions' => $counts->sessions
        ];
    }

    public function getCountries() {
        return DB::table('countries')->select()->get()->map(function($country) {
            return [
                'id' => $country->id,
                'name' => $country->country
            ];
        });
    }

    public function getCountryNames(Request $request) {
        $countryIds = $request->post('ids');
        $countryNames = [];
        if($countryIds != null) {
            $countries = DB::table('countries')->whereIn('id', $countryIds)->get();
            foreach($countries as $country) {
                $countryNames[] = $country->country;
            }
        }

        return $countryNames;
    }

    public function getProfileStatisticsSummary(): array
    {
        $resultData = [
            'virtuelni' => 0,
            'punopravni' => 0,
            'prihod' => 0.0,
            'porez' => 0.0,
            'investicije' => 0.0,
            'izvoz' => 0.0,
            'zaposleni' => 0,
            'angazovani' => 0,
            'zene' => 0,
            'po_tehnologiji' => [],
            'po_stepenu_razvoja' => [],
            'count' => 0
        ];

        $options = Attribute::where('name', 'business_branch')->first()->getOptions();
        foreach($options as $key=>$value) {
            $resultData['po_tehnologiji'][$key] = [
                'text' => $value,
                'count' => 0
            ];
        }

        $options = Attribute::where('name', 'faza_razvoja')->first()->getOptions();
        foreach($options as $key=>$value) {
            $resultData['po_stepenu_razvoja'][$key] = [
                'text' => $value,
                'count' => 0
            ];
        }

        $pcaches = ProfileCache::all();
        foreach($pcaches as $pcache) {
            if($pcache->memberhip_type == 1)
                $resultData['punopravni'] ++;
            else if($pcache->memberhip_type == 2) {
                $resultData['virtuelni'] ++;
            }

            $resultData['prihod'] += $pcache->iznos_prihoda;
            $resultData['izvoz'] += $pcache->iznos_izvoza;
            $resultData['investicije'] += $pcache->iznos_ulaganja_istrazivanje_razvoj;
            $resultData['porez'] += $pcache->iznos_placenih_poreza;
            $resultData['zaposleni'] += $pcache->broj_zaposlenih;
            $resultData['angazovani'] += $pcache->broj_angazovanih;
            $resultData['zene'] += $pcache->broj_angazovanih_zena;

            $resultData['po_stepenu_razvoja'][$pcache->faza_razvoja]['count']++;
            $resultData['po_tehnologiji'][$pcache->business_branch]['count']++;
            $resultData['count']++;
        }

        return $resultData;
    }


}
