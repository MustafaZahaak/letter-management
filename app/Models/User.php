<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    use SoftDeletes;

    protected $guard_name = 'api';

    protected $fillable = [
        'user_name',
        'name',
        'email',
        'number',
        'password',
        'status',
        'type',
        'org_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'
    ];

    protected static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new UserScope);
        }
    }


    public static function createSuperAdmin()
    {

        $u = User::where('user_name', 'super_admin')->first();
        $org = Organization::createSystemOrg();

        if (!$u) {
            $u = new User;
            $u->name = 'Super Admin';
            $u->user_name = 'super_admin';
            $u->number = 93700001212;
            $u->type = 'system';
            $u->password = bcrypt('SuperAdmin@#@!#');
            $u->org_id = $org->id;
            $u->email = 'super-admin@gmail.com';
            $u->save();
        }

        $role = Role::createSuperAdminRole();
        $u->assignRole($role);
        return $u->createToken('superAdminLoginToken')->accessToken;
    }

    public static function createAdmin()
    {
        $u = User::where('user_name', 'admin')->first();
        $org = Organization::createSystemOrg();

        if (!$u) {
            $u = new User;
            $u->name = 'admin';
            $u->user_name = 'admin';
            $u->number = 700001213;
            $u->password = bcrypt('SuperAdmin@#@!#');
            $u->org_id = $org->id;
            $u->email = 'admin@gmail.com';
            $u->save();
        }

        $role = Role::where('name', 'admin')->first();
        if (!$role) {
            $role = Role::create(['name' => 'admin', 'org_id' =>  $org->id]);
        }
        $u->assignRole($role);
        return $u->createToken('adminLoginToken')->accessToken;
    }


    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'org_id', 'id')->select('id', 'english_name', 'dari_name', 'pashto_name');
    }

    public function resetPassword()
    {
        $this->password = bcrypt('123456');
        $this->update();
    }

    public function changePassword($toPassword)
    {
        $this->password = bcrypt($toPassword);
        $this->update();
    }

    public function getPin($msisdn){
        return rand(2,999999);
    }
}
