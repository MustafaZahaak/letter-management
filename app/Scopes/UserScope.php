<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ($user->type == 'system') {
            $builder->where("type", 'system');
        }

        if ($user->type == 'normal') {
            $builder->where("type", 'normal');
        }

        if (!$user->hasRole('super-admin')) {
            $builder->where("org_id", '=', $user->org_id);
        }
    }
}
