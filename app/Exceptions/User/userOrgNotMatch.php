<?php

namespace App\Exceptions\User;

use Exception;

class userOrgNotMatch extends Exception
{
    
    public static function userOrgNotMatchMessage()
    {
        return new static("User Organization does'nt match");
    }

    public function render($request)
    {
        return response()->json([
            'message' => "User Organization does'nt match!"
        ], 403);
    }
}
