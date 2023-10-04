<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsImage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $image = base64_decode($value);
        $f = finfo_open();
        $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        return $result == 'image/png' || $result == 'image/jpg' || $result == 'image/jpeg';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please update a base64 image png and jpg only!';
    }
}
