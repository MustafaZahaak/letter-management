<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriberPolicy
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

    public function create(User $user, $sms, $request)
    {
        return true;
        if ($sms and $user->hasPermissionTo('/sms/create')) {
            return true;
        } else {
            throw new UserHasNoPermission();
        }

    }

    public function list(User $user){
        if ($user->hasPermissionTo('/subscriptions/list')) {
            return true;
        } else {
            throw new UserHasNoPermission();
        }
    }
}
