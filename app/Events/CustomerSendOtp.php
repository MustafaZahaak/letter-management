<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Otp;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerSendOtp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otp;
    public $customer;
    public $originator;
    
    public function __construct(Customer $c , Otp $otp)
    {
        $this->otp = $otp;
        $this->customer = $c;
        $this->originator = config('sms.notifyOriginator');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('otp');
    }
}
