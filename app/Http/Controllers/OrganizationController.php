<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;

class OrganizationController extends Controller
{

    /**
     * Get Organization list
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $r){
        return Organization::orderBy('id')->get();
     }


    /**
     * Get Organization
     * @param Request $r
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $r, $id){
        $o = Organization::where('id',$id)->first();
       
        if(!$o){
            return response()->json([
                'message' => 'Can not find an organization with this id!'
            ],404);
        }
        
        return $o;
     }


    /**
     * Creates new Organization
     * @param StoreOrganizationRequest $r
     * @return mixed
     */
    public function store(StoreOrganizationRequest $r){
        $o = new Organization;
        return Organization::create($r->only( $o->getFillable()));
    }


    public function update(StoreOrganizationRequest $r, $id){
       $o = Organization::where('id',$id)->first();
      
       if(!$o){
           return response()->json([
               'message' => 'Can not find an organization with this id!'
           ],404);
       }
       
       $o->fill( $r->only( $o->getFillable()));
       $o->update();
       return $o;
    }

    public function destroy(Request $r, $id)
    {
        $o = Organization::where('id', $id)->first();
        if (!$o) {
            return response()->json([
                'message' => 'Can not find an organization with this id!'
            ],404);
        }
        $o->delete();
        return $o;
     }
}
