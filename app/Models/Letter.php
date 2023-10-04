<?php

namespace App\Models;

use App\Scopes\LetterScope;
use App\Scopes\OriginatorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Letter extends Model
{
    protected $fillable   = ['content', 'organization_id', 'type','created_by'];
    protected $casts      = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];
    protected $hidden     = ['deleted_at'];

    use HasFactory;
    use SoftDeletes;

    public static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new LetterScope);
        }
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'org_id', 'id')->select('id', 'english_name', 'dari_name', 'pashto_name');
    }
}