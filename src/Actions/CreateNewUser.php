<?php

namespace ARKEcosystem\Fortify\Actions;

use ARKEcosystem\Fortify\Models;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $input)
    {
        $input = $this->buildValidator($input)->validate();

        return Models::user()::create($this->getUserData($input));
    }

    private function buildValidator(array $input): ValidationValidator
    {
        $rules = [
            'name'              => ['required', 'string', 'max:255'],
            Fortify::username() => $this->usernameRules(),
            'password'          => $this->passwordRules(),
            'terms'             => ['required', 'accepted'],
        ];

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $rules[$altUsername] = ['required', 'string', 'max:255', 'unique:users'];
        }

        return Validator::make($input, $rules);
    }

    private function getUserData(array $input): array
    {
        $userData = [
            'name'              => $input['name'],
            Fortify::username() => $input[Fortify::username()],
            'password'          => Hash::make($input['password']),
        ];

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $userData[$usernameAlt] = $input[$altUsername];
        }

        return $userData;
    }

    private function usernameRules(): array
    {
        $rules = ['required', 'string', 'max:255', 'unique:users'];

        if (Fortify::username() === 'email') {
            $rules[] = 'email';
        }

        return $rules;
    }
}
