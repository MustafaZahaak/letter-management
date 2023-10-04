<?php

namespace App\Exceptions\Role;

use Exception;

class RoleOrgNotMatchUser extends Exception
{
    public static function RoleOrgNotMatchUserMessage()
    {
        return new static("Role Organization does'nt Match The User Organization, Access Denied! ");
    }
}
