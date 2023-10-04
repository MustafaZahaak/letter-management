<?php

namespace App\Exceptions\Organization;

use Exception;

class OrganizationNotExist extends Exception
{
    public static function OrganizationNotExistMessage()
    {
        return new static("Organization doesn't Exists");
    }

    public function render($request)
    {
        return response()->json([
            'message' => "Organization doesn't Exists!"
        ], 404);
    }
}
