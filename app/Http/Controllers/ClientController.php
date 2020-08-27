<?php

namespace App\Http\Controllers;

use App\Business\Situation;
use Illuminate\Http\Request;
use App\Business\Client;
use App\User;
use Illuminate\Support\Facades\Hash;
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
        $this->authorize('manage_user_profiles');

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
        $this->authorize('manage_user_profiles');

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

        // Hash code the password.
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Create new client.
        $client = new Client($data);
        if($client != null) {

            // Create 'interested' situation.
            $eventData = [
                'name' => 'Interesovanje',
                'description' => 'Klijent je zainteresovan za saradnju',
            ];

            // Add file to the situation.
            if($file != null) {
                $eventData['application_form'] = $data['application_form'];
            }

            // Add situation to the client.
            $client->addSituationByData('interesovanje',$eventData);
        }

        // Check if the user already exists.
        $user = User::where(['email' => $data['email']])->first();

        // If not, create one.
        if($user === null) {

            // Create user.
            $user = User::create([
                'name' => $data['contact_person'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            // Define it as the client.
            $user->assignRole('client');
        }

        // Attach default user to the instance.
        $client->attachUser($user);

        // TODO - Send email to the user.


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
        $this->authorize('read_user_profile', $id);

        if(auth()->user()->isAdmin()) {
            $request->session()->put('backroute', route('clients.index'));
        } else {
            $request->session()->put('backroute', route('home'));
        }

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

        // Find the client with the given id.
        $client = new Client(['instance_id' => $id]);
        if($client != null) {

            // Update the client with changes.
            $client->setData($data);
        }

        return redirect(route('clients.show', $id));
    }

    /**
     * Change the status of the client from 'interested' to 'registered'
     * @param $id
     */
    public function register($id) {
        if(auth()->user()->isAdmin()) {
            $client = Client::find($id);
            if($client != null && $client->getData()['status'] == 1) {
                // Change status
                $client->setData(['status' => 2]);

                // Find out if the client is already registered.
                $registration = $client->getSituation('registracija');
                if($registration == null) {
                    // Register the situation.
                    $eventData = [
                        'name' => 'Registracija',
                        'description' => 'Klijent je registrovan',
                        'client' => $client->getAttribute('name')->getValue()
                    ];

                    $eventData['application_form'] = $client->getData()['application_form'];
                    $client->addSituationByData('registracija',$eventData);
                }
            }

            // TODO: Inform the client, send a mail.
        }

        return redirect(route('clients.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('manage_user_profiles');

        // delete client.
    }

    public function preselect($id) {
        $client = Client::find($id);
        return view('clients.preselect', ['client' => $client]);
    }

    public function preselected(Request $request, $id) {
        $data = $request->post();
        $client = Client::find($id);

        // Handle the uploaded file
        $file = $request->file('assertion_file');
        if($file != null) {
            $originalFileName = $file->getClientOriginalName();
            $path = $file->store('documents');
            $path = asset($path);
            $data['assertion_file'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        $data['name'] = 'Predselekcija';
        $data['description'] = 'Izbor klijenta u predselekciju';

        // Add situation to the client.
        $client->addSituationByData('predselekcija',$data);

        if($data['decision'] === 'yes') {
            // Lift status.
            $client->setData(['status' => 3]);
        } else {
            $client->setData(['status' => 7]);
        }

        // TODO: Inform the client, send a mail.

        return redirect(route('clients.show', $id));
    }

    /**
     * Ivite client to meeting form.
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite($id) {
        $client = Client::find($id);
        return view('clients.invite', ['client' => $client]);
    }

    /**
     * Confirm the client is invited.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function invited(Request $request, $id) {
        $client = Client::find($id);
        $data = $request->post();

        $client->setData(['status' => 4]);

        $situacija = $client->getSituation('sastanak_poziv');
        if($situacija == null) {
            $client->addSituationByData('sastanak_poziv', $data);
        }

        // TODO: Inform the client, send a mail.

        return redirect(route('clients.show', $id));
    }

    /**
     * Opens the confirmation form.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm($id) {
        $client = Client::find($id);
        $meeting = $client->getSituation('sastanak_poziv');
        if($meeting != null) {
            $date = $meeting->getData()['meeting_date'];
            return view('clients.confirm', ['client' => $client, 'date' => $date]);
        }

        return view('clients.confirm', ['client' => $client]);
    }

    /**
     * Date of the meeting is confirmed.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmed(Request $request, $id) {
        $client = Client::find($id);
        $data = $request->post();

        // Change status and save changes.
        $data['status'] = 5;
        $client->setData($data);

        // Create situation
        $situation = $client->getSituation('sastanak_potvrda');
        if($situation == null) {
            $client->addSituationByData('sastanak_potvrda', $data);
        }

        // TODO: Notify the client via email.

        return redirect(route('clients.show', $id));
    }

    /**
     * Perform the the final selection.
     * @param $id
     */
    public function select($id) {
        $client = Client::find($id);
        return view('clients.select', ['client' => $client]);
    }

    public function selected(Request $request, $id) {
        $client = Client::find($id);

        $data = $request->post();
        if($data['decision'] === 'yes') {
            $data['decision'] = true;
            $client->setData(['status' => 6]);

        } else {
            $data['decision'] = false;
            $client->setData(['status' => 7]);
        }

        $situation = $client->getSituation('odluka');
        if($situation == null) {
            $client->addSituationByData('odluka', $data);
        }

        // TODO: Notify the client by email.

        return redirect(route('clients.show', $id));

    }

    /**
     * Assigns the infrastructure and support services to the client.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function assign($id) {
        $client = Client::find($id);

        // Prepare situation parameters.
        $data = $client->getData(
            [
                'kvadratura',
                'zajednicke_prostorije',
                'inovaciona_laboratorija',
                'konsalting_usluge'
            ]);

        // Create the situation.
        $client->addSituationByData('dodela_prostora', $data);


        // Shift status up.
        $client->setData(['status' => 7]);

        // TODO: Notify client per e-mail.

        return redirect(route('clients.show', $id));
    }
}
