<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\Business\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::find()->all();
        $contractsArray = [];
        foreach($contracts as $contract) {
            $contractsArray[$contract->getId()] = $contract->getAttributeTexts();
        }

        return view('contracts.index', ['contracts' => $contractsArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Contract::getAttributesDefinition();
        $action = route('contracts.store');
        return view('contracts.create', ['attributes' => $attributes, 'action' => $action]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->post();
        $file = $request->file('contract_document');
        $filename = $file->getClientOriginalName();
        $path = $file->store('documents');
        $path = asset($path);
        $data['contract_document'] = [
            'filename' => $filename,
            'filelink' => $path
        ];

        $contract = new Contract($data);
        if($contract != null) {
            $event = $contract->addSituationByData('potpis_ugovora', [
               'name' => 'Potpis ugovora',
                'description' => "Klijent je potpisao ugovor"
            ]);
        }

        return redirect(route('contracts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = new Contract(['instance_id' => $id]);
        $situations = $contract->getSituations();
        return view('contracts.show', ['model' => $contract, 'situations' => $situations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
