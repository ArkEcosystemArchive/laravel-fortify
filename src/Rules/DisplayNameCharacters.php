<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class DisplayNameCharacters implements Rule
{
    /**
     * Indicates if the display name contains some forbidden characters.
     *
     * @var bool
     */
    protected bool $withForbiddenChars = false;

    /**
     * Indicates if the display name contains any reserved name.
     *
     * @var bool
     */
    protected bool $withReservedName = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($this->withForbiddenChars($value)) {
            $this->withForbiddenChars = true;

            return false;
        }

        if ($this->withReservedName($value)) {
            $this->withReservedName = true;

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        if ($this->withReservedName) {
            return trans('fortify::validation.messages.username.blacklisted');
        }

        return trans('fortify::validation.messages.some_special_characters');
    }

    public function withForbiddenChars(string $value): bool
    {
        // Any (unicode letter or number and . - ' &)
        $regex = '/^[[\p{L}\p{N}\p{Mn}\p{Pd} ._\'&,]+$/u';

        return preg_match($regex, $value) === 0;
    }

    private function withReservedName($value): bool
    {
        return in_array($value, trans('fortify::username_blacklist'), true);
    }
}
