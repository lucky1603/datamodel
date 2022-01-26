<?php

namespace App\Http\Controllers;

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
        return view('reports.edit', ['report' => $reportId, 'token' => $token]);
    }

    public function getData($reportId) {
        $report = Report::find($reportId)->load('attachments');
        $date = date('Y-m-d', strtotime($report->contract_check));
        $report->contract_check = $date;

        return $report;
    }
}
