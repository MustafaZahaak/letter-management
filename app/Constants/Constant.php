<?php

namespace App\Constants;


class Constant
{
    //USSD Charing Codes
    const SUCCESSFULL_CHARGE = 410;
    const SUCCESSFULL_SUBSCRIBTION = 411;
    const SUCCESSFULL_UNSUBSCRIBTION = 412;
    const ALREADY_SUBSCRIBED = 300;
    const INSUFFICIENT_BALANCE = 504;
    const CUSTOMER_NOT_FOUND = 201;
    const IN_VALID_LIFE_CYCLE_STATE = 502;
    const CUSTOMER_LOCKED = 801;
    const UNSUPPORTED_EVENT_CLASS = 500;
    const TECHNICAL_ERROR = 505;
}
