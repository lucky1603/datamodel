<?php

namespace App\Http\Controllers;

use App\Business\AppFormEvaluation;
use Illuminate\Http\Request;

class AppFormEvaluationController extends Controller
{
    public function update(Request $request, $id) {
        $data = $request->post();
        $appeval = new AppFormEvaluation(['instance_id' => $id]);

        $appeval->setData($data);

        return [
            'code' => 0,
            'message' => 'DemoDay updated successfully',
        ];
    }
}
