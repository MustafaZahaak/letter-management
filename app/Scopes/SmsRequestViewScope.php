<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SmsRequestViewScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        $user = Auth::user();
        if (!$user->hasRole('super-admin')) {
            $builder->where("org_id", '=', $user->org_id);
        }
    }
}
