<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendLogArchive extends Model
{
    use HasFactory;

    protected $table ='send_logs_archive';
    protected $casts    = ['created_at'  => 'datetime:Y-m-d H:m','updated_at' => 'datetime:Y-m-d H:m'];
    protected $fillable = ["number","originator","org_id","request_id","try","job_id","send_status","submit_date","send_date","created_at"];

}
