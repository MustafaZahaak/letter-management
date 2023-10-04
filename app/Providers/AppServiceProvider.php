<?php

namespace App\Providers;

use App\Http\Controllers\DashboardController;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Not finalized (:_;)
         *
            Queue::after(function (JobProcessed $event) {

                $payload = $event->job->payload();
                $Job = unserialize($payload['data']['command']);
                $dashboardController = new DashboardController();
                $org_id = \App\Models\Originator::where('id',$Job->smsRequest->originator)->first()->org_id;

                //if (\App\Models\Job::where('queue','high1')->orwhere('queue','high2')->orwhere('queue','high')->count() == 0):
                    $dashboardController->updateOrSetOrgDashboardDataByOriginator($org_id,$Job->smsRequest->originator,$Job->smsRequest->id);
                    echo "dashboard updated";
                //endif;
            });
        */
    }
}
