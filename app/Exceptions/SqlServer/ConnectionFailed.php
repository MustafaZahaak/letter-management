<?php

namespace App\Exceptions\SqlServer;

use Exception;

class ConnectionFailed extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => "Connection To SQL Server Failed!"
        ], 502);
    }
}
