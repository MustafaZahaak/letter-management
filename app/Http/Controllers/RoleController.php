<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role as Role;

class RoleController extends Controller
{

    public function index(Request $r)
    {
        $role = new Role();
        $searchQuery = $r->input('q', '');
        $uniqueField = $r->input('org', "");
    
        if ($searchQuery != "") {
            $role = $role->where(function ($query) use ($searchQuery) {
                $query->orWhere('name', 'like', $searchQuery . "%");
                $query->orWhere('id', '=',  $searchQuery);
            });
        }

        if ($uniqueField) {
            return Role::where('org_id', $uniqueField)->get();
        }

        $roles = $role->with(['permissions','organization'])->take(100)->get();
        return $roles;
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = Role::create($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->givePermissionTo($permissions);
            return Role::all()->pluck('name');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = Role::where('id', $id)->first();
            if ((Role::doesExists($request->input('name'), $request->input('org_id'), $id))) {
                return response()->json([
                    'message' => "Role Already exist!"
                ],422);
            } else {
                $permissions = $request->input('permission') ? $request->input('permission') : [];
                if ($this->checkRoleHasPermission($role, $permissions)) {
                    $role->update($request->except('permission'));
                    $role->syncPermissions($permissions);
                    return $role;
                } else {
                    $role->syncPermissions($permissions);
                }
            }
            return $role;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function destroy($id)
    {

        return Role::where('id', '=', $id)->delete() ?
            ['message' => "Role Deleted!"] :
            ['message' => "Role does'nt exists!"];
    }

    public function checkRoleHasPermission($role, array $permissions)
    {
        $hasPermission = false;
        foreach ($permissions as $key => $per) {
            if ($role->hasPermissionTo($per)) {
                $hasPermission = true;
            } else {
                return false;
            }
        }
        return $hasPermission;
    }

    public function show($id)
    {
        $role = Role::where('id', $id)->with(['permissions','organization'])->first();
        if (!$role) {
            return response()->json([
                'message' => "Role Doesn't exists!"
            ],404);
        }
        return $role;
    }
}
