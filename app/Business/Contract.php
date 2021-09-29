<?php


namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class Contract extends BusinessModel
{



    /**
     * Returns the program the contract belongs to.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $programInstance = $this->instance->parentInstances()->first();
        if($programInstance == null)
            return null;

        return new Program(0,['instance_id' => $programInstance->id]);
    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null) {
        if($data == null) {
            $data = [
                'contract_number' => null,
                'amount' => 0,
                'currency' => 'RSD',
                'contract_subject' => null,
                'signed_at' => null,
                'validity' => 0,
                'validity_unit' => 0,
                'contract_document' => [
                    'filelink' => '',
                    'filename' => ''
                ]
            ];
        }

        $this->setData($data);
    }

    /**
     * Gets template.
     * @return mixed
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Contract')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Contract', 'description' => 'The document that bounds two or more parties.']);
        }

        return $entity;
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['contract_number', 'Br. Ugovora', 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['amount', 'Iznos', 'double', NULL, 2]));

        $currency = self::selectOrCreateAttribute(['currency', 'Valuta', 'varchar', NULL, 3]);
        if(count($currency->getOptions()) == 0) {
            $currency->addOption(['value' => 1, 'text' => 'RSD']);
            $currency->addOption(['value' => 2, 'text' => 'EUR']);
            $currency->addOption(['value' => 3, 'text' => 'USD']);
        }
        $attributes->add($currency);

        $attributes->add(self::selectOrCreateAttribute(['contract_subject', 'Predmet ugovora', 'text', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['signed_at', 'Potpisan dana', 'datetime', NULL, 5]));
        $attributes->add(self::selectOrCreateAttribute(['duration', 'Trajanje ugovora', 'integer', NULL, 6]));

        $validity_unit = self::selectOrCreateAttribute(['duration_unit', 'Jedinica trajanja ugovora', 'select', NULL, 7]);
        if(count($validity_unit->getOptions()) == 0) {
            $validity_unit->addOption(['value' => 1, 'text' => __('day/days')]);
            $validity_unit->addOption(['value' => 2, 'text' => __('month/months')]);
            $validity_unit->addOption(['value' => 3, 'text' => __('year/years')]);
        }
        $attributes->add($validity_unit);

        $attributes->add(self::selectOrCreateAttribute(['contract_document', 'Dokument ugovora', 'file', NULL, 8]));

        return $attributes;

    }

}
