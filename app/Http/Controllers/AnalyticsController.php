<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\ProfileCache;
use App\Business\Program;
use App\Business\Training;
use App\Exports\RSDashboardExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
    public function ntp(Request $request): array
    {
        $program_type = $request->post('program_type');
        $year = $request->post('year');

        $query = DB::table('program_caches')
            ->selectRaw("ntp_text as ntp, COUNT(ntp) as count")
            ->groupBy(["ntp", "ntp_text"]);

        $queryData = [];
        if($program_type != 0) {
            $queryData['program_type'] = $program_type;
        }

        if($year != 0) {
            $queryData['year'] = $year;
        }

        if(count($queryData) > 0) {
            $query = $query->where($queryData);
        }

        $query = $query->whereNotIn('program_status', [0,1]);

        return $query->get()->toArray();
    }

    public function prijave_po_gradovima(Request $request) {
        $program_type = $request->post('program_type');
        $year = $request->post('year');

        $query = DB::table('program_caches')
            ->selectRaw("ntp_text as ntp, COUNT(ntp) as count")
            ->groupBy(["ntp", "ntp_text"]);

        $queryData = [];
        if($program_type != 0) {
            $queryData['program_type'] = $program_type;
        }

        if($year != 0) {
            $queryData['year'] = $year;
        }

        if(count($queryData) > 0) {
            $query = $query->where($queryData);
        }

        return $query->get()->toArray();
    }

    public function prijave_po_opstinama(Request $request) {
        $program_type = $request->post('program_type');
        $year = $request->post('year');

        $query = DB::table('program_caches')
            ->selectRaw("opstina_text as opstina, COUNT(opstina) as count")
            ->groupBy(["opstina", "opstina_text"]);

        $queryData = [];
        if($program_type != 0) {
            $queryData['program_type'] = $program_type;
        }

        if($year != 0) {
            $queryData['year'] = $year;
        }

        if(count($queryData) > 0) {
            $query = $query->where($queryData);
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

        $year = $request->post('year');

        $query = DB::table("program_caches")
            ->selectRaw("profile_type, COUNT(profile_type) as count")
            ->groupBy(["profile_type"]);

        $queryData = [];
        if($program_type != 0) {
            $queryData['program_type'] = $program_type;
        }

        if($year != 0) {
            $queryData['year'] = $year;
        }

        if(count($queryData) > 0) {
            $query = $query->where($queryData);
        }

        // Uzmi u obzir status programa
        //$query = $query->whereIn('program_status', [-1,-3,-4,1, 2,3,4,5,6,7,8,9]);

        $appliedGroups = $query->get();

        $startapi = count($appliedGroups) > 0 ? $appliedGroups[0]->count : 0;
        $kompanije = count($appliedGroups) > 0 ? $appliedGroups[1]->count : 0;

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

    public function howDidUHear1(Request $request) {
        $year = $request->post('year');

        $query = DB::table('raising_starts_caches')
            ->selectRaw('howdiduhear_text as text, count(howdiduhear) as count')
            ->groupBy(['howdiduhear_text'])
            ->where('year', $year);

        $rows = $query->get();
        $total = 0;
        foreach($rows as $row) {
            $total += $row->count;
        }

        return [
            "items" => $rows,
            "total" => $total,
        ];
    }

    public function splitBusinessBranch() {

    }

    public function programStatuses(Request $request): array
    {
        $programType = $request->post('program_type');
        $year = $request->post('year');

        $query = DB::table('program_caches')
            ->selectRaw('program_status as id, program_status_text as name, COUNT(program_status) as count')
            ->groupBy(['program_status', 'program_status_text']);

        if($programType != 0) {
            $query = $query->where('program_type', $programType);
        }

        if($year != 0) {
            $query = $query->where('year', $year);
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

    public function splitOptions($attributeName, $year): array
    {
        $selectString = $attributeName.'_text as text, COUNT('. $attributeName.") as count";

        $query = DB::table('raising_starts_caches')
            ->selectRaw($selectString)
            ->groupBy([$attributeName, $attributeName.'_text']);

        if($year != 0) {
            $query = $query->where('year', $year);
        }

        // Uzmi u obzir status programa
        $query = $query->whereIn('program_status', [-1,-3,-4,2,3,4,5,6,7,8,9]);

        $rows = $query->get();

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
        $program_type = $request->post('program_type');
        $year = $request->post('year');
        $query = DB::table('program_caches')->selectRaw("SUM(session_count) as sessions, SUM(workshop_count) as workshops");

        $queryData = [];
        if($program_type != 0) {
            $queryData['program_type'] = $program_type;
        }

        if($year != 0) {
            $queryData['year'] = $year;
        }

        if(count($queryData) > 0) {
            $query = $query->where($queryData);
        }

        $counts = $query->get()->first();
        $workshops = Training::getForYearAndType($year, 1 /* workshop */)->count();

        // $workshops = Training::find()->filter(function($training) use($program_type){
        //     return $training->getValue('program_type') == $program_type && $training->getValue('training_type') == 1;
        // })->count();

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
            if($pcache->membership_type == 1) {
                $resultData['virtuelni'] += 1;
            }
            else if($pcache->membership_type == 2) {
                $resultData['punopravni'] += 1;
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

    public function exportRaisingStartsDashboard($year)
    {
        $exportData = [];

        // Startup types.
        $request = new Request([],[
            'project_type' => Program::$RAISING_STARTS,
            'year' => $year,
        ], [], [], [], [], null);

        $exportData['startupTypes'] = $this->startupTypes($request);

        // Program statuses
        $exportData['programStatuses'] = $this->programStatuses($request);

        // Workshops and sessions.
        $exportData['workshopsAndSessionStats'] = $this->getWorkshopAndSessionStats($request);

        // Distributerion by NTP
        $exportData['ntp'] = $this->ntp($request);

        // Distribution by Cities
        $exportData['prijavePoGradovima'] = $this->prijave_po_gradovima($request);

        // Distribution by Municipalities
        $exportData['prijavePoOpstinama'] = $this->prijave_po_opstinama($request);

        $parametri = [
            'how_innovative',
            'dev_phase_tech',
            'dev_phase_business',
            'howdiduhear',
            'intellectual_property',
            'innovative_area',
            'product_type',
        ];

        foreach($parametri as $parametar) {
            $exportData[$parametar] = $this->splitOptions($parametar, $year);
        }

        $exportData['year'] = $year;

        // var_dump($exportData);
        // die();

        return Excel::download(new RSDashboardExport("Raising Starts Statistika", $exportData),'rs_statistics.xlsx');
    }
}
