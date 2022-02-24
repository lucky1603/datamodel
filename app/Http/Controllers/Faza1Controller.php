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
        $files = Utils::getFilesFromRequest($request, 'requested_files');

        if($files != ['filelink' => '', 'filename' => '']) {
            $faza1 = new Faza1(['instance_id' => $data['id']]);
            $faza1->setValue('requested_files', $files);
            $faza1->setValue('files_sent', true);
        }

        return [
            'profile' => $profileId,
            'files' => $files
        ];
    }

    public function rollback(Request $request) {
        $phaseId = $request->post('id');
        var_dump($request->post());
        $faza1 = Faza1::find($phaseId);
//        $program = $faza1->getWorkflow()->getProgram();
//        $profile = $program->getProfile();
//        $profileStatus = $profile->getValue('profile_status');
//        $profileState = $profile->getValue('profile_state');
//        $programStatus = $program->getStatus();
        $filesSent = $faza1->getValue('files_sent');
        if($filesSent) {
            $faza1->setValue("requested_files", null);
            $faza1->setValue('files_sent', false);
        }
    }

}
