<?php

namespace App\Console;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendLogArchiveController;
use App\Jobs\archiveSendLogJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work', ['--queue', 'low'])
            ->between('20:00', '04:00')
            ->hourly()
            //->withoutOverlapping(2)
            ->description("Send low priority sms");

        $schedule->command('queue:work', ['--queue', 'low1,low2'])
            ->between('20:00', '04:00')
            ->everyTwoHours()
            //->withoutOverlapping(2)
            ->description("Send low priority sms");

            $schedule->call(function () {
                //$this->archive();
            })->monthly()->description("Archive sent sms");

            $schedule->command("group:updateEmployeesGroup")
            ->twiceMonthly(1, 16, '13:00')
            ->description("Update Employees Group");

    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function archive()
    {
        $SendLogArchiveController = new SendLogArchiveController();
        $SendLogArchiveController->archive();
    }

    protected function updateDashboard()
    {
        $dashboardController = new DashboardController();
        $dashboardController->refreshDashboardCache();
    }
}
