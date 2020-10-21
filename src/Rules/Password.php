<?php

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Support\Str;
use Laravel\Fortify\Rules\Password as Fortify;

class Password extends Fortify
{
    /**
     * Indicates if the password must contain one lowercase character.
     *
     * @var bool
     */
    protected $requireLowercase = false;

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
        if ($this->needsLowercase($value)) {
            return false;
        }

        if ($this->needsUppercase($value)) {
            return false;
        }

        if ($this->needsNumeric($value)) {
            return false;
        }

        if ($this->needsSpecialCharacter($value)) {
            return false;
        }

        return $this->needsMinimumLength($value);
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
            case $this->requireUppercase
                && ! $this->requireNumeric
                && ! $this->requireSpecialCharacter:
                return __('The :attribute must be at least :length characters and contain at least one uppercase character.', [
                    'length' => $this->length,
                ]);

            case $this->requireNumeric
                && ! $this->requireUppercase
                && ! $this->requireSpecialCharacter:
                return __('The :attribute must be at least :length characters and contain at least one number.', [
                    'length' => $this->length,
                ]);

            case $this->requireSpecialCharacter
                && ! $this->requireUppercase
                && ! $this->requireNumeric:
                return __('The :attribute must be at least :length characters and contain at least one special character.', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireNumeric
                && ! $this->requireSpecialCharacter:
                return __('The :attribute must be at least :length characters and contain at least one uppercase character and one number.', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireSpecialCharacter
                && ! $this->requireNumeric:
                return __('The :attribute must be at least :length characters and contain at least one uppercase character and one special character.', [
                    'length' => $this->length,
                ]);

            case $this->requireUppercase
                && $this->requireNumeric
                && $this->requireSpecialCharacter:
                return __('The :attribute must be at least :length characters and contain at least one uppercase character, one number, and one special character.', [
                    'length' => $this->length,
                ]);

            default:
                return __('The :attribute must be at least :length characters.', [
                    'length' => $this->length,
                ]);
        }
    }

    /**
     * Indicate that at least one lowercase character is required.
     *
     * @return $this
     */
    public function requireLowercase()
    {
        $this->requireLowercase = true;

        return $this;
    }

    public function needsLowercase(string $value): bool
    {
        if (! $this->requireUppercase) {
            return false;
        }

        return preg_match('/[A-Z]/', $value);
    }

    public function needsUppercase(string $value): bool
    {
        if (! $this->requireLowercase) {
            return false;
        }

        return preg_match('/[a-z]/', $value);
    }

    public function needsNumeric(string $value): bool
    {
        if (! $this->requireNumeric) {
            return false;
        }

        return preg_match('/[0-9]/', $value);
    }

    public function needsSpecialCharacter(string $value): bool
    {
        if (! $this->requireSpecialCharacter) {
            return false;
        }

        return preg_match('/[\W_]/', $value);
    }

    public function needsMinimumLength(string $value): bool
    {
        return ! (Str::length($value) >= $this->length);
    }
}
