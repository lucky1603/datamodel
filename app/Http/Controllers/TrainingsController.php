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
        $trainings = Training::all();
        return view('trainings.index', ['trainings' => $trainings]);
    }

    /**
     *
     * Trainings intended for me, based on my interests.
     *
     * @return Response|Application|Factory|View
     */
    public function forMe() {
        $user = Auth::user();
        if($user->isAdmin()) {
            return Response::deny("This action is not for admin!");
        }

        $client = $user->client();
        $interests = $client->getData()['interests'];
        $clientTrainings = $client->getTrainings();
        $trainings = Training::find(['interests' => $interests]);

        if($clientTrainings->count() > 0) {
            $clientTrainingIds = $clientTrainings->map(function($training, $key) {
                return $training->getId();
            });

            $trainingIds = $trainings->map(function($training, $key) {
                 return $training->getId();
            });

            $trainingIds = $trainingIds->diff($clientTrainingIds);

            $trainings = $trainingIds->map(function($training_id, $key) use ($client) {
                return new TrainingForClient($training_id, $client->getId());
            });
        }

        $output = $trainings->map(function($training, $key) {
            return $training->getData();
        });

        return view('trainings.forme', ['trainings' => $trainings, 'model' => $client]);

    }

    public function mine() {
        $user = Auth::user();
        if($user->isAdmin()) {
            return Response::deny("This action is not for admin!");
        }

        $client = $user->client();
        $trainings = $client->getTrainings();

        return view('trainings.mine', ['trainings' => $trainings, 'model' => $client]);
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
        return view('trainings.show', ['training' => $training]);
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

    public function signUp(Request $request) {
        $client = Client::find($client_id);

    }
}
