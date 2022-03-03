<?php


namespace App\Http\Controllers;


use App\Business\Attendance;
use App\Business\Client;
use App\Business\ClientAtTraining;
use App\Business\Program;
use App\Business\ProgramFactory;
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

    public function edit($id) {
        $token = csrf_token();
        return view('trainings.edit', ['event_id' => $id, 'token' => $token]);

    }

    public function update(Request $request, $id) {
        $request->validate([
            'training_name' => 'required|max:255',
            'training_start_date' => 'required',
            'training_start_time' => 'required',
            'training_duration' => 'required',
            'location' => 'required',
            'training_host' => 'required',
//            'candidate' => 'required'
        ]);

        $data = $request->post();
        $files = Utils::getFilesFromRequest($request, 'files');
        if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
            $data['files'] = $files;
        }


        $training = Training::find($id);

        $training->setData($data);

        // Add attendances.
        if(isset($data['candidate'])) {
            $attendanceIds = collect($data['candidate']);
        } else {
            $attendanceIds = collect([]);
        }

        // Remove non desired attendance entries.
        $training->getAttendances()->filter(function($attendance) use($attendanceIds) {
            $program = $attendance->getProgram();
            return !$attendanceIds->contains($program->getId());
        })->each(function($attendance) use($training) {
            $program = $attendance->getProgram();
            $program->removeAttendance($attendance);
            $training->removeAttendance($attendance);
            $attendance->delete();
        });

        // Add the new ones.

        // Get the existing valid ids;
        $validIds = $training->getAttendances()->map(function($attendance) {
            return $attendance->getProgram()->getId();
        });

        $attendanceIds->filter(function($programId) use($validIds) {
            return !$validIds->contains($programId);
        })->each(function($programId) use($training) {
            $program = Program::find($programId);
            $attendance = new Attendance([
                'attendance' => 1,
                'has_client_feedback' => false,
                'client_feedback' => null
            ]);

            $program->addAttendance($attendance);
            $training->addAttendance($attendance);
        });

        return redirect(route('trainings.show', ['training' => $id]));
    }

    public function updateAttendances(Request $request, $id) {
        $data = $request->post();
        var_dump($data);

        $training = Training::find($id);
        $training->setValue('event_status', $data['event_status']);
        $attendances = $training->getAttendances();

        $itt_count = min($attendances->count(), count($data['attids']));

        for($i = 0; $i < $itt_count; $i++) {
            $id = $data['attids'][$i];
            $attendance = $attendances->filter(function($att) use($id) {
                return $att->getId() == $id;
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
//            'candidate' => 'required'
        ]);

        $data = $request->post();
        $data['files'] = Utils::getFilesFromRequest($request, 'attachment');

        $training = new Training();
        $training->setData($data);

        // Add attendances.
        if(isset($data['candidate'])) {
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
            return view('trainings.show1', ['training' => $training, 'backroute' => route('trainings')]);
        } else {
            $profile = $user->profile();
            return view('trainings.show1', ['training' => $training, 'profile' => $profile, 'backroute' => route('profiles.trainings', ['profile' => $profile->getId()])]);
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
        $data = $request->post();
        $filterData = [];
        if($data['name'] != NULL) {
            $filterData['training_name'] = $data['name'];
        }

        if($data['eventType'] != 0) {
            $filterData['training_type'] = $data['eventType'];
        }

        if(isset($data['eventStatus']) && $data['eventStatus'] != 0) {
            $filterData['event_status'] = $data['eventStatus'];
        }

        if(count($filterData) > 0) {
            $events = Training::find($filterData);
        } else {
            $events = Training::find();
        }

        $resultData = [];
        foreach ($events as $event) {
            $data = $event->getData();
            $resultData[] = [
                "id" => $data['id'],
                'name' => $data['training_name'],
                'date' => $event->getText('training_start_date'),
                'type' => $data['training_type'],
                'status' => $data['event_status'],
                'location' => $data['location'],
                'description' => $data['training_short_note'],
                'time' => $event->getText('training_start_time'),
                'duration' => $data['training_duration'],
                'durationUnit' => $event->getText('training_duration_unit'),
            ];
        }

        return $resultData;
    }

    public function fetch($trainingId): array
    {
        $training = Training::find($trainingId);
        $data = $training->getData();
        $data['training_start_time'] = $training->getText('training_start_time');
        return [
            'attributes' => $data,
            'attendances' => $training->getAttendances()->map(function($attendance) {
                return $attendance->getProgram()->getId();
            })
        ];
    }

    public function get($trainingId): array
    {
        $training = Training::find($trainingId);

        $data = $training->getData();
        $data['training_start_time'] = $training->getText('training_start_time');
        $data['training_start_date'] = $training->getText('training_start_date');
        $data['training_duration_unit'] = $training->getText('training_duration_unit');
        $attendanceData = [];
        $attendances = $training->getAttendances();
        foreach($attendances as $attendance) {
            $attendanceData[] = [
                'id' => $attendance->getId(),
                'company' => $attendance->getProgram()->getProfile()->getValue('name'),
                'status' => $attendance->getValue('attendance')
            ];
        }

        return [
            'attributes' => $data,
            'attendances' => $attendanceData
        ];
    }

    public function getAttendance($trainingId, $programId) {
        $training = Training::find($trainingId);
        return $training->getAttendanceForProgram($programId);
    }

}
