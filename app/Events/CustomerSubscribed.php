<?php

namespace App\Events;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerSubscribed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $package;
    public $customer;
    public $originator ;

    public function __construct(Customer $c , Category $p)
    {
        $this->package = $p;
        $this->customer = $c;
        $this->originator = config('sms.notifyOriginator');
    }
}
