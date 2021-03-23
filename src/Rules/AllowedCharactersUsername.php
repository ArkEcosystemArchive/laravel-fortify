<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class AllowedCharactersUsername implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match("/^\W+$/", $value) === 0;
    }

    public function message()
    {
        // TODO : Waiting for Sammie
        return trans('fortify::validation.messages.allowed_characters_username');
    }
}
