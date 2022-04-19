<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Business\Program;
use App\ProfileCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Raspodela programa po NTP.
     * @return array
     */
    public function ntp(): array
    {
        return DB::table('profile_caches')
            ->selectRaw("ntp_text as ntp, COUNT(ntp) as count")
            ->groupBy(["ntp", "ntp_text"])->get()->toArray();

        return $result;
    }

    /**
     * Raspodela po tipovima startapa.
     * @return array
     */
    public function startupTypes(): array
    {

        $appliedGroups = DB::table("profile_caches")
            ->selectRaw("is_company as id, is_company_text as type, COUNT(is_company) as count")
            ->groupBy(["is_company", "is_company_text"])->get();

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

    public function applicationStatuses($programType): array
    {
        $profileStates = DB::table('profile_caches')
            ->selectRaw('profile_state as id, profile_state_text as name, COUNT(profile_state) as count')
            ->groupBy(['profile_state', 'profile_state_text'])->get();

        $applied = 0;
        $sent = 0;
        foreach($profileStates as $profileState) {
            $applied += $profileState->count;
            if($profileState->id > 2) {
                $sent += $profileState->count;
            }
        }

        return [
            'applied' => $applied,
            'sent' => $sent,
        ];

    }

    public function splitInterest() {
        $result = $this->howDidUHear();
        return $result['items'];
    }

    public function splitOptions($attributeName): array
    {
        $attr = Attribute::where('name', $attributeName)->first();
        $attrOptions = $attr->getOptions();

        $items = [];
        $total = 0;

        foreach($attrOptions as $key=>$value) {
            $count = Program::find([$attributeName => $key])->count();
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
        $countries = DB::table('countries')->whereIn('id', $countryIds)->get();
        $countryNames = [];
        foreach($countries as $country) {
            $countryNames[] = $country->country;
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
