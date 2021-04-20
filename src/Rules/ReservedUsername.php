<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Support\Str;

class ReservedUsername
{
    public function passes($attribute, $value): bool
    {
        return ! in_array(Str::lower($value), trans('fortify::username_blacklist'), true);
    }

    public function message(): string
    {
        return trans('fortify::validation.messages.username.blacklisted');
    }
}
