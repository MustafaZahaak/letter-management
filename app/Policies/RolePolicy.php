<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Exceptions\Permission\UserHasNoPermission;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, $role, $request)
    {
        if ($role and $user->hasPermissionTo('/roles/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $role)
    {
        if ($role and $user->hasPermissionTo('/roles/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $role)
    {
        if ($role and $user->hasPermissionTo('/roles/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function view(User $user, $role)
    {
        if ($role and $user->hasPermissionTo('/roles/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $user, $role)
    {
        if ($role and $user->hasAnyPermission(['roles', '/roles/show','/users/create','/users/update'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
