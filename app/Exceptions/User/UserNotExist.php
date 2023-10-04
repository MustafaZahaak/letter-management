<?php

namespace App\Exceptions\User;

use Exception;

class UserNotExist extends Exception
{
    public static function UserNotExistMessage()
    {
        return new static("User does'nt Exists");
    }

    public function render($request)
    {
        return response()->json([
            'message' => "User does'nt Exists!"
        ], 404);
    }
}
