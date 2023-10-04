<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReceiveSms extends Command
{
    protected $signature = 'smsc:receive';

    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\SmsController');
        $controller->initReceive();
    }
}
