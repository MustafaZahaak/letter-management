<?php

namespace App\Exceptions;

use Spatie\Permission\Exceptions\RoleAlreadyExists as roleAlready;

class RoleException extends roleAlready
{

    public static function getAlreadyExistsMessage(string $roleName, string $guardName, string $organization)
    {
        return new static("A role `{$roleName}` already exists for guard `{$guardName}` and organization `{$organization}`. ");
    }
}
