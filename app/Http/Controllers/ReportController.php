<?php

namespace App\Http\Controllers;

use App\Business\ProgramFactory;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function list($programId) {
        $reports = Report::where('instance_id', $programId)->get();
        return view('reports.list', ['reports' => $reports, 'program_id' => $programId]);
    }

    public function edit($reportId) {
        $token = $token = csrf_token();
        $report = Report::find($reportId);
        $program = $report->getProgram();
        return view('reports.edit', ['report' => $reportId, 'token' => $token, 'program' => $program->getId()]);
    }

    public function getData($reportId) {
        $report = Report::find($reportId)->load('attachments');
        $date = date('Y-m-d', strtotime($report->contract_check));
        $report->contract_check = $date;

        return $report;
    }

    public function programReports($programId) {
        $program = ProgramFactory::resolve($programId);
        $profile = $program->getProfile();

        return view('reports.forTraining', ['model' => $profile, 'program' => $program]);
    }

    public function update(Request $request, $id) {

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


}
