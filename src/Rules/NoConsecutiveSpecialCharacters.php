<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class NoConsecutiveSpecialCharacters implements Rule
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
        // No consecutive characters
        $regex = '/\A\W?(?>\w+\W)*\w*\z/u';

        return preg_match($regex, $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('fortify::validation.messages.no_consecutive_characters');
    }
}
