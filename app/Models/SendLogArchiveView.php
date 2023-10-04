<?php

namespace App\Models;

use App\Scopes\SmsSendLogArchiveViewScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SendLogArchiveView extends Model
{
    use HasFactory;

    protected $table='send_logs_archive_view';

    protected static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new SmsSendLogArchiveViewScope());
        }
    }



}
