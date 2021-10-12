<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\Business\Contract;
use App\Business\Situation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ContractsController extends Controller
{

    /**
     * Update the existing contract.
     * @param Request $request
     * @param $contractId
     * @return array
     */
    public function update(Request $request, $contractId): array
    {
        $data = $request->post();
        var_dump($data);

        $contract_file = $request->file('contract_document');
        $data['contract_file'] = $contract_file;

        if($contract_file != null) {
            $originalFileName = $contract_file->getClientOriginalName();
            $path = $contract_file->store('documents');
            $path = asset($path);
            $data['contract_document'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        $contract = new Contract(['instance_id' => $contractId]);
        $contract->setData($data);

        return [
            'code' => 0,
            'message' => 'Contract successfully updated! No contract file',
            'data' => $data
        ];
    }


}
