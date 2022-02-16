<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\Report;
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
                    'files' => $files
                ];

            }




        $date = date('Y-m-d', strtotime($reportData['contract_check']));
        $reportData['contract_check'] = $date;


        return $reportData;
    }

    public function programReports($programId) {
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
        $report->report_description = $data['description'];
        $report->contract_check = $data['contract_check'];
        $report->tech_fulfilled = $data['tech_fulfilled'] == 'on';
        $report->business_fulfilled = $data['business_fulfilled'] == 'on';
        $report->narative_approved = $data['narative_approved'] == 'on';
        $report->report_approved = $data['report_approved'] == 'on';

        $report->save();

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


}
