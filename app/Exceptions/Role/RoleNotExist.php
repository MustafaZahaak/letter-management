<?php

namespace App\Exceptions\Role;

use Exception;

class RoleNotExist extends Exception
{
    public static function RoleNotExistMessage()
    {
        return new static("Role doesn't Exists");
    }

    public function render($request)
    {
        return response()->json([
            'message' => "Role doesn't Exists!"
        ], 404);
    }
}
