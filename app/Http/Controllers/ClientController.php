<?php

namespace App\Http\Controllers;

use App\Business\Contract;
use App\Business\Situation;
use DateTime;
use Illuminate\Http\Request;
use App\Business\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('manage_user_profiles');

        $clients = Client::find();

        return view('clients.index', ['clients' => $clients]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('manage_user_profiles');

        $attributes = collect(Client::getCreateAttributesDefinitions());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
             return $item->name == 'status';
        });

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

        // Handle the logo file.
        $logo = $request->file('logo');
        if($logo != null) {
            $originalFileName = $logo->getClientOriginalName();
            $path = $logo->store('documents');
            $path = asset($path);
            $data['logo'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Handle the profile background file.
        $profile_background = $request->file('profile_background');
        if($profile_background != null) {
            $originalFileName = $profile_background->getClientOriginalName();
            $path = $profile_background->store('documents');
            $path = asset($path);
            $data['profile_background'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Handle the user photo file.
        $photo = $request->file('photo');

        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $data['photo'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Hash code the password.
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Initial status value - 'interested'.
        $data['status'] = 1;

        // Create new client.
        $client = new Client($data);
        if($client != null) {

            // Create 'interested' situation.
            $eventData = [
                'name' => __('Interest'),
                'status' => 1,
            ];

            // Add file to the situation.
            if($file != null) {
                $eventData['application_form'] = $data['application_form'];
            }

            // Add situation to the client.
            $client->addSituationByData(__('Interest'),$eventData);
        }

        // Check if the user already exists.
        $user = User::where(['email' => $data['email']])->first();

        // If not, create one.
        if($user === null) {

            // Create user.
            $user = User::create([
                'name' => $data['contact_person'],
                'email' => $data['email'],
                'password' => $data['password'],
                'photo' => isset($data['photo']) ? $data['photo']['filelink'] : null,
                'position' => isset($data['position']) ? $data['position'] : null,
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

        var_dump($data);
        die();

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

        // Handle the logo file.
        $logo = $request->file('logo');
        if($logo != null) {
            $originalFileName = $logo->getClientOriginalName();
            $path = $logo->store('documents');
            $path = asset($path);
            $data['logo'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Handle the profile background file.
        $profile_background = $request->file('profile_background');
        if($profile_background != null) {
            $originalFileName = $profile_background->getClientOriginalName();
            $path = $profile_background->store('documents');
            $path = asset($path);
            $data['profile_background'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Handle the team profile members.
        $team_members_file = $request->file('team_members_file');
        if($team_members_file != null) {
            $originalFileName = $team_members_file->getClientOriginalName();
            $path = $team_members_file->store('documents');
            $path = asset($path);
            $data['team_members_file'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        // Handle the user photo file.
        $photo = $request->file('photo');

        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $data['photo'] = [
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
     * Shows the client profile data and some of the data are possible to edit.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($id) {
        $user = Auth::user();
        if($user->isRole('client'))
        {
            $client = new Client(['instance_id' => $id]);
            $action = route('clients.update', $client->getId());
            return view('clients.profile', ['model' => $client, 'action' => $action]);
        }

        return redirect( route('clients.home'));
    }

    public function companyList()
    {
        $this->authorize('view_client_profiles');
        $client = Auth::user()->client();
        $companies = Client::all()->except([$client->getId()]);
        return view('clients.companylist', ['companies' => $companies]);
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
                $registration = $client->getSituation(__('Registration'));
                if($registration == null) {
                    // Register the situation.
                    $eventData = [
                        'name' => __('Registration'),
                        'client' => $client->getAttribute('name')->getValue(),
                        'status' => 2,
                    ];

                    if(isset($client->getData()['application_form'])) {
                        $eventData['application_form'] = $client->getData()['application_form'];
                    }
                    $client->addSituationByData(__('Registration'),$eventData);
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

        $data['name'] = __('Pre-selection');
        if($data['decision'] === 'yes') {
            // Lift status.
            $client->setData(['status' => 3]);
            $data['status'] = 3;
        } else {
            $client->setData(['status' => 7]);
            $data['status'] = 7;
        }

        // Add situation to the client.
        $client->addSituationByData(__('Pre-selection'),$data);



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
        $data['status'] = 4;

        $situacija = $client->getSituation(__('Meeting Invitation'));
        if($situacija == null) {
            $client->addSituationByData(__('Meeting Invitation'), $data);
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
        $meeting = $client->getSituation(__('Meeting Invitation'));
        if($meeting != null) {
            $date = $meeting->getData()['meeting_date'];
            return view('clients.confirm', ['client' => $client, 'date' => (new DateTime($date))->format('Y-m-d')]);
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
        $situation = $client->getSituation(__('Meeting Date Confirmation'));
        if($situation == null) {
            $client->addSituationByData(__('Meeting Date Confirmation'), $data);
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
            $data['status'] = 6;

        } else {
            $data['decision'] = false;
            $client->setData(['status' => 7]);
            $data['status'] = 7;
        }

        $situation = $client->getSituation(__('Decision'));
        if($situation == null) {
            $client->addSituationByData(__('Decision'), $data);
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

        $data['status'] = 8;

        // Create the situation.
        $client->addSituationByData(__('Room Assignment'), $data);

        // Shift status up.
        $client->setData(['status' => 8]);

        // TODO: Notify client per e-mail.

        return redirect(route('clients.show', $id));
    }

    public function assignContractDate($id) {
        $client = Client::find($id);
        return view('clients.assigncontractdate', ['client' => $client]);
    }

    public function assignedContractDate(Request $request, $id) {

        $client = Client::find($id);
        $data = $request->post();

        $client->setData(['status' => 9]);
        $data['status'] = 9;

        $situacija = $client->getSituation(__('Contract Signing Invitation'));
        if($situacija == null) {
            $client->addSituationByData(__('Contract Signing Invitation'), $data);
        }

        // TODO: Inform the client, send a mail.

        return redirect(route('clients.show', $id));

    }

    public function confirmContractDate($id) {
        $client = Client::find($id);
        $meeting = $client->getSituation(__('Contract Signing Invitation'));
        if($meeting != null) {
            $date = $meeting->getData()['meeting_date'];
            return view('clients.confirmContractDate', ['client' => $client, 'date' => $date]);
        }

        return view('clients.confirmContractDate', ['client' => $client]);
    }

    public function confirmedContractDate(Request $request, $id) {
        $client = Client::find($id);
        $data = $request->post();

        // Change status and save changes.
        $data['status'] = 10;
        $client->setData($data);

        // Create situation
        $situation = $client->getSituation(__('Contract Signing Date Confirmation'));
        if($situation == null) {
            $client->addSituationByData(__('Contract Signing Date Confirmation'), $data);
        }

        // TODO: Notify the client via email.

        return redirect(route('clients.show', $id));
    }

    /**
     * Shows the contract of the given client.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showContract(Request $request, $id) {
        $client = Client::find($id);
        $contract = $client->getContracts()->first();
        $request->session()->put('backroute', route('clients.show', $id));
        $situations = $contract->getSituations();
        return view('contracts.show', ['model' => $contract, 'situations' => $situations, 'client' => $client]);

    }
}
