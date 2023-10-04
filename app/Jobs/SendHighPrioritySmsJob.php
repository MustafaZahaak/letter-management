<?php

namespace App\Jobs;

use App\Models\SmsRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendHighPrioritySmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $smsRequest;

    public $tries = 3;

    public $timeout = 500;

    public function __construct(SmsRequest $request = null)
    {
        $this->smsRequest = $request;
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\SmsController');
        $this->smsRequest['job_id'] = $this->job->getJobId();
        $this->smsRequest['attempt'] = $this->job->attempts();
        $controller->callAction('sendMessageFromRequestData', ['data' => $this->smsRequest]);
    }
}
