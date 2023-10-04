<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Models\Letter;
use App\Models\WorkFlowStep;
use Illuminate\Http\Request;

class StepWorkFlowController extends Controller
{
    

    public function show($id){
        $originator = Letter::where('id', $id)->first();
        if (!$originator) {
            return response()->json(['message' => 'Letter not found'], 404);
        }
        return $originator;
    }

    public function store(Request $request)
    {
        $originator = new WorkFlowStep();
        $originator->fill($request->all())->save();
        return $originator;
    }

    public function update(Request $request, $id)
    {
        $originator = WorkFlowStep::where('id', $id)->first();
        if (!$originator) {
            return response()->json(['message' => 'WorkFlowStep not found'], 404);
        }
        $originator->fill($request->all())->update();
        return $originator;
    }
}