<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Business\Program;
use Illuminate\Http\Request;

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
        $ntpAttr = Attribute::where('name', 'ntp')->first();
        $ntpAttrOptions = $ntpAttr->getOptions();
        $result = [];
        foreach($ntpAttrOptions as $key=>$value) {
            $count = Program::find(['ntp' => $key])->count();
            $name = $value;
            $result[] = [
                'ntp' => $name,
                'count' => $count
            ];
        }

        return $result;
    }

    /**
     * Raspodela po tipovima startapa.
     * @return array
     */
    public function startupTypes(): array
    {

        $startupCount = Program::find(['app_type' => 1])->count();
        $companyCount = Program::find(['app_type' => 2])->count();

        return [
            'startupCount' => $startupCount,
            'companyCount' => $companyCount,
            'total' => ($startupCount + $companyCount)
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
                'how' => $name,
                'count' => $count
            ];

            $total += $count;
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }



}
