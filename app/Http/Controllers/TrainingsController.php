<?php


namespace App\Http\Controllers;


use App\Business\Client;
use App\Business\ClientAtTraining;
use App\Business\Training;
use App\Business\TrainingForClient;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingsController extends Controller
{
    /**
     *
     * Lists all sessions.
     *
     * @return Application|Factory|View
     */
    public function index() {
        $trainings = Training::all()->filter(function($training) {
            if($training->getValue('training_type') == 1 /* Exclude mentor session */)
                return false;
            return true;
        });

        return view('trainings.index', ['trainings' => $trainings]);
    }

    public function mine() {
        $user = Auth::user();
        if($user->isAdmin()) {
            return Response::deny("This action is not for admin!");
        }

        $profile = $user->profile();
        $trainings = $profile->getTrainings();

        return view('trainings.mine', ['trainings' => $trainings, 'model' => $profile]);
    }

    /**
     *
     * Calls the creation form for the new session.
     *
     * @return Application|Factory|View
     */
    public function create() {
        return view('trainings.create');
    }

    /**
     *
     * Validates and enters the data filled up in the creation form.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request) {

        $data = $request->post();

        $counter = 1;
        if($request->hasFile("attachment")) {
            foreach($request->file("attachment") as $file) {
                $originalFileName = $file->getClientOriginalName();
                $path = $file->store('documents');
                $path = asset($path);
                $data['file_'.$counter++] = [
                    'filename' => $originalFileName,
                    'filelink' => $path,
                ];
            }
        }

        $training = new Training();
        $training->setData($data);
        if(isset($data['client']) && is_array($data['client'])) {
            foreach($data['client'] as $clientId) {
                $client = new Client(['instance_id' => $clientId]);
                $training->addClient($client);
            }
        }

        return redirect(route('trainings'));
    }

    /**
     *
     * Deletes the training with the given id.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete($id) {
        $training = Training::find($id);
        if($training != null) {
            $training->delete();
        }

        return redirect(route('trainings'));
    }

    /**
     *
     * Shows the preview of the training details.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id) {
        $training = Training::find($id);
        $user = Auth::user();
        if($user->isAdmin()) {
            return view('trainings.show', ['training' => $training]);
        } else {
            $client = $user->client();
            return view('trainings.show', ['training' => $training, 'client' => $client]);
        }

    }

    /**
     *
     * Show one of mine trainings.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function showMine($id) {
        $training = Training::find($id);
        return view('trainings.showmine', ['training' => $training]);
    }

    /**
     *
     * [POST] Signs up for the event.
     * @param Request $request
     * @return array
     */
    public function signUp(Request $request): array
    {
        $data = $request->post();

        $training = Training::find($data['training_id']);
        $client = Client::find($data['client_id']);

        if(!$training->hasClient($client)) {
            $training->addClient($client);
            return [
                'success' => true,
                'message' => 'You have successfully signed up for the training!',
                'goto' => route('trainings.forme')
            ];
        }

        return [
            'success' => false,
            'message' => "You have already signed up for the session!",
            'goto' => route('trainings.forme')
        ];

    }
}
