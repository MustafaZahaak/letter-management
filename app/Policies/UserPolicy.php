<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Exception;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $newUser, $request)
    {
        if ($newUser and $user->hasPermissionTo('/users/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $newUser)
    {
        if ($newUser and $user->hasPermissionTo('/users/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $newUser)
    {
        if ($newUser and $user->hasPermissionTo('/users/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function view(User $user, $newUser)
    {
        if ($newUser and $user->hasPermissionTo('/users/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $user, $newUser)
    {
        if ($newUser and $user->hasAnyPermission(['users', '/users/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function getPermissions(User $user)
    {
        if ($user->hasAnyPermission(['users', '/users/show','/dashboards/analytic'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function restPassword(User $user){
        if ($user->hasPermissionTo('/sms/reset-password') || $user->hasRole('super-admin')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
    public function changePassword(User $user){
        if ($user->hasPermissionTo('/sms/change-password') || $user->hasRole('super-admin')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
