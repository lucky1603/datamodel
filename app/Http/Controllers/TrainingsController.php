<?php


namespace App\Http\Controllers;


use App\Business\Attendance;
use App\Business\Client;
use App\Business\ClientAtTraining;
use App\Business\Program;
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
use Illuminate\Support\Facades\Route;
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

    public function mine() {
        $user = Auth::user();
        if($user->isAdmin()) {
            return Response::deny("This action is not for admin!");
        }

        $profile = $user->profile();
        $trainings = $profile->getTrainings();

        return view('trainings.mine', ['trainings' => $trainings, 'model' => $profile]);
    }

    public function update(Request $request, $id) {
        $data = $request->post();

        $training = Training::find($id);
        $training->setValue('event_status', $data['event_status']);
        $attendances = $training->getAttendances();
        for($i = 0; $i < $attendances->count(); $i++) {
            $id = $data['attids'][$i];
            $attendance = $attendances->filter(function($att) use($id) {
                if($att->getId() == $id)
                    return true;
                return false;
            })->first();
            $attendance->setValue('attendance', $data['attendances'][$i]);
        }

        return redirect(route('trainings'));
    }

    /**
     *
     * Calls the creation form for the new session.
     *
     * @return Application|Factory|View
     */
    public function create() {
        $token = csrf_token();
        return view('trainings.create1', ['token' => $token]);
    }

    /**
     *
     * Validates and enters the data filled up in the creation form.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request) {

        $request->validate([
            'training_name' => 'required|max:255',
            'training_start_date' => 'required',
            'training_start_time' => 'required',
            'training_duration' => 'required',
            'location' => 'required',
            'training_host' => 'required',
            'candidate' => 'required'
        ]);

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

        // Add attendances.
        $attendanceIds = $data['candidate'];

        $filteredPrograms = Program::find()->filter(function($program) use ($attendanceIds) {
            if(in_array($program->getId(), $attendanceIds))
                return true;
            return false;
        });

        foreach ($filteredPrograms as $filteredProgram) {
            if(in_array($filteredProgram->getId(), $attendanceIds)) {
                $attendance = new Attendance();
                $attendance->setData([
                    'attendance' => 1,
                    'has_client_feedback' => false,
                    'client_feedback' => null
                ]);

                $filteredProgram->addAttendance($attendance);
                $training->addAttendance($attendance);
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
            $attendances = $training->getAttendances();
            $attendances->each(function($attendance) use($training) {
                $training->removeAttendance($attendance);
                $attendance->delete();
            });

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
        $backroute = Route::currentRouteName();
        if($user->isAdmin()) {
            return view('trainings.show', ['training' => $training, 'backroute' => $backroute]);
        } else {

            $profile = $user->profile();
            return view('trainings.show', ['training' => $training, 'profile' => $profile, 'backroute' => $backroute]);
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

    public function filter(Request $request): array
    {
        $events = Training::find();
        $resultData = [];
        foreach ($events as $event) {
            $data = $event->getData();
            $resultData[] = [
                "id" => $data['id'],
                'name' => $data['training_name'],
                'date' => date('d.m.Y', strtotime($data['training_start_date'])),
                'type' => $data['training_type'],
                'status' => $data['event_status'],
                'location' => $data['location']
            ];
        }

        return $resultData;
    }

}
