<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class DisplayNameCharacters implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Any (unicode letter or number and . , - ' ’ &)
        // avoid repetitive allowed special characters.
        return preg_match('/^[\p{L}\p{N}\p{Mn} .,\-\'’&]+$/u', $value) > 0 &&
                ! preg_match('/([.,\-\'’&])\1/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('fortify::validation.messages.some_special_characters');
    }
}
