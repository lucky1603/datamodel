<?php


namespace App\Business;


use Illuminate\Support\Facades\DB;

class ClientAtTraining extends Client
{
    public $attendance;
    public $training_id;
    public $has_feedback;
    public $feedback;

    /**
     *
     * ClientAtTraining constructor.
     *
     * @param $client_id
     * @param $training_id
     */
    public function __construct($client_id, $training_id) {
        parent::__construct(['instance_id' => $client_id]);
        $this->training_id = $training_id;
        $this->_getAttributes();
    }

    /**
     *
     * Saves the changes
     *
     */
    public function save() {
        return $this->_setAttributes();
    }

    public function getAttendanceText() {
        switch ($this->attendance) {
            case 1:
                return __('Notified');
            case 2:
                return __('Applied');
            case 3:
                return __('Showed Up');
            default:
                return __("Didn't show up");
        }
    }


    /**
     *
     * Reads the attributes from the database.
     *
     */
    private function _getAttributes() {
        $clientAtTraining = DB::table('client_training')->where([
            'client_id' => $this->instance->id,
            'training_id' => $this->training_id
        ])->first();

        if($clientAtTraining != null) {
            $this->has_feedback = $clientAtTraining->has_client_feedback;
            $this->feedback = $clientAtTraining->client_feedback;
            $this->attendance = $clientAtTraining->attendance;
        }
    }


    /**
     *
     * Persists the object properties to the database.
     *
     * @return int
     */
    private function _setAttributes() {
        return DB::table('client_training')
            ->where([
                'client_id' => $this->instance->id,
                'training_id' => $this->training_id
            ])
            ->update([
                'has_client_feedback' => $this->has_feedback,
                'client_feedback' => $this->feedback,
                'attendance' => $this->attendance
            ]);
    }


}
