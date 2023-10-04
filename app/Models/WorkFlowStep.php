<?php

namespace App\Models;

use App\Scopes\LetterScope;
use App\Scopes\OriginatorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class WorkFlowStep extends Model
{
    protected $fillable   = ['name', 'next_step','created_by'];
    protected $casts      = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];
    protected $hidden     = ['deleted_at'];
    protected $table      = 'workflow_steps';

    use HasFactory;
    use SoftDeletes;
}