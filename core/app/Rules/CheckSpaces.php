<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSpaces implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove HTML tags from the input text
        $answerWithoutHtmlTags = strip_tags($value);

        // Remove spaces from the input text
        $answerWithoutSpaces = str_replace(' ', '', $answerWithoutHtmlTags);

        // Remove '&nbsp;' from the input text
        $answerWithoutSpaceCode = str_replace('&nbsp;', '', $answerWithoutSpaces);

        // Check if the resulting string is empty
        return $answerWithoutSpaceCode !== '';
    }

    public function message()
    {
        if(app()->getLocale() == 'ar' ){
            return ':attribute لا يمكن أن يحتوي على مسافات فقط.';
        }else{
            return 'The :attribute field is invalid.';
        }
    }
}
