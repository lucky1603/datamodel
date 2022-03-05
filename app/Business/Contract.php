<?php


namespace App\Business;

use App\Attribute;
use App\Entity;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;

class Contract extends PhaseImpl
{

    private $status = -1;

    /**
     * Returns the program the contract belongs to.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $programInstance = $this->instance->parentInstances()->first();
        if($programInstance == null)
            return null;

        return ProgramFactory::resolve($programInstance->id);
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
            $currency->addOption(['value' => 4, 'text' => 'CHF']);
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
        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 9]));

        return $attributes;

    }

    public function getDisplayName()
    {
        return __('Contract');
    }

    public function getDisplayId(): string
    {
        return '#contract';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._contract-form';
    }

    public function getClientDisplayForm()
    {
        return 'profiles.forms._contract_client-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'profile' => $this->getWorkflow()->getProgram()->getProfile()->getId(),
            'model' => $this->getWorkflow()->getProgram()->getProfile(),
            'contract' => $this
        ];
    }

    public function getStatusValue()
    {
        return $this->status;
    }

    public function setStatusValue($value)
    {
        $this->status = $value;
    }

    public function requiresEntryEmail(): bool
    {
        return false;
    }

    public function getEntryEmailTemplate() : ?Mailable
    {
        return null;
    }

    public function requiresEntrySituation(): bool
    {
        return true;
    }

    public function getEntrySituation(): Situation
    {
        return new Situation([
            'name' => 'Potpisivanje ugovora',
            'description' => 'Klijent je pozvan na potpis ugovora',
            'sender' => 'NTP'
        ]);
    }

    public function requiresExitSituation(): bool
    {
        return true;
    }

    public function getExitSituation(): Situation
    {
        if($this->getValue('passed') == true) {
            $situation = new Situation([
                'name' => 'Potpisan ugovor',
                'description' => 'Klijent je potpisao ugovor u prostorijama NTP.',
                'sender' => 'NTP'
            ]);
        } else {
            $situation = new Situation([
                'name' => 'Ugovor nije potpisan',
                'description' => 'Iako je prethodno bilo predviđeno, klijent nije potpisao ugovor sa NTP.',
                'sender' => 'NTP'
            ]);
        }

        return $situation;
    }

    public function requiresExitEmail(): bool
    {
        return false;
    }

    public function getExitEmailTemplate() : ?Mailable
    {
        return null;
    }

    public function validateData(Array $data): array
    {
        $code = 0;
        $message = 'Podaci su validni';

        if($data['contract_number'] == null) {
            return [
                'code' => 1,
                'message' => 'Polje za broj ugovora ne može biti prazno!'
            ];
        } else {
            if(Attribute::checkValue(Entity::where('name', 'Contract')->first(), 'contract_number', $data['contract_number'])) {
                return [
                    'code' => 1,
                    'message' => 'Ugovor sa ovim brojem već postoji u bazi!'
                ];
            }
        }

        if($data['amount'] == null) {
            return [
                'code' => 1,
                'message' => 'Polje za iznos ne može biti prazno!'
            ];
        }

        if($data['currency'] == 0) {
            return [
                'code' => 1,
                'message' => 'Morate izabrati valutu!'
            ];
        }

        if($data['duration'] == null) {
            return [
                'code' => 1,
                'message' => 'Polje za trajanje ne može biti prazno!'
            ];
        }

        if($data['duration_unit'] == 0) {
            return [
                'code' => 1,
                'message' => 'Morate izabrati jedinicu trajanja!'
            ];
        }

        return [
            'code' => 0,
            'message' => "Podaci validni!"
        ];
    }
}
