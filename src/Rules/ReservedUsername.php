<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

class ReservedUsername
{
    public function passes($attribute, $value): bool
    {
        return ! in_array($value, trans('fortify::username_blacklist'), true);
    }

    public function message(): string
    {
        return trans('fortify::validation.messages.username.blacklisted');
    }
}
