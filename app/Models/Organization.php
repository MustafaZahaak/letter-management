<?php

namespace App\Models;

//use App\Scopes\OrganizationScope;
use App\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    use SoftDeletes;
 
    protected $fillable=[
        'english_name',
        'dari_name',
        'pashto_name',
        'contact_no',
        'email',
        'address',
        'address2',
        'city',
        'postcode',
        'country',
        'logo',
    ];
    protected $casts      = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];
    protected $hidden = ['deleted_at'];

    public static function booted() {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new OrganizationScope);
        }
    }

    public function users(){
        if(Auth::user()->hasRole('super-admin')){
            return $this->hasMany(\App\Models\User::class);
        }
        return $this->hasMany(\App\Models\User::class)->where('org_id',Auth::user()->org_id);
    }

    public function roles(){
        return \App\Models\Role::where('org_id',$this->organization_id);
    }

    static function createSystemOrg(){
        $org = Organization::where('english_name', "AWCC")->first();
        if (!$org) {
            $org = Organization::create([
                'english_name' => 'AWCC',
                'dari_name' => 'افعان بیسیم افغانتسان',
                'pashto_name' => 'د افغان بیسیم اتصالات',
                'contact_no' => '0700001212',
                'email' => 'awcc@awcc.af',
                'address' => 'kabul ',
                'address2' => '',
                'city' => 'Kabul',
                'postcode' => '47969',
                'country' => 'Afghanistan',
                'logo' => '/logo/files/test.jpg',
            ]);
        }
        return $org;
    }

    static function createGlobalNocOrg(){
        $org = Organization::where('english_name', "Global NOC")->first();
        if (!$org) {
            $org = Organization::create([
                'english_name' => 'Global NOC',
                'dari_name' => 'Global NOC',
                'pashto_name' => 'Global NOC',
                'contact_no' => '0700012121',
                'email' => 'awcc@awcc.af',
                'address' => 'shahr-e-naw ',
                'address2' => '',
                'city' => 'Kabul',
                'postcode' => '6001',
                'country' => 'Afghanistan',
                'logo' => '/logo/files/test.jpg',
            ]);
        }
        return $org;
    }

    static function getOrgByName($name)
    {
        $org = Organization::where('english_name', $name)->first();
        if (!$org) {
            $org = Organization::create([
                'english_name' => $name,
                'dari_name' => $name,
                'pashto_name' => $name,
                'contact_no' => '700012121',
                'email' => 'awcc@awcc.af',
                'address' => 'shahr-e-naw ',
                'address2' => '',
                'city' => 'Kabul',
                'postcode' => '6001',
                'country' => 'Afghanistan',
                'logo' => '/logo/files/test.jpg',
            ]);
        }
        return $org;
    }
}
