<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\Client;

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
        $attributes = Client::getAttributesDefinition();
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

        $client = new Client($data);
        if($client != null) {
            $client->addEventByData('interesovanje',
                [
                    'name' => 'Interesovanje',
                    'description' => 'Klijent je zainteresovan za saradnju'
                ]);
        }

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client(['instance_id' => $id]);
        $events = $client->getEvents();
        return view('clients.show', ['client' => $client, 'events' => $events]);
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
