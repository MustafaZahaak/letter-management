<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $users          = new User();
        $searchQuery    = $r->input('q');
        $uniqueField         = $r->input('u');

        if ($searchQuery) {
            $users = $users->where(function ($query) use ($searchQuery) {
                $query->orWhere('name', 'like', "%$searchQuery%")
                    ->orWhere('user_name', 'like', "%$searchQuery%")
                    ->orWhere('email', 'like', "%$searchQuery%");
            });
        }
        if ($uniqueField) {
            return User::where('id', $uniqueField)->with(['roles', 'organization'])->get();
        }

        return $users->with(['roles', 'organization'])->get();
    }

    public function login(Request $r)
    {
        $credentials = $r->only('user_name', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = User::where('id', Auth::guard('web')->user()->id)->with(['roles'])->first();

            return response()->json([
                'status' => 'ok',
                'user' => $user,
                'token' => $user->createToken('access')->accessToken
            ]);
        }

        return response([
            'status' => 'error',
            'messages' => ['Invalid user_name or password!']
        ], 403);
    }

    public function logOut(Request $r)
    {
        $r->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function store(CreateUserRequest $r)
    {
        $user       = new User;
        $userInfo   = $r->only($user->getFillable());

        $userInfo['password'] = bcrypt($r->input('password'));
        $org_id = $r->input('org_id') ? $r->input('org_id') : $r->user()->org_id;
        if (!$r->user()->hasRole('super_admin')) {
            $r->user()->org_id;
        }
        $userInfo['password'] = bcrypt($r->input('password'));

        $user->fill($userInfo)->save();
        $roles      = $r->input('roles');
        $user->assignRole($roles);
        return $user;
    }

    public function update(CreateUserRequest $r, $id)
    {
        $o = User::where('id', $id)->first();
        if (!$o) {
            return response()->json([
                'message' => 'Can not find an user with this id!'
            ]);
        }
        $org_id = $o->org_id;
        $o->fill($r->only($o->getFillable()));
        $o->password = bcrypt($r->input('password'));
        $o->save();
        // $roles               = $o->createRoles($r->input('roles'), $org_id);
        $roles = $r->input('roles');
        $o->syncRoles($roles);

        return User::with('roles')->where('id', $id)->first();
    }

    public function destroy(DeleteUserRequest $r, $id)
    {
        $o = User::where('id', $id)->first();
        if (!$o) {
            return response()->json([
                'message' => 'Can not find a user with this id!'
            ]);
        }

        if ($o->delete()) {
            return ['message' => 'Deleted successfully'];
        }
    }

    public function show(Request $r, $id)
    {
        $u = User::where('id', $id)->with(['roles', 'organization'])->first();
        if (!$u) {
            return response()->json([
                'message' => 'Can not find an user with this id!'
            ]);
        }
        return $u;
    }

    public function getRoles(Request $r)
    {
        if (!$r->user()->hasRole('super_admin')) {
            return Role::where('org_id', $r->user()->org_id)->get();
        }
        return Role::all();
    }

    public function getPermissions($uId)
    {
        $permissions = collect();
        $user = User::where("id", $uId)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Can not find a user with this id!'
            ]);
        }
        foreach ($user->getAllPermissions() as $value) {
            $permissions->push($value->name);
        }
        return $permissions;
    }

    public function restPassword($uId){

        $user = User::where("id", $uId)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Can not find a user with this id!'
            ]);
        }
        $user->resetPassword();
        return $user;
    }

    public function changePassword(Request $r,$uId){

        $user = User::where("id", $uId)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Can not find a user with this id!'
            ]);
        }
        if (Hash::check($r->input('old_password'), $user->password)) {
            $this->validate($r, [
                'new_password' => 'min:6|required_with:confirm_new_password|same:confirm_new_password',
                'confirm_new_password' => 'min:6'
            ]);

            $user->changePassword($r->input('new_password'));
            return $user;

        }
        return response()->json(['message' => 'password is wrong'], 422);

    }
}
