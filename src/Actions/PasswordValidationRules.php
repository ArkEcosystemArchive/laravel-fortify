<?php

namespace ARKEcosystem\Fortify\Actions;

use ARKEcosystem\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return [
            'required',
            'string',
            (new Password())
                ->length(12)
                ->requireLowercase()
                ->requireUppercase()
                ->requireNumeric()
                ->requireSpecialCharacter(),
            'confirmed',
        ];
    }
}
