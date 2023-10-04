<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OriginatorPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function create(User $user, $org, $request)
    {
        if ($org and $user->hasPermissionTo('/originators/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $org)
    {
        if ($org and $user->hasPermissionTo('/originators/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $org)
    {
        if ($org and $user->hasPermissionTo('/originators/delete')) {
            return true;
        } else {
        throw new UserHasNoPermission;
        }
    }

    public function view(User $user, $org)
    {
        if ($org and $user->hasPermissionTo('/originators/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $user, $org)
    {
        if ($org and $user->hasAnyPermission(['originators', '/originators/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
