<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\File;
use App\FileGroup;
use App\Report;
use App\CompanyStat;
use App\Country;
use Hamcrest\Util;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function list($programId) {
        $reports = Report::where('instance_id', $programId)->get();
        return view('reports.list', ['reports' => $reports, 'program_id' => $programId]);
    }

    public function create($programId) {
        return view('reports.create', ['program' => $programId]);
    }

    public function store(Request $request, $programId) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'contract_check' => 'required|date',
        ]);

        $program = Program::find($programId);
        $profile = $program->getProfile();

        $data = $request->post();
        $data['report_name'] = $data['title'];
        unset($data['title']);
        $data['report_description'] = $data['description'];
        unset($data['description']);
        $data['company_name'] = $profile->getValue('name');
        $data['program_name'] = $program->getValue('program_name');
        unset($data['links']);
        unset($data['tech_fulfilled']);
        unset($data['business_fulfilled']);
        unset($data['narative_approved']);
        unset($data['report_approved']);
        unset($data['files']);

        $report = Report::create($data);
        $program->addReport($report);

        $files = Utils::getFilesFromRequest($request, 'files');
        if(count($files) > 0 && $files != ['filelink' => '', 'filename' => '']) {
            foreach($files as $file) {
                $attachment = Attachment::create([
                    'filename' => $file['filename'],
                    'filelink' => $file['filelink']
                ]);

                $report->addAttachment($attachment);
            }
        }

    }

    public function edit($reportId) {
        $token = $token = csrf_token();
        $report = Report::find($reportId);
        $program = $report->getProgram();
        $role = auth()->user()->roles()->first()->name;
        return view('reports.edit', ['report' => $reportId, 'token' => $token, 'program' => $program->getId(), 'role' => $role]);
    }

    public function getData($reportId) {
        $r = Report::find($reportId)->load('file_groups');

        $reportData = [
            'id' => $r->id,
            'company_name' => $r->company_name,
            'report_name' => $r->report_name,
            'program_name' => $r->program_name,
            'contract_check' => $r->contract_check,
            'report_description' => $r->report_description,
            'tech_fulfilled' => $r->tech_fulfilled,
            'business_fulfilled' => $r->business_fulfilled,
            'financial_approved' => $r->financial_approved,
            'narative_approved' => $r->narative_approved,
            'report_approved' => $r->report_approved,
            'status' => $r->status
        ];

        $reportData['file_groups'] = [];
        foreach($r->file_groups as $file_group) {
            $files = [];
            foreach($file_group->files as $file) {
                $files[] = [
                    'filename' => $file->filename,
                    'filelink' => $file->filelink
                ];
            }

            $reportData['file_groups'][] = [
                'id' => $file_group->id,
                'name' => $file_group->name,
                'note' => $file_group->note,
                'files' => $files
            ];

        }

        $date = date('Y-m-d', strtotime($reportData['contract_check']));
        $reportData['contract_check'] = $date;


        return $reportData;
    }

    public function programReports($programId) {
        $this->authorize('read_program', [$programId]);

        $program = ProgramFactory::resolve($programId);
        $profile = $program->getProfile();
        $role = auth()->user()->roles()->first()->name;

        return view('reports.forTraining', ['model' => $profile, 'program' => $program, 'user_role' => $role]);
    }

    public function update(Request $request, $id) {
        // get files
        $files = Utils::getFilesFromRequest($request, 'files');

        $data = $request->post();

        $report = Report::find($id);

        // Get files.
        if(count($files) > 0 && $files != ['filelink' => '', 'filename' => '']) {
            $report->removeAllAttachments();

            foreach($files as $file) {
                $attachment = Attachment::create([
                    'filelink' => $file['filelink'],
                    'filename' => $file['filename']
                ]);

                $report->addAttachment($attachment);
            }
        }

        // Update other properties
        $report->report_name = $data['title'];
        $report->contract_check = $data['contract_check'];
        $report->tech_fulfilled = $data['tech_fulfilled'] == 'on';
        $report->business_fulfilled = $data['business_fulfilled'] == 'on';
        $report->narative_approved = $data['narative_approved'] == 'on';
        $report->report_approved = $data['report_approved'] == 'on';

        $report->status = Report::$SENT;

        $report->save();

    }

    public function addFileGroup($reportId) {
        $token = csrf_token();
        return view('reports.add-file-group', ['token' => $token, 'reportId' => $reportId, 'title' => 'Ovo je izvestaj']);
    }

    public function fileGroupAdded(Request $request) {
        $data = $request->post();

        $report = Report::find($data['report_id'])->load('file_groups');
        $files = Utils::getFilesFromRequest($request, 'files');
        if($files != ['filename' => '', 'filelink' => '']) {

            foreach($files as $file){
                $data['files'][] = [
                    'filename' => $file['filename'],
                    'filelink' => $file['filelink']
                ];
            }

            $reportCount = $report->file_groups->count();
            if($reportCount == 0) {
                $fileGroup = FileGroup::create([
                    'name' => 'IZVEŠTAJ',
                    'note' => $data['note'],
                ]);
            } else {
                $fileGroup = FileGroup::create([
                    'name' => 'DODATNI IZVEŠTAJ '.$reportCount,
                    'note' => $data['note'],
                ]);
            }

            foreach($files as $file) {
                $fileGroup->addFile(File::create([
                    'filename' => $file['filename'],
                    'filelink' => $file['filelink']
                ]));
            }

            $report->addFileGroup($fileGroup);
            // $report->setAttribute('status', Report::$SENT);
            $report->save();
        }

        return [
            'code' => 0,
            'message' => 'File group successfully added!'
        ];
    }

    ///
    /// API calls
    ///

    /**
     * Returns the report infos for the given report id (API call).
     * @param $programId
     * @return array
     */
    public function programReportsInfo($programId): array
    {
        $program = ProgramFactory::resolve($programId);
        $reports = $program->getReports();
        $programReportsData = [];
        $count = 1;
        foreach ($reports as $report) {
            $date = date('Y-m-d', strtotime($report->contract_check));
            $programReportsData[] = [
                'orderNumber' => $count++,
                'reportId' => $report->id,
                'reportName' => $report->report_name,
                'reportDue' => $date,
                'status' => $report->status
            ];
        }

        return $programReportsData;
    }

    public function performCheck() {
//        Report::all()->each(function($report) {
//            $now = now();
//            $contract_check = $report->contract_check;
//            $diff =
//        });
    }

    public function changeStatus(Request $request) {
        $data = $request->post();
        $status = $data['status'];
        $report_id = $data['report_id'];
        $report = Report::find($report_id);
        if($report == null)
            return false;

        $report->status = $status;
        $report->save();
        return true;
    }

    public function getStatistics($reportId) {
        $report = Report::find($reportId);
        $statisticData = [
            'iznos_prihoda' => 0,
            'iznos_izvoza' => 0.0,
            'broj_zaposlenih' => 0,
            'broj_angazovanih' => 0,
            'broj_angazovanih_zena' => 0,
            'iznos_placenih_poreza' => 0.0,
            'iznos_ulaganja_istrazivanje_razvoj' => 0.0,
            'broj_malih_patenata' => 0,
            'broj_patenata' => 0,
            'broj_autorskih_dela' => 0,
            'broj_inovacija' => 0,
            'countries' => [],
            'statistic_sent' => false,
            'faza_razvoja' => 0,
            'membership_type' => 0,
            'women_founders_count' => 0,
            'broj_povratnika_iz_inostranstva' => 0,
            'broj_zasticenih_zigova' => 0,
        ];

        if($report->company_stat != null) {
            $countries = $report->company_stat->countries->map(function($country) {
                return $country->id;
            });

            $statisticData['iznos_prihoda'] = $report->company_stat->iznos_prihoda;
            $statisticData['iznos_izvoza'] = $report->company_stat->iznos_izvoza;
            $statisticData['broj_zaposlenih'] = $report->company_stat->broj_zaposlenih;
            $statisticData['broj_angazovanih'] = $report->company_stat->broj_angazovanih;
            $statisticData['broj_angazovanih_zena'] = $report->company_stat->broj_angazovanih_zena;
            $statisticData['iznos_placenih_poreza'] = $report->company_stat->iznos_placenih_poreza;
            $statisticData['iznos_ulaganja_istrazivanje_razvoj'] = $report->company_stat->iznos_ulaganja_istrazivanje_razvoj;
            $statisticData['broj_malih_patenata'] = $report->company_stat->broj_malih_patenata;
            $statisticData['broj_patenata'] = $report->company_stat->broj_patenata;
            $statisticData['broj_autorskih_dela'] = $report->company_stat->broj_autorskih_dela;
            $statisticData['broj_inovacija'] = $report->company_stat->broj_inovacija;
            $statisticData['countries'] = $countries;
            $statisticData['statistic_sent'] = $report->company_stat->statistic_sent;
            $statisticData['faza_razvoja'] = $report->company_stat->faza_razvoja;
            $statisticData['women_founders_count'] = $report->company_stat->women_founders_count;
            $statisticData['broj_povratnika_iz_inostranstva'] = $report->company_stat->broj_povratnika_iz_inostranstva;
            $statisticData['broj_zasticenih_zigova'] = $report->company_stat->broj_zasticenih_zigova;
        }

        return $statisticData;
    }

    public function updateStatistics(Request $request) {
        $data = $request->post();
        $report_id = $data['report_id'];
        $report = Report::find($report_id);

        if($report->company_stat == null) {
            $company_stat = CompanyStat::create();
            $report->company_stat()->associate($company_stat);
            $report->save();
        }

        // Update countries.
        $report->company_stat->countries()->detach();
        if(isset($data['countries'])) {
            $countryIds = $data['countries'];
            if(count($countryIds) > 0) {
                foreach($countryIds as $countryId) {
                    $country = Country::find($countryId);
                    $report->company_stat->countries()->attach($country);
                }
                $report->company_stat->statistic_sent = true;
                $report->company_stat->save();
            }
        }


        $report->company_stat->iznos_prihoda = $data['iznos_prihoda'];
        $report->company_stat->iznos_izvoza = $data['iznos_izvoza'];
        $report->company_stat->broj_zaposlenih = $data['broj_zaposlenih'];
        $report->company_stat->broj_angazovanih = $data['broj_angazovanih'];
        $report->company_stat->broj_angazovanih_zena = $data['broj_angazovanih_zena'];
        $report->company_stat->iznos_placenih_poreza = $data['iznos_placenih_poreza'];
        $report->company_stat->iznos_ulaganja_istrazivanje_razvoj = $data['iznos_ulaganja_istrazivanje_razvoj'];
        $report->company_stat->broj_malih_patenata = $data['broj_malih_patenata'];
        $report->company_stat->broj_patenata = $data['broj_patenata'];
        $report->company_stat->broj_autorskih_dela = $data['broj_autorskih_dela'];
        $report->company_stat->broj_inovacija = $data['broj_inovacija'];
        $report->company_stat->faza_razvoja = $data['faza_razvoja'];
        $report->company_stat->women_founders_count = $data['women_founders_count'];
        $report->company_stat->broj_povratnika_iz_inostranstva = $data['broj_povratnika_iz_inostranstva'];
        $report->company_stat->broj_zasticenih_zigova = $data['broj_zasticenih_zigova'];

        $report->company_stat->save();

        return true;
    }


}
