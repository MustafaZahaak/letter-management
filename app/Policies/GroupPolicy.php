<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        
    }

    public function create(User $user, $group, $request)
    {
        if ($group and $user->hasPermissionTo('/groups/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $group)
    {
        if ($group and $user->hasPermissionTo('/groups/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $group)
    {
        if ($group and $user->hasPermissionTo('/groups/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function view(User $user, $group)
    {
        if ($group and $user->hasPermissionTo('/groups/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $user, $group)
    {
        if ($group and $user->hasAnyPermission(['groups', '/groups/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
    public function groupMembers(User $user, $group)
    {
        if ($group and $user->hasAnyPermission(['groups', '/groups/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
