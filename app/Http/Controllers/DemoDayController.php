<?php

namespace App\Http\Controllers;

use App\Business\DemoDay;
use Illuminate\Http\Request;

class DemoDayController extends Controller
{
    public function update(Request $request): array
    {
        $data = $request->post();

        $demoday = new DemoDay(['instance_id' => $data['id']]);
        if($demoday->instance == null) {
            return [
                'code' => 1,
                'message' => 'No demo day with id' .$data['id'],
            ];
        }

        $demoday->setData($data);
        return [
            'code' => 0,
            'message' => 'DemoDay updated successfully',
        ];
    }
}
