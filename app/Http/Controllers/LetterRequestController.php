<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Models\ActivityLogs;
use App\Models\LetterRequest;
use App\Models\WorkFlowStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LetterRequestController extends Controller
{
    public function index(Request $r)
    {
        $lr = new LetterRequest();
        $searchQuery = $r->input("q", "");
        $uniqueField = $r->input('org', "");

        if ($searchQuery != "") {
            $lr = $lr->where(function ($query) use ($searchQuery) {
                $query->orWhere('content', 'like', $searchQuery . "%");
                $query->orWhere('id', '=',  $searchQuery);
            });
        }

        if ($uniqueField) {
            return LetterRequest::where('org_id', $uniqueField)->get();
        }

        return $lr->take(100)->get();
    }

    public function show($id)
    {
        $lr = LetterRequest::where('id', $id)->first();
        if (!$lr) {
            return response()->json(['message' => 'LetterRequest not found'], 404);
        }
        return $lr;
    }

    public function store(Request $request)
    {
        $lr = new LetterRequest();
        $lr->fill($request->all())->save();
        return $lr;
    }

    public function update(Request $request, $id)
    {
        $lr = LetterRequest::where('id', $id)->first();
        if (!$lr) {
            return response()->json(['message' => 'LetterRequest not found'], 404);
        }
        $lr->fill($request->all())->update();
        return $lr;
    }

    public function destroy($id)
    {
        $lr = LetterRequest::where('id', $id)->first();
        if (!$lr) {
            return response()->json(['message' => 'LetterRequest not found'], 404);
        }
        $lr->delete();
        return $lr;
    }

    public function processRequestAction(Request $r, $rId)
    {

        $lr = LetterRequest::where('id', $rId)->first();
        if (!$lr) {
            return response()->json(['message' => 'LetterRequest not found'], 404);
        }

        $step = WorkFlowStep::where('id', $lr->workflow_step)->first();
        $user = $r->user();

        //check user Permision on specific action 
        
        if ($user->hasPermissionTo($step->actions)) {

            // update the current process request, set it current step from next step
            $currentStep = WorkFlowStep::where('id', $lr->workflow_step)->first();
            $lr->workflow_step = $currentStep->next_step;
            $lr->update();

            // log the activity 
            $activityLog = new ActivityLogs();
            $activityLog->action_type = $step->actions;
            $activityLog->detail = "the request processed by it's authorized one using it's workflow";
            $activityLog->generated_by = $user->id;
        }
        return response()->json(['message' => 'No sufficient permission'], 403);
    }
}
