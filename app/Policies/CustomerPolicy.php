<?php

namespace App\Policies;

use App\Exceptions\Permission\UserHasNoPermission;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Exception;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function create(User $customer, $newUser, $request)
    {
        if ($newUser and $customer->hasPermissionTo('/customers/create')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function update(Customer $customer, $newUser)
    {
        if ($newUser and $customer->hasPermissionTo('/customers/update')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }

    }

    public function delete(Customer $customer, $newUser)
    {
        if ($newUser and $customer->hasPermissionTo('/customers/delete')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function view(User $customer, $newUser)
    {
        if ($newUser and $customer->hasPermissionTo('/customers/show')) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }

    public function viewAny(User $customer, $newUser)
    {
        if ($newUser and $customer->hasAnyPermission(['customers', '/customers/show'])) {
            return true;
        } else {
            throw new UserHasNoPermission;
        }
    }
}
