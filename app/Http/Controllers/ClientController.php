<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\Client;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::find()->toArray();
        $clientsArray = [];
        foreach($clients as $client) {
            $clientsArray[$client->getId()] = $client->getAttributeTexts();
        }

        return view('clients.index', ['clients' => $clientsArray]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Client::getAttributesDefinition('start');
        $action = route('clients.store');
        return view('clients.create', ['attributes' => $attributes, 'action' => $action]);
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

        // Handle the uploaded file
        $file = $request->file('application_form');
        if($file != null) {
            $originalFileName = $file->getClientOriginalName();
            $path = $file->store('documents');
            $path = asset($path);
            $data['application_form'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        $client = new Client($data);
        if($client != null) {
            $eventData = [
                'name' => 'Interesovanje',
                'description' => 'Klijent je zainteresovan za saradnju',
            ];
            if($file != null) {
                $eventData['application_form'] = $data['application_form'];
            }

            $client->addSituationByData('interesovanje',$eventData);
        }

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->session()->put('backroute', route('clients.show', $id));

        $client = new Client(['instance_id' => $id]);
        $situations = $client->getSituations();
        return view('clients.show', ['model' => $client, 'situations' => $situations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client(['instance_id' => $id]);
        $action = route('clients.update', $client->getId());
        return view('clients.edit', ['model' => $client, 'action' => $action]);
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
        $data = $request->post();

        // Handle the uploaded file
        $file = $request->file('application_form');
        if($file != null) {
            $originalFileName = $file->getClientOriginalName();
            $path = $file->store('documents');
            $path = asset($path);
            $data['application_form'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Upgrade the status.
        $data['status'] = 2;

        // Find the client with the given id.
        $client = new Client(['instance_id' => $id]);
        if($client != null) {

            // Update the client with changes.
            $client->setData($data);

            // Register the situation.
            $eventData = [
                'name' => 'Registracija',
                'description' => 'Klijent je registrovan',
                'client' => $client->getAttribute('name')->getValue()
            ];
            if($file != null) {
                $eventData['application_form'] = $data['application_form'];
            }

            $client->addSituationByData('registracija',$eventData);
        }

        return redirect(route('clients.index'));
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
