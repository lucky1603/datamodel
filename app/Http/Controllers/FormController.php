<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\RaisingStartsProgram;
use App\Business\IncubationProgram;

class FormController extends Controller
{
    public function showRaisingStarts() {
        $attributeData = RaisingStartsProgram::getAttributesDefinition();

        return view('forms.show-raisingstarts', ['attributes' => $attributeData['attributes'], 'mode' => "administrator"]);
    }

    public function showIncubation() {
        $attributeData = IncubationProgram::getAttributesDefinition();
        return view('forms.show-incubation', ['attributes' => $attributeData['attributes'], 'attributeGroups' => $attributeData['attributeGroups'], 'mode' => 'administrator']);
    }

    public function showRastuce() {
        return view('forms.rastuce');
    }

    public function showForms() {
        return view('forms.show-forms');
    }
}
