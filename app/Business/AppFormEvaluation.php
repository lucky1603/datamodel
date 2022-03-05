<?php

namespace App\Business;

use App\Entity;
use App\Mail\CustomMessage;
use Illuminate\Support\Collection;

class AppFormEvaluation extends PhaseImpl
{

    private $status = -1;

    protected function getEntity()
    {
        $entity = Entity::where('name', 'AppFormEvaluation')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'AppFormEvaluation', 'description' => __('Ocena prijave')]);
        }

        return $entity;
    }

    public function getDisplayName(): string
    {
        return 'Ocena prijave';
    }

    public function getDisplayId(): string
    {
        return '#applicationEval';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._app_eval-form';
    }

    public function getClientDisplayForm(): string
    {
        return 'profiles.forms._app_eval_client-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'model' => $this,
            'profile' => $this->getWorkflow()->getProgram()->getProfile()->getId()
        ];
    }

    public function getStatusValue(): int
    {
        return $this->status;
    }

    public function setStatusValue($value)
    {
        $this->status = $value;
    }

    public function requiresExitEmail(): bool
    {
        return false;
    }

    public function getExitEmailTemplate(): CustomMessage
    {
        // TODO: Implement getExitEmailTemplate() method.
        $program = $this->getWorkflow()->getProgram();

        $poruka = "<p>Poštovani,</p>";
        if($this->getValue('passed' ) == true) {
            $poruka .= "<p>Zadovoljstvo nam je da Vam saopštimo da je Vaša prijava na program ";
            $poruka .= "<strong>".$program->getValue('program_name')."</strong>";
            $poruka .= " je prihvaćena.<br />";
            $poruka .= "Redovnim prijavljivanjem na vaš <a href='https://platforma.ntpark.rs' target='_blank'>nalog</a> molimo vas da proveravate dalji status vaše prijave,";
            $poruka .= "gde ćete dobiti i dalja uputstva kako i šta dalje</p>";
        } else {
            $poruka .= "<p>Nažalost, Vaša prijava na program".$program->getValue('program_name')." nije prihvaćena. Obrazloženje možete pogledati u sledećem pasusu,";
            $poruka .= "gde je navedena napomena komisije. U vezi bilo kakvih nejasnoća, možete nas kontaktirati na <a href='mailto://info@ntpark.rs' target='_blank'> info@ntpark.rs</a>.";
        }

        // If note exists.
        if($this->getValue('note') != '') {
            $poruka .= "<p><strong>OBRAZLOŽENJE</strong></p>";
            $poruka .= "<p>".$this->getValue('note')."</p>";
        }

        $poruka .= "<p>NTP tim</p>";

        return new CustomMessage($poruka);
    }

    public function requiresExitSituation(): bool
    {
        return true;
    }

    public function getExitSituation(): ?Situation
    {
        if($this->getValue('passed') == 'true') {
            return new Situation([
                'name' => 'Prijava prihvaćena',
                'description' => 'Komisija je, na osnovu podataka u prijavi, prihvatila prijavu na program',
                'sender' => 'NTP'
            ]);
        }

        $exitSituation = new Situation([
            'name' => 'Prijava odbijena',
            'description' => 'Komisija je, na osnovu podataka iz prijavi, procenila da nema dovoljno elemenata za učestvovanje u programu',
            'sender' => 'NTP'
        ]);

        $exitSituation->addAttribute(self::selectOrCreateAttribute(['note', NULL, NULL, NULL, 0]));
        $exitSituation->setValue('note', $this->getValue('note'));

        return $exitSituation;

    }

    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'passed' => false,
                'assertion_date' => now(),
                'note' => null,
            ];
        }
        parent::setAttributes($data); // TODO: Change the autogenerated stub
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['assertion_date', __("Assertion Date"), 'datetime', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['note', __('Note'), 'text', NULL, 3]));

        return $attributes;
    }

    public function isVisibleInHistory(): bool
    {
        return false;
    }
}
