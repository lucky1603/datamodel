<?php

namespace App\Http\Controllers;

use App\Business\Faza1;
use Illuminate\Http\Request;

class Faza1Controller extends Controller
{
    public function update(Request $request) {
        $data = $request->post();

        if($data['passed'] == 'on')
            $data['passed'] = true;
        else
            $data['passed'] = false;

        $faza1 = new Faza1(['instance_id' => $data['id']]);
        $faza1->setData($data);

        return [
            'code' => 0,
            'message' => 'Sucess!'
        ];
    }

    public function sendfiles(Request $request): array
    {
        $data = $request->post();
        $profileId = $data['profile'];
        $files = $this->getFilesFromRequest($request, 'requested_files');

        $faza1 = new Faza1(['instance_id' => $data['id']]);
        $faza1->setValue('requested_files', $files);
        $faza1->setValue('files_sent', true);

        return [
            'profile' => $profileId,
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
            $fileEntries = $request->file($filename);
            foreach($fileEntries as $file) {
                $originalFileName = $file->getClientOriginalName();
                $path = $file->store('documents');
                $path = asset($path);
                $files[] = [
                    'filelink' => $path,
                    'filename' => $originalFileName
                ];
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
