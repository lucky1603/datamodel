<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class Founder extends BusinessModel
{

    /**
     *
     * @return mixed
     */
    public function getProgram() {
        $programInstance = $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Program')
                return true;
            return false;
        })->first();

        return new Program(0, ['instance_id' => $programInstance->id]);
    }

    /**
     * Returns the collection of attributes for this entity and instance.
     * @return Collection
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);
        $attributes->add(self::selectOrCreateAttribute(['founder_name', 'Ime osnivača', 'varchar' , NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['founder_part', 'Udeo [%]', 'double' , NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['founder_university', 'Fakultet', 'varchar' , NULL, 3]));

        return $attributes;
    }

    /**
     * Sets the default attribute values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'founder_name' => null,
                'founder_part' => 0.0,
                'founder_university' => null
            ];
        }

        $this->setData($data);
    }

    /**
     * Returns the entity of this instance.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Founder')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Founder', 'description' => 'Osnivač']);
        }

        return $entity;
    }
}
