<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static function saveFile($request)
    {
        $file = new File;
        $target_path = 'files/all';
        $file->name = File::generateRandomName() . "." . $request->file('file')->extension();
        $file->real_name = $request->file('file')->getClientOriginalName();
        $file->user_id = $request->user() ? $request->user()->id : 0;

        if ($request->purpose == 'batch-activation') {
            $target_path = 'files/batch-activations';
        } elseif ($request->purpose == 'service-updates') {
            $target_path = 'files/content-management';
        }elseif ($request->purpose == 'service-image') {
            $target_path = 'files/service-image';
        }

        $path = \Illuminate\Support\Facades\Storage::putFileAs(
            $target_path,
            $request->file('file'),
            $file->name
        );


        $file->path = $path;
        $file->save();
        return $path;
    }

    public static function saveFileByName($name, $contents)
    {
        $file = new File;
        $file->name = $name;
        $file->real_name = $name;
        $file->user_id = 0;
        $path = 'files/' . $name;
        if (\Illuminate\Support\Facades\Storage::put($path, $contents)) {
            $file->path = $path;
            $file->save();
        } else {
            abort(422);
        }

        return $path;
    }

    public static function generateRandomName()
    {
        return sha1(time() . random_int(1, 20000));
    }
}
