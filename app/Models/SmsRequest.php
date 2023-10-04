<?php

namespace App\Models;

use App\Jobs\SendHighPrioritySmsJob;
use App\Jobs\SendLowPrioritySmsJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsRequest extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['file_path','group_id', 'originator', 'priority', 'language', 'delivery_start_date', 'delivery_end_date', 'message', 'created_by','number'];

    protected $table = 'sms_requests';
    protected $dates = ['deleted_at'];
    protected const NUMBER_OF_HIGH_PRIORITY_JOBS = 2;
    protected const NUMBER_OF_LOW_PRIORITY_JOBS = 2;


    protected static function booted()
    {
        static::created(
            function ($sms_data) {
                $sms_data   = smsRequest::where('id', $sms_data->id)->first();
                $startDate  = Carbon::createFromFormat('Y-m-d H:i:s', $sms_data->delivery_start_date);
                $delay      = now()->addMinutes($startDate->diffInMinutes(now()->toDateTimeString()));

                switch (strtolower($sms_data->priority)):
                    case 'high':
                        // dispatch(new SendHighPrioritySmsJob($sms_data))->onQueue(self::getHighJobQueue());
                        break;
                    case 'low':
                        // dispatch(new SendLowPrioritySmsJob($sms_data))->delay($delay)->onQueue(self::getLowJobQueue());
                        break;
                endswitch;

            }
        );
    }

    static function getHighJobQueue()
    {
        $count = 1;
        while ($count <= self::NUMBER_OF_HIGH_PRIORITY_JOBS):
            if (!\App\Models\Job::where('queue', 'high' . $count)->first()) {
                return 'high' . $count;
            }
            $count++;
        endwhile;
        return 'high';
    }

    static function getLowJobQueue()
    {
        $count = 1;
        while ($count <= self::NUMBER_OF_LOW_PRIORITY_JOBS):
            if (!\App\Models\Job::where('queue', 'low' . $count)->first()) {
                return 'low' . $count;
            }
            $count++;
        endwhile;
        return 'low';
    }


}