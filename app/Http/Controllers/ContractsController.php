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
        $data['status'] = 12;
        $data['contract_status'] = 1;

        $contract = new Contract($data);
        if($contract != null) {
            $situation = $contract->getSituation(__('Contract Signing'));
            if($situation == null) {
                $contract->addSituationByData(__('Contract Signing'), $data);
            } else {
                $situation->setData($data);
            }
        }

        $client = Client::find($id);
        $client->setData(['status' => 12]);
        if($contract != null) {
            $client->addContract($contract);
        }

        // Create situation
        $situation = $client->getSituation(__('Contract Signing'));
        if($situation == null) {
            $client->addSituationByData(__('Contract Signing'), $data);
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
        $request->session()->put('backroute', route('contracts.index'));

        $contract = new Contract(['instance_id' => $id]);
        $situations = $contract->getSituations();
        $client = $contract->getClient();
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
     *
     * Deletes the contracts.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        // authorize ...

        $contract = Contract::find($id);
        $contract->delete();
        return redirect(route('contracts'));
    }

    /**
     * Shows the form for the first installment payment.
     * @param $contractId
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payFirstInstallment($contractId) {
        $contract = Contract::find($contractId);
        $client = $contract->getClient();
        $fmt = numfmt_create('sr_RS', \NumberFormatter::CURRENCY);
//        $fmt = numfmt_create(App::getLocale(), \NumberFormatter::DECIMAL);
        $val = $fmt->format($contract->getData()['amount'], \NumberFormatter::TYPE_DOUBLE);

        return view('contracts.payfirstinstallment', ['contract' => $contract, 'client' => $client, 'full_amount' => $contract->getData()['amount'] ]);
    }

    /**
     * Handling the payment of the first installment.
     * @param Request $request
     * @param $contractId
     * @return Application|RedirectResponse|Redirector
     */
    public function firstInstallmentPayed(Request $request, $contractId) {
        $data = $request->post();
        $contract = Contract::find($contractId);
        $situation = $contract->getSituation(__('Intstallment I'));
        if($situation == null) {
            $situation = $contract->addSituationByData(__('Installment I'), $data);
        } else {
            $situation->setData($data);
        }

        return redirect(route('contracts.show', $contract->getId()));
    }


}
