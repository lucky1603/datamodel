<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Business\Profile;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\Business\Situation;
use App\ProfileCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProgramController extends Controller
{

    public function index() {
        return view('programs.index');
    }

    public function show($programId) {
        $program = ProgramFactory::resolve($programId,true);
        return view('programs.show', ['program' => $program]);
    }

    public function evalPhase(Request $request) {
        $data = $request->post();

        if(!isset($data['programId'])) {
            return [
                'code' => 1,
                'message' => __('Wrong parameters')
            ];
        }

        $programId = $data['programId'];
        $program = ProgramFactory::resolve($programId, true);
        if($program === null) {
            return [
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ];
        }

        $profile = $program->getProfile();

        if($data['passed'] == 'on') {
            $validation = $program->getWorkflow()->getCurrentPhase()->validateData($data);
            if($validation['code'] != 0) {
                return $validation;
            }

            if($program->getWorkflow()->isLastStep())
            {
                // Set data.
                $program->getWorkflow()->getCurrentPhase()->setData($data);

                $program->setStatus(Program::$PROGRAM_ACTIVE);

                $situation = new Situation([
                    'name' => 'U PROGRAMU',
                    'description' => 'Klijent je počeo da koristi program',
                    'sender' => 'NTP'
                ]);

                $profile->addSituation($situation);
                $program->addSituation($situation);

                // Dodaj izveštaje
                $program->initReports();

            } else {
                $programStatus = $program->getStatus();
                $phase = $program->getWorkflow()->getCurrentPhase();
                $phase->setData($data);
                if($phase->requiresExitSituation()) {
                    $situation = $phase->getExitSituation();
                    if($situation != null) {
                        $profile->addSituation($situation);
                        $program->addSituation($situation);
                    }
                }

                if($phase->requiresExitEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
                }

                $program->setStatus($programStatus + 1);
                $phase = $program->getWorkflow()->getCurrentPhase();
                if($phase->requiresEntrySituation()) {
                    $situation = $phase->getEntrySituation();
                    if($situation != null) {
                        $profile->addSituation($situation);
                        $program->addSituation($situation);
                    }

                }
                if($phase->requiresEntryEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getEntryEmailTemplate());
                }
            }
        } else {
            $program->setStatus(Program::$PROGRAM_SUSPENDED);
            $phase = $program->getWorkflow()->getCurrentPhase();
            $phase->setData($data);

            if($phase->requiresExitSituation()) {
                $profile->addSituation($phase->getExitSituation());
                $program->addSituation($phase->getExitSituation());
            } else {
                $situation = new Situation([
                    'name' => 'ODBIJEN',
                    'description' => 'Klijent je odbijen u fazi - "'.$phase->getDisplayName().'".',
                    'sender' => 'NTP'
                ]);
                $profile->addSituation($situation);
                $program->addSituation($situation);
            }

            if($phase->requiresExitEmail()) {
                Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
            }
        }

        return [
            'code' => 0,
            'message' => __('Eval successfull!'),
        ];
    }

    public function filterCache(Request $request) {
        $data = $request->post();
        $query = DB::table('program_caches');
        return $query->select()->get()->map(function($row) {
            return new class($row) {
                public $id;
                public $type;
                public $typeText;
                public $company;
                public $status;
                public $statusText;
                public $logo;
                public function __construct($row)
                {
                    $this->id = $row->program_id;
                    $this->type = $row->program_type;
                    $this->typeText = $row->program_type_text;
                    $this->company = $row->profile_name;
                    $this->logo = $row->profile_logo;
                    $this->status = $row->program_status;
                    $this->statusText= $row->program_status_text;
                }

            } ;
        });

    }



    /////
    /// STATISTICS ///
    ///
    public function getStatistics($programId): array
    {
        $program = Program::find($programId);
        return [
            'iznos_prihoda' => $program->getValue('iznos_prihoda'),
            'iznos_izvoza' => $program->getValue('iznos_izvoza'),
            'broj_zaposlenih' => $program->getValue('broj_zaposlenih'),
            'broj_angazovanih' => $program->getValue('broj_angazovanih'),
            'broj_angazovanih_zena' => $program->getValue('broj_angazovanih_zena'),
            'iznos_placenih_poreza' => $program->getValue('iznos_placenih_poreza'),
            'iznos_ulaganja_istrazivanje_razvoj' => $program->getValue('iznos_ulaganja_istrazivanje_razvoj'),
            'broj_malih_patenata' => $program->getValue('broj_malih_patenata'),
            'broj_patenata' => $program->getValue('broj_patenata'),
            'broj_autorskih_dela' => $program->getValue('broj_autorskih_dela'),
            'broj_inovacija' => $program->getValue('broj_inovacija'),
            'countries' => $program->getValue('countries'),
            'statistic_sent' => $program->getValue('statistic_sent')

        ];
    }

    public function updateStatistics(Request $request) {
        $data = $request->post();
        unset($data['statistic_sent']);

        $program = Program::find($data['id']);
        foreach($data as $key=>$value) {
            $program->setValue($key, $value);
        }

        $program->setValue('statistic_sent', 'on');

    }
}
