<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        
    }

    public function create(User $user, $sms, $request)
    {
        return true;
        if ($sms and $user->hasPermissionTo('/sms/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(User $user, $sms)
    {
        if ($sms and $user->hasPermissionTo('/sms/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(User $user, $sms)
    {
        if ($sms and $user->hasPermissionTo('/sms/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function view(User $user, $sms)
    {
        if ($sms and $user->hasPermissionTo('/sms/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $user, $sms)
    {
        if ($sms and $user->hasAnyPermission(['sms', '/sms/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
