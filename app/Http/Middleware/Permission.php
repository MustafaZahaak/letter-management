<?php

namespace App\Http\Middleware;

use App\Exceptions\Customer\CustomerNotExist;
use App\Exceptions\Group\GroupNotExist;
use App\Exceptions\Originator\OriginatorNotExist;
use Closure;
use \App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Role\RoleNotExist;
use App\Exceptions\Organization\OrganizationNotExist;
use App\Exceptions\User\UserNotExist;


use Exception;

class Permission
{

    private $request;
    private $requestMethod;
    private $hasCurrentPermission = null;


    public function handle($request, Closure $next, $guard = null)
    {
        $this->request = $request;
        $this->requestMethod = strtolower($this->request->method());

        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (!$request->user()) {
            abort(403);
        }
        //Auth::user()->getPermissionTo('sms');



        // Validate the value...

        $action = $this->getAction();
        $model = $this->getModel();
        // dd($model);
        if ($this->requestMethod == 'put' || $this->requestMethod == 'delete') {

            $policyResult = $request->user()->cannot($action, $model);
            if ($policyResult) {
                return response()->json([
                    'message' => "Unauthorized action!"
                ], 403);
            }
            $this->hasCurrentPermission = true;
        }
        if ($this->requestMethod == 'post') {
            $policyResult = $request->user()->cannot($action, [$model, $request]);
            if ($policyResult) {
                return response()->json([
                    'message' => "Unauthorized action!"
                ], 403);
            }
            $this->hasCurrentPermission = true;
        }
        //get show/{id} or index
        if ($this->requestMethod == 'get') {
            if ($request->user()->cannot($action, $model)) {
                return response()->json([
                    'message' => "Unauthorized action!"
                ], 403);
            }
            $this->hasCurrentPermission = true;
        }


        if ($this->hasCurrentPermission) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                return response('Unauthorized.', 403);
            } else {
                return response()->json([
                    'message' => "User doesn't has sufficient Permission!"
                ], 403);
            }
        }
    }

    private function getAction()
    {
        $action = '';
        $requestMethod = request()->method();
        if ($requestMethod == strtoupper("post")) {
            $action = "create";
        } elseif ($requestMethod == strtoupper("put")) {
            $action = "update";
        } elseif ($requestMethod == strtoupper("delete")) {
            $action = "delete";
        }elseif ($requestMethod == strtoupper("get") && strpos(request()->path(), 'withMembers')) {
            $action = "groupMembers";
        }elseif ($requestMethod == strtoupper("get") && strpos(request()->path(), 'getPermissions')) {
            $action = "getPermissions";
        }elseif ($requestMethod == strtoupper("get") && !strpos(request()->path(), 'show')) {
            $action = "viewAny";
        } elseif ($requestMethod == strtoupper("get") && strpos(request()->path(), 'show')) {
            $action = "view";
        }
        return $action;
    }

    private function getModelName($url)
    {
        $models = ['Role', 'User', 'Organization', 'Group', 'Originator','Sm','Member' ,'Customer'];

        foreach ($models as $m) :
            if (strpos(strtolower($url), strtolower($m) . "s")) {
                return strtolower($m);
            }
        endforeach;
        return false;
    }

    private function getModel()
    {

        if ($this->requestMethod == 'put' or $this->requestMethod == 'delete' || ($this->requestMethod == 'get' && strpos(request()->path(), 'show'))) {
            $url = $this->request->path();
            $urlArray = explode('/', $url);
            $id = end($urlArray);
            $model = null;
            $modelName = $this->getModelName($url);
            if ($modelName) {
                switch ($modelName) {
                    case 'user':
                        $model = \App\Models\User::where('id', $id)->first();
                        if (!$model) {
                            throw new UserNotExist;
                        }
                        break;
                    case 'organization':
                        $model = \App\Models\Organization::where('id', $id)->first();
                        if (!$model) {
                            throw new OrganizationNotExist;
                        }
                        break;
                    case 'role':
                        $model = \App\Models\Role::where('id', $id)->first();
                        if (!$model) {
                            throw new RoleNotExist;
                        }
                        break;
                    case 'group':
                        $model = \App\Models\Group::where('id', $id)->first();
                        if (!$model) {
                            throw new GroupNotExist;
                        }
                        break;
                    case 'originator':
                        $model = \App\Models\Originator::where('id', $id)->first();
                        if (!$model) {
                            throw new OriginatorNotExist;
                        }
                        break;
                    case 'sm':
                        $model = \App\Models\SmsRequest::where('id', $id)->first();
                        if (!$model) {
                            throw new OriginatorNotExist;
                        }
                        break;
                    case 'member':
                        $model = \App\Models\GroupMember::where('id', $id)->first();
                        if (!$model) {
                            throw new GroupNotExist;
                        }
                        break;
                    case 'customer':
                        $model = \App\Models\Customer::where('number', 'like', '%' . $id . '%')->first();
                        if (!$model) {
                            throw new CustomerNotExist;
                        }
                        break;

                }
            }
            return $model;
        } else {
            $url = $this->request->path();
            $urlArray = explode('/', $url);
            $id = end($urlArray);
            $model = null;
            $modelName = $this->getModelName($url);
            if ($modelName) {
                switch ($modelName) {
                    case 'user':
                        $model = new \App\Models\User;
                        break;
                    case 'organization':
                        $model = new \App\Models\Organization;
                        break;
                    case 'role':
                        $model = new \App\Models\Role;
                        break;
                    case 'group':
                        $model = new \App\Models\Group;
                        break;
                    case 'originator':
                        $model = new \App\Models\Originator;
                        break;
                    case 'sm':
                        $model = new \App\Models\SmsRequest;
                        break;
                    case 'member':
                        $model = new \App\Models\GroupMember;
                        break;
                    case 'customer':
                        $model = new \App\Models\Customer;
                    break;
                }
            }
            return $model;
        }
    }
}
