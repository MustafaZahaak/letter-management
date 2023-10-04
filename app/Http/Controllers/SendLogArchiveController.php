<?php

namespace App\Http\Controllers;

use App\Models\SendLog;
use App\Models\SendLogArchive;

class SendLogArchiveController extends Controller
{
    const ARCHIVE_LENGTH = 3000000;
    const INSERT_SIZE = 5000;

    public function archive()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);

        $result = sendLog::orderBy('send_date', 'asc')->take(self::ARCHIVE_LENGTH)->get();
        foreach ($result->chunk(self::INSERT_SIZE) as $key => $value) {
            SendLogArchive::insert($value->makeHidden('id')->toArray());
            sendLog::whereIn('id', $value->pluck("id"))->delete();
            sleep(1);
        }
        return response()->json([
            "message" => "Archiving for " . self::ARCHIVE_LENGTH . " completed"
        ], 200);
    }
}
