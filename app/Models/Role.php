<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as SRole;
use App\Exceptions\RoleException;
use App\Scopes\RoleScope;

class Role extends SRole
{
    protected $hidden = ['deleted_at'];
    protected $casts    = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];

    use SoftDeletes;

    protected static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new RoleScope);
        }
    }

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);
        if (static::where('name', $attributes['name'])->where('guard_name', $attributes['guard_name'])->where('org_id', $attributes['org_id'])->first()) {
            throw RoleException::getAlreadyExistsMessage($attributes['name'], $attributes['guard_name'], $attributes['org_id']);
        }
        return static::query()->create($attributes);
    }


    public static function doesExists(string $name, int $organization, int $row_id): bool
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('name', $name)->where('org_id', $organization)->where('id', '!=', $row_id)->count();

        if ($role >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function organization(){
        return $this->belongsTo(\App\Models\Organization::class,'org_id')->select(['id','english_name','dari_name','pashto_name']);
    }

    static  function createSuperAdminRole(){
        $role = Role::where('name', 'super-admin')->first();
        $guard_name = Guard::getDefaultName(static::class);
        if (!$role) {
            $role = static::query()->create(['name' => 'super-admin', 'org_id' => 1 ,'guard_name'=> $guard_name]);
        }
        return $role;
    }

    static  function createSubscriberRole(){
        $role = Role::where('name', 'subscriber')->first();
        $guard_name = Guard::getDefaultName(static::class);
        if (!$role) {
            $role = static::query()->create(['name' => 'subscriber', 'org_id' => 1 ,'guard_name'=> $guard_name]);
        }
        return $role;
    }

    static  function createContentManagerRole(){
        $role = Role::where('name', 'content-manager')->first();
        $guard_name = Guard::getDefaultName(static::class);
        if (!$role) {
            $role = static::query()->create(['name' => 'content-manager', 'org_id' => 1 ,'guard_name'=> $guard_name]);
            $role->givePermissionTo(['/service-updates/show','services-updates','services','/services/create','/services/show']);
        }
        return $role;
    }

    static  function createCustomerCareRole(){
        $role = Role::where('name', 'customer-care')->first();
        $guard_name = Guard::getDefaultName(static::class);
        if (!$role) {
            $role = static::query()->create(['name' => 'customer-care', 'org_id' => 1 ,'guard_name'=> $guard_name]);
            $role->givePermissionTo(['customer-care','/customers/show']);
        }
        return $role;
    }

    static  function createCallCenterRole(){
        $role = Role::where('name', 'call-center')->first();
        $guard_name = Guard::getDefaultName(static::class);
        if (!$role) {
            $role = static::query()->create(['name' => 'call-center', 'org_id' => 1 ,'guard_name'=> $guard_name]);
            $role->givePermissionTo(['call-center','/customers/show']);

        }
        return $role;
    }
}
