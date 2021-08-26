<?php

namespace App\Http\Controllers;

use App\Business\Preselection;
use Illuminate\Http\Request;

class PreselectionController extends Controller
{
    public function update(Request $request, $id): array
    {
        $data = $request->post();
        $preselection = new Preselection(['instance_id' => $id]);
        $preselection->setData($data);
        return [
            'code' => 0,
            'message' => 'Preselection changed successfully'
        ];
    }


}
