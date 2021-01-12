<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder;

class Training extends BusinessModel
{

    /**
     * Removes the element instance from the database.
     */
    public function delete() {
        $this->instance->delete();
    }

    /**
     *
     * Returns the attributes of the 'traninng' entity.
     *
     * @return Collection
     */
    public static function getAttributesDefinition() : Collection {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['training_name', 'Naziv obuke', 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['training_description', 'Opis obuke', 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['training_start_date', 'Datum početka', 'datetime', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['training_start_time', 'Vreme početka', 'timestamp', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['training_duration', 'Trajanje treninga', 'integer', NULL, 5]));

        $duration = self::selectOrCreateAttribute(['duration_unit', 'Jedinica trajanja treninga', 'select', NULL, 6]);
        if(count($duration->getOptions()) == 0) {
            $duration->addOption(['value' => 1, 'text' => 'min']);
            $duration->addOption(['value' => 2, 'text' => 'h']);
            $duration->addOption(['value' => 3, 'text' => 'd']);
        }

        $attributes->add($duration);
        $attributes->add(self::selectOrCreateAttribute(['lecturer_name', 'Ime predavača', 'varchar', NULL, 7]));
        $attributes->add(self::selectOrCreateAttribute(['training_short_note', 'Kratka beleška', 'text', NULL, 8]));

        $training_type = self::selectOrCreateAttribute(['training_type', 'Tip obuke', 'select', NULL, 9]);
        if(count($training_type->getOptions()) == 0) {
            $training_type->addOption(['value' => 1, 'text' => 'Mentorska sesija']);
            $training_type->addOption(['value' => 2, 'text' => 'Radionica']);
            $training_type->addOption(['value' => 3, 'text' => 'Događaj']);
        }

        $attributes->add($training_type);

        $attributes->add(self::selectOrCreateAttribute(['location', 'Mesto održavanja', 'varchar', NULL, 10]));
        $attributes->add(self::selectOrCreateAttribute(['training_host', 'Moderator', 'varchar', NULL, 11]));
        $attributes->add(self::selectOrCreateAttribute(['interests', "Oblasti interesovanja", 'select', null, 200]));

        return $attributes;

    }

    /**
     *
     * Returns the object or the collection of objects searched for,
     * depending on the input query.
     *
     * @param null $query
     * @return Training|Collection|null
     */
    public static function find($query=null) {

        if(Entity::where('name', 'Training')->get()->count() == 0) {
            return isset($query) && is_string($query) ? null : collect([]);
        }

        // If it's empty.
        if(!isset($query)) {
            $entity_id = Entity::where('name', 'Training')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            return $instances->map(function($instance) {
                return new Training(['instance_id' => $instance->id]);
            });
        }

        // If it's id.
        if(!is_array($query)) {
            $entity_id = Entity::whereName('Training')->first()->id;
            $instance = Instance::where(['id' => $query, 'entity_id' => $entity_id])->first();
            if($instance == null)
                return null;

            return new Training(['instance_id' => $instance->id]);
        }

        // If it's array.
        foreach($query as $key => $value) {

            $attribute = Attribute::where('name', $key)->first();
            $tableName = $attribute->type.'_values';
            $temporary_results = DB::table($tableName)->select('instance_id')->where(['value' => $value, 'attribute_id' => $attribute->id])->get();

            if(!isset($results)) {
                $results = $temporary_results;
            } else {
                $results = $temporary_results->intersect($results);
            }

            if($results->count() === 0) {
                return $results;
            }

        }

        if(isset($results)) {
            return $results->map(function($item, $key) {
                return new Training(['instance_id' => $item->instance_id]);
            });
        }

        return collect([]);
    }

    /**
     *
     * Return all trainings.
     *
     * @return Training||null
     */
    public static function all() {
        return Training::find();
    }

    /**
     *
     * Gets the corresponding entity object.
     *
     * @return Entity
     */
    protected function getEntity(): Entity
    {
        $entity = Entity::where('name', 'Training')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Training', 'description' => 'The training event - could be workshop, menthor session, training etc.']);

            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     *
     * Return all clients connected with the training (invited|present|absent)
     *
     * @return Collection
     */
    public function getClients() {
        $client_ids = DB::table('client_training')->where('training_id', $this->instance->id)->pluck('client_id');
        return $client_ids->map(function($clientId) {
            return new ClientAtTraining($clientId, $this->instance->id);
        });
    }

    /**
     *
     * Adds the client to the training session.
     *
     * @param Client $client
     * @return bool
     */
    public function addClient(Client $client) {
        if(DB::table('client_training')->where([
            'client_id' => $client->getId(),
            'training_id' => $this->instance->id
        ])->count() == 0) {
            return DB::table('client_training')->insert([
                'client_id' => $client->getId(),
                'training_id' => $this->instance->id
            ]);
        }

        return false;
    }

    /**
     *
     * Updates client with the batch of data.
     *
     * @param Client $client
     * @param array $data
     * @return int
     */
    public function updateClient(Client $client, Array $data) {
        return DB::table('client_training')->update($data);
    }

    /**
     *
     * Removes the client from the training.
     *
     * @param Client $client
     * @return int
     */
    public function removeClient(Client $client) {
        return DB::table('client_training')->delete([
            'client_id' => $client->getId(),
            'training_id' => $this->instance->id
        ]);
    }

    /**
     *
     * Override of parent's setData method.
     *
     * @param array $data
     */
    public function setData($data) {
        parent::setData($data);

        $counter = 1;
        while(isset($data['file_'.$counter])) {
            $attribute = $this->getAttribute('file_'.$counter);
            if($attribute == null)
            {
                $attachedFile = BusinessModel::selectOrCreateAttribute(['file_'.$counter, 'Priložena datoteka '.$counter, 'file', 200 + $counter]);
                $this->addAttribute($attachedFile);
                $attribute = $this->getAttribute('file_'.$counter);
            }

            $attribute->setValue($data['file_'.$counter++]);
        }

    }

    public function hasFiles() {
        if($this->getAttribute('file_1') == null)
            return false;

        return true;
    }

    /**
     *
     * Sets the attribute values from the data buffer.
     *
     */
    protected function setAttributes()
    {
        $this->getAttribute('training_name')->setValue(isset($this->data['training_name']) ? $this->data['training_name'] : null);
        $this->getAttribute('training_description')->setValue(isset($this->data['training_description']) ? $this->data['training_description'] : null);
        $this->getAttribute('training_start_date')->setValue(isset($this->data['training_start_date']) ? $this->data['training_start_date'] : null);
        $this->getAttribute('training_start_time')->setValue(isset($this->data['training_start_time']) ? $this->data['training_start_time'] : null);
        $this->getAttribute('training_duration')->setValue(isset($this->data['training_duration']) ? $this->data['training_duration'] : null);
        $this->getAttribute('duration_unit')->setValue(isset($this->data['duration_unit']) ? $this->data['duration_unit'] : 1);
        $this->getAttribute('lecturer_name')->setValue(isset($this->data['lecturer_name']) ? $this->data['lecturer_name'] : null);
        $this->getAttribute('training_short_note')->setValue(isset($this->data['training_short_note']) ? $this->data['training_short_note'] : null);
        $this->getAttribute('training_type')->setValue(isset($this->data['training_type']) ? $this->data['training_type'] : 1);
        $this->getAttribute('interests')->setValue(isset($this->data['interests']) ? $this->data['interests'] : 0);

    }

}
