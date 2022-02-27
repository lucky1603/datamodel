<?php

namespace App\Http\Controllers;

use App\File;
use App\FileGroup;
use App\MentorReport;
use App\Report;
use Illuminate\Http\Request;

class MentorReportController extends Controller
{
    public function get($reportId) {
        $r = MentorReport::find($reportId)->load('file_groups');

        $reportData = [
            'id' => $r->id,
            'program_id' => $r->pogram_id,
            'mentor_id' => $r->mentor_id,
            'name' => $r->name,
            'status' => $r->status,
            'dueDate' => $r->due_date
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

        $date = date('Y-m-d', strtotime($reportData['dueDate']));
        $reportData['dueDate'] = $date;

        return $reportData;
    }

    public function edit($reportId) {
        $report = MentorReport::find($reportId)->load('file_groups');
        return view('mentor-reports.edit', ['report' => $report]);
    }

    public function fileGroupAdded(Request $request): array
    {
        $data = $request->post();

        $report = MentorReport::find($data['report_id'])->load('file_groups');
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
            $report->setAttribute('status', Report::$SENT);
            $report->save();
        }

        return [
            'code' => 0,
            'message' => 'File group successfully added!'
        ];
    }
}
