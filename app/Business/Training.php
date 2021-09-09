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
     * Gets the corresponding entity object.
     *
     * @return Entity
     */
    protected function getEntity(): Entity
    {
        $entity = Entity::where('name', 'Training')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Training', 'description' => 'The training event - could be workshop, mentor session, training etc.']);

            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
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

    /**
     * Returns the answer if the traning has the files attached.
     * @return bool
     */
    public function hasFiles(): bool
    {
        if($this->getAttribute('file_1') == null)
            return false;

        return true;
    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        $this->getAttribute('training_name')->setValue($data['training_name'] ?? null);
        $this->getAttribute('training_description')->setValue($data['training_description'] ?? null);
        $this->getAttribute('training_start_date')->setValue($data['training_start_date'] ?? null);
        $this->getAttribute('training_start_time')->setValue($data['training_start_time'] ?? null);
        $this->getAttribute('training_duration')->setValue($data['training_duration'] ?? null);
        $this->getAttribute('duration_unit')->setValue($data['duration_unit'] ?? 1);
        $this->getAttribute('lecturer_name')->setValue($data['lecturer_name'] ?? null);
        $this->getAttribute('training_short_note')->setValue($data['training_short_note'] ?? null);
        $this->getAttribute('training_type')->setValue($data['training_type'] ?? 1);
        $this->getAttribute('interests')->setValue($data['interests'] ?? 0);

    }

    /**
     * Adds the attendance object.
     * @param $attendance
     * @return mixed
     */
    public function addAttendance($attendance) {
        $this->instance->instances()->save($attendance->instance);
        $this->instance->refresh();
        return $attendance;
    }

    /**
     * Removes the attendance object from training.+
     * @param $attendance
     */
    public function removeAttendance($attendance) {
        $this->instance->instances()->detach($attendance);
        $this->instance->refresh();
    }

    /**
     * Returns attendances for this object.
     * @return mixed
     */
    public function getAttendances() {
        return $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'Attendance')
                return true;
        })->map(function($instance) {
            return new Attendance(['instance_id' => $instance->id]);
        });
    }


}
