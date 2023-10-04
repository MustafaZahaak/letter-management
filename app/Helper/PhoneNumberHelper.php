<?php


namespace App\Helper;


class PhoneNumberHelper
{

    static function correctNumber($phone){
        $phoneNumber  = preg_replace('/[^0-9]/', '', trim($phone));
        $numberLength = strlen($phoneNumber);

        if ($numberLength == 13) {
            return str_replace('0093', '93', $phoneNumber);
        }
        if ($numberLength == 11) {
            return $phoneNumber;
        }
        if ($numberLength == 10 && substr($phoneNumber,0,1)=='0') {
            return substr_replace($phoneNumber, '93', 0, ($phoneNumber[0] == '0'));
        }
        if ($numberLength == 9) {
            return '93' . $phoneNumber;
        }
        return null;
    }

}