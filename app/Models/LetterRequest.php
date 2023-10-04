<?php

namespace App\Models;

use App\Scopes\LetterScope;
use App\Scopes\OriginatorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LetterRequest extends Model
{
    protected $fillable   = ['letter_id', 'workflow_step', 'organization_id','status','created_by'];
    protected $casts      = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];
    protected $hidden     = ['deleted_at'];

    use HasFactory;
    use SoftDeletes;
  
}