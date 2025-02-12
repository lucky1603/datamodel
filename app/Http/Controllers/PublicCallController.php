<?php

namespace App\Http\Controllers;

use App\PublicCall;
use Illuminate\Http\Request;

class PublicCallController extends Controller
{
    public function list() {
        return PublicCall::all();
    }

    public function update(Request $request) {
        
        $request->validate([
            'unlock' => 'required'
        ]);

        $data = $request->post();

        $call = PublicCall::find($data['id']);        

        if($call != null) {
            $call->active = $data['unlock'];
            if(isset($data['start']) && !in_array($data['start'], ['undefined', 'null'])) {
                $call->public_call_date = $data['start'];
            } else {
                $call->public_call_date = null;
            }

            if(isset($data['end']) && !in_array($data['end'], ['undefined', 'null'])) {
                $call->public_call_end_date = $data['end'];
            } else {
                $call->public_call_end_date = null;
            }

            $call->updated_at = now();

            $call->save();
        } else {
            return [
                'code' => 1,
                'message' => "No call with that ID"
            ];
        }

        return [
            'code' => 0,
            'message' => 'Success!',
            'call' => $call
        ];
    }

    public function data($id) {
        return PublicCall::find($id);
    }
}
