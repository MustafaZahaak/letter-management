<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FileController extends Controller
{

    public function uploadFile(Request $r){

        $validator = Validator::make($r->all(), [
            'file' => 'mimes:csv,txt,jpeg|required'
        ]);

        if ($validator->fails()) {
           return response()->json($validator->errors(),422);
        }

        return ['path'=>File::saveFile($r)];
    }

    public function viewFile(Request $r){
        $file = File::where('path',$r->input('path'))->first();
        if(!$file){
            abort(404);
        }
        $path = \Illuminate\Support\Facades\Storage::path($r->input('path') );
        return response()->download($path, 'file', [], 'inline');
    }
}
