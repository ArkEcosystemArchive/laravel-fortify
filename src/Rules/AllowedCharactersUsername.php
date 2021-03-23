<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class AllowedCharactersUsername implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z\d](?:[a-z\d ]|-(?=[a-z\d])){0,38}$/i', $value) === 1;
    }

    public function message()
    {
        return trans('fortify::validation.messages.allowed_characters_username');
    }
}
