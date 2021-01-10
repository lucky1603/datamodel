<?php


namespace App\Http\Controllers;


use App\Business\Client;
use App\Business\Training;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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

    public function delete($id) {
        $training = Training::find($id);
        if($training != null) {
            $training->delete();
        }

        return redirect(route('trainings'));
    }
}
