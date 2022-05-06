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
        $programId = $data['programId'];
        $files = Utils::getFilesFromRequest($request, 'requested_files');

        if($files != ['filelink' => '', 'filename' => '']) {
            $faza1 = new Faza1(['instance_id' => $data['id']]);
            $faza1->setValue('requested_files', $files);
            $faza1->setValue('files_sent', true);
        }

        return [
            'programId' => $programId,
            'files' => $files
        ];
    }

    public function rollback(Request $request) {
        $phaseId = $request->post('id');
        $faza1 = Faza1::find($phaseId);
        $filesSent = $faza1->getValue('files_sent');
        if($filesSent) {
            $faza1->setValue("requested_files", null);
            $faza1->setValue('files_sent', false);
        }
    }

}
