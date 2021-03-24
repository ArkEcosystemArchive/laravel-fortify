<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use ARKEcosystem\Fortify\Support\Enums\Constants;
use Illuminate\Support\Str;
use Laravel\Fortify\Rules\Password as Fortify;

class Username extends Fortify
{
    /**
     * Indicates if the username contains some forbidden special characters.
     *
     * @var bool
     */
    protected $withForbiddenSpecialChars = false;

    /**
     * Indicates if the username contains a special character at the start of it.
     *
     * @var bool
     */
    protected $withSpecialCharAtTheStart = false;

    /**
     * Indicates if the username contains a special character at the end of it.
     *
     * @var bool
     */
    protected $withSpecialCharAtTheEnd = false;

    /**
     * Indicates if the username contains consecutive special characters.
     *
     * @var bool
     */
    protected $withConsecutiveSpecialChars = false;

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
        // Handle potential NULL values
        $value = $value ?: '';

        if ($this->withForbiddenSpecialChars($value)) {
            $this->withForbiddenSpecialChars = true;

            return false;
        }

        if ($this->withSpecialCharAtTheStart($value)) {
            $this->withSpecialCharAtTheStart = true;

            return false;
        }

        if ($this->withSpecialCharAtTheEnd($value)) {
            $this->withSpecialCharAtTheEnd = true;

            return false;
        }

        if ($this->withConsecutiveSpecialChars($value)) {
            $this->withConsecutiveSpecialChars = true;

            return false;
        }

        return ! $this->needsMinimumLength($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->message) {
            return $this->message;
        }

        switch (true) {
            case $this->withSpecialCharAtTheStart:
                return trans('fortify::validation.messages.username.special_character_start');

            case $this->withSpecialCharAtTheEnd:
                return trans('fortify::validation.messages.username.special_character_end');

            case $this->withConsecutiveSpecialChars:
                return trans('fortify::validation.messages.username.consecutive_special_characters');

            case $this->withForbiddenSpecialChars:
                return trans('fortify::validation.messages.username.forbidden_special_characters');

            default:
                return trans(':attribute must be at least :length characters.', [
                    'length' => Constants::MIN_USERNAME_CHARACTERS,
                ]);
        }
    }

    public function withForbiddenSpecialChars(string $value): bool
    {
        return preg_match('/\W+/', $value) === 1;
    }

    public function withSpecialCharAtTheStart(string $value): bool
    {
        return preg_match('/^\W|^[_|\.]/', $value) === 1;
    }

    public function withSpecialCharAtTheEnd(string $value): bool
    {
        return preg_match('/\W$|[_|\.]$/', $value) === 1;
    }

    public function withConsecutiveSpecialChars(string $value): bool
    {
        return preg_match('/^(?!.*([._%+-])\1)[A-Za-z0-9._%+-]+$/', $value) === 0;
    }

    public function needsMinimumLength(string $value): bool
    {
        return Str::length($value) < Constants::MIN_USERNAME_CHARACTERS;
    }
}
