<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function index(Request $r)
    {
        $originator = new Letter();
        $searchQuery = $r->input("q", "");
        $uniqueField = $r->input('org', "");

        if ($searchQuery != "") {
            $originator = $originator->where(function ($query) use ($searchQuery) {
                $query->orWhere('content', 'like', $searchQuery . "%");
                $query->orWhere('id', '=',  $searchQuery);
            });
        }

        if ($uniqueField) {
            return Letter::where('org_id', $uniqueField)->get();
        }

        return $originator->with(['organization'])->take(100)->get();
    }

    public function show($id){
        $originator = Letter::where('id', $id)->first();
        if (!$originator) {
            return response()->json(['message' => 'Letter not found'], 404);
        }
        return $originator;
    }

    public function store(StoreLetterRequest $request)
    {
        $originator = new Letter();
        $originator->fill($request->all())->save();
        return $originator;
    }

    public function update(StoreLetterRequest $request, $id)
    {
        $originator = Letter::where('id', $id)->first();
        if (!$originator) {
            return response()->json(['message' => 'Letter not found'], 404);
        }
        $originator->fill($request->all())->update();
        return $originator;
    }

    public function destroy($id)
    {
        $originator = Letter::where('id', $id)->first();
        if (!$originator) {
            return response()->json(['message' => 'Letter not found'], 404);
        }
        $originator->delete();
        return $originator;
    }
}