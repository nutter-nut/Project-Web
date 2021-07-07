<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
// use Recaptcha\ReCaptcha;
use app\Validators\ReCaptcha;

class Captcha implements Rule

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
        // dd($value,$attribute);
        $recaptcha = new \ReCaptcha\ReCaptcha(env('CAPTCHA_SECRET'));
        
        $response = $recaptcha->verify($value,$_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please complete the recaptcha to submin the form.';
    }
}
