<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerInvalidInput
{
    use Dispatchable, SerializesModels;

    public $message;
    public $customer;
    public $originator;

    public function __construct(Customer $c, array $m)
    {
        $this->message = $m;
        $this->customer = $c;
        $this->originator = config('sms.notifyOriginator');
    }
}
