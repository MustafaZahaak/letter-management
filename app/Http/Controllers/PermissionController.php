<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Exception;
//use \Morilog\Jalali\Jalalian;

class PermissionController extends Controller
{
    /**
     * @return array for permissions associated module name
     */
    public function index()
    {
        $permissions = [];
        $list = Permission::all()->groupBy('module_name');

        foreach ($list as $k => $p) :
            $permissions[] = ['module_name' => $k, 'permissions' => $p];
        endforeach;

        return $permissions;
    }

    public function store(StorePermissionRequest $r)
    {
        $p = new Permission();
        $permissionInfo = $r->only($p->getFillable());
        $permissionInfo['descriptions'] = json_encode($r->descriptions);
        return $p->create($permissionInfo);
    }


    public function update(UpdatePermissionRequest $r, $id)
    {
        $p = Permission::where('id', $id)->first();
        if (!$p) {
            return response()->json([
                'message' => 'Permission not found!'
            ]);
        }
        
        $permissionInfo = $r->only($p->getFillable());
        $permissionInfo['descriptions'] = json_encode($r->descriptions);
        $p->update($permissionInfo);
        
        return $p;
    }

    public function destroy(Request $r, $id)
    {
        return Permission::where('id', '=', $id)->delete() ?
            ['message' => "Permission Deleted!"] :
            ['message' => "Permission not found!"];
    }

    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }

    public function show(Request $r, $id)
    {
        $p = Permission::where('id', $id)->first();
        if (!$p) {
            return response()->json([
                'message' => 'Permission not found!'
            ]);
        }
        return $p;
    }
}

