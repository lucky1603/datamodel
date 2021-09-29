<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class TeamMember extends BusinessModel
{
    /**
     * Return the program this team member belongs to.
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
     * Returns the attributes collection for this type of entity and this instance.
     * @return Collection
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['team_member_name', 'Ime člana tima', 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['team_education', 'Obrazovanje i iskustvo', 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['team_role', 'Uloga u razvoju startapa', 'text', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['team_other_job', 'Drugi posao', 'text', NULL, 4]));

        return $attributes;
    }

    /**
     * Gets the entity of this instance.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'TeamMember')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'TeamMember', 'description' => 'Član tima']);
        }

        return $entity;
    }

    /**
     * Sets the initial attribute values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'team_member_name' => null,
                'team_education' => null,
                'team_role' => null,
                'team_other_job' => null,
            ];
        }

        $this->setData($data);
    }


}
