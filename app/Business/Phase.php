<?php

namespace App\Business;

interface Phase
{
    public function getId();
    public function getDisplayName();
    public function getDisplayId();
    public function getUI();
    public function getAttributesData();
    public function getStatusValue();
    public function setStatusValue($value);
}
