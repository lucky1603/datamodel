<?php

namespace App\Business;

use Illuminate\Mail\Mailable;

interface Phase
{
    public function getId();
    public function getDisplayName();
    public function getDisplayId();
    public function getDisplayForm();
    public function getClientDisplayForm();
    public function getAttributesData();
    public function getStatusValue();
    public function setStatusValue($value);
    public function requiresEntryEmail():bool;
    public function getEntryEmailTemplate();
    public function requiresExitEmail():bool;
    public function getExitEmailTemplate();
    public function requiresEntrySituation();
    public function getEntrySituation();
    public function requiresExitSituation();
    public function getExitSituation();
    public function isVisibleInHistory();
    public function isValid();
    public function validateData(Array $data);
}
