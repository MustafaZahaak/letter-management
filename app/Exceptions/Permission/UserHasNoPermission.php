<?php

namespace App\Exceptions\Permission;

use Exception;

class UserHasNoPermission extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => "User doesn't Has this Permission!"
        ], 403);
    }
    
    public static function UserHasNoPermissionMessage($permission)
    {
        return new static("User doesn't Has `{ $permission }` Permission ");
    }
}
