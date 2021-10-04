<?php

namespace App\Http\Controllers;

use App\Business\DemoDay;
use Illuminate\Http\Request;

class DemoDayController extends Controller
{
    public function update(Request $request, $id): array
    {
        $data = $request->post();
        $data['demoday_client_notified'] = true;

        $demoday = new DemoDay(['instance_id' => $data['id']]);
        if($demoday->instance == null) {
            return [
                'code' => 1,
                'message' => 'No demo day with id' .$id,
            ];
        }

        $demoday->setData($data);
        return [
            'code' => 0,
            'message' => 'DemoDay updated successfully',
        ];
    }

    public function sendfiles(Request $request): array
    {
        $data = $request->post();
        $profileId = $data['profileId'];
        $id = $data['demodayId'];
        $files = $this->getFilesFromRequest($request, 'demoday_files');

        $demoday = DemoDay::find($id);
        $demoday->setValue('demoday_files', $files);
        $demoday->setValue('demoday_files_sent', true);

        return [
            'profileId' => $profileId,
            'id' => $id,
            'files' => $files
        ];
    }

    private function getFilesFromRequest(Request $request, $filename): array
    {
        if(!$request->hasFile($filename))
            return [
                'message' => 'No file with that name',
                'filelink' => '',
                'filename' => ''
            ];

        if(is_array($request->file($filename))) {
            $files = [];
            if($request->hasFile($filename)) {
                foreach($request->file($filename) as $file) {
                    $originalFileName = $file->getClientOriginalName();
                    $path = $file->store('documents');
                    $path = asset($path);
                    $files[] = [
                        'filelink' => $path,
                        'filename' => $originalFileName
                    ];
                }
            }

            return $files;
        }


        $file = $request->file($filename);
        $originalFileName = $file->getClientOriginalName();
        $path = $file->store('documents');
        $path = asset($path);
        return [
            'filelink' => $path,
            'filename' => $originalFileName
        ];

    }
}
