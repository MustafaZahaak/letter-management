<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Exceptions\Permission\UserHasNoPermission;

class OrganizationPolicy
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

    public function create(User $user, $org, $request)
    {
        return false;
        if ($org and $user->hasPermissionTo('/organizations/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $request)
    {
        return false;
        if ($user->hasPermissionTo('/organizations/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $org)
    {
        return false;
        if ($org and $user->hasPermissionTo('/organizations/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function view(User $user, $org)
    {
        return false;
        if ($user->hasPermissionTo('/organizations/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function viewAny(User $user, $org)
    {
        if ($org and $user->hasAnyPermission(['organizations', '/organizations/show','/originators/show','originators'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
