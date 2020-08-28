<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\Business\Contract;
use App\Business\Situation;
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
        $contracts = collect(Contract::find()->all());
        return view('contracts.index', ['contracts' => $contracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $client = Client::find($id);
        $attributes = Contract::getAttributesDefinition();
        $action = route('contracts.store', $client->getId());
        return view('contracts.create', ['attributes' => $attributes, 'action' => $action, 'client' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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

        $client = Client::find($id);
        $client->setData(['status' => 11]);
        if($contract != null) {
            $client->addContract($contract);
        }

        // Create situation
        $situation = $client->getSituation('ugovor_potpis');
        if($situation == null) {
            $client->addSituationByData('ugovor_potpis', $data);
        }

        return redirect(route('clients.show', $id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->session()->put('backroute', route('contracts.show', $id));

        $contract = new Contract(['instance_id' => $id]);
        $situations = $contract->getSituations();
        $client = Client::find($contract->instance->parent_id);
        return view('contracts.show', ['model' => $contract, 'situations' => $situations, 'client' => $client]);
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
