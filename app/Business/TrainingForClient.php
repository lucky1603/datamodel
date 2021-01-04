<?php


namespace App\Business;


use Illuminate\Support\Facades\DB;

class TrainingForClient extends Training
{
    public $attendance;
    public $client_id;
    public $has_feedback;
    public $feedback;

    /**
     *
     * TrainingForClient constructor.
     *
     * @param $training_id
     * @param $client_id
     */
    public function __construct($training_id, $client_id) {
        parent::__construct(['instance_id' => $training_id]);
        $this->client_id = $client_id;
        $this->_getAttributes();
    }

    /**
     *
     * Saves the object changes.
     *
     * @return int|void
     */
    public function save() {
        return $this->_setAttributes();
    }

    /**
     *
     * Updates the object properties from the database
     *
     */
    private function _getAttributes()
    {
        $trainingForClient = DB::table('client_training')->where([
            'training_id' => $this->instance->id,
            'client_id' => $this->client_id
        ])->first();

        if($trainingForClient != null) {
            $this->has_feedback = $trainingForClient->has_client_feedback;
            $this->feedback = $trainingForClient->client_feedback;
            $this->attendance = $trainingForClient->attendance;
        }
    }

    /**
     *
     * Persists the object properties to the database
     *
     * @return int
     */
    private function _setAttributes() {
        return DB::table('client_training')
            ->where([
                'training_id' => $this->instance->id,
                'client_id' => $this->client_id
            ])
            ->update([
                'has_client_feedback' => $this->has_feedback,
                'client_feedback' => $this->feedback,
                'attendance' => $this->attendance
            ]);
    }
}
