<?php

namespace App\Models;

use App\Scopes\SmsSendLogViewScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SendLogView extends Model
{
    use HasFactory;

    protected $table = 'send_logs_view';
    public $reportFields = ["msisdn", "sms_language","status","send_date","organization","originator","message_length"];

    protected static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new SmsSendLogViewScope());
        }
    }


}
