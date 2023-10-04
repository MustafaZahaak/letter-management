<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
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

    public function report(User $user)
    {
        if ($user->hasPermissionTo('/sms/report')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
