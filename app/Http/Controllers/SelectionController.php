<?php

namespace App\Http\Controllers;

use App\Business\Selection;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function update(Request $request, $id): array
    {
        $data = $request->post();

        $selection = new Selection(['instance_id' => $id]);
        $selection->setData($data);
        return [
            'code' => 0,
            'message' => 'Selection changed successfully'
        ];
    }
}
