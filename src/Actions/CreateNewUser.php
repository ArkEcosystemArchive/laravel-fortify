<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use ARKEcosystem\Fortify\Models;
use ARKEcosystem\Fortify\Rules\PoliteUsername;
use ARKEcosystem\Fortify\Rules\Username;
use ARKEcosystem\Fortify\Support\Enums\Constants;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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
        $input      = $this->buildValidator($input)->validate();
        $invitation = null;

        if (array_key_exists('invitation', $input)) {
            $invitationId = $input['invitation'];
            unset($input['invitation']);
            $invitation = Models::invitation()::findByUuid($invitationId);
        }

        return DB::transaction(function () use ($input, $invitation) {
            $user = Models::user()::create($this->getUserData($input));

            if ($invitation) {
                $invitation->update(['user_id' => $user->id]);

                $user->markEmailAsVerified();
            }

            return $user;
        });
    }

    private function buildValidator(array $input): ValidationValidator
    {
        $rules = [
            'name'              => ['required', 'string', 'min:'.Constants::MIN_DISPLAY_NAME_CHARACTERS, 'max:'.Constants::MAX_DISPLAY_NAME_CHARACTERS, resolve(PoliteUsername::class)],
            Fortify::username() => $this->usernameRules(),
            'password'          => $this->passwordRules(),
            'terms'             => ['required', 'accepted'],
            'invitation'        => ['sometimes', 'required', 'string'],
        ];

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $rules[$usernameAlt] = [
                'required', 'string', 'unique:users', resolve(PoliteUsername::class), resolve(Username::class),
            ];
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
            $userData[$usernameAlt] = $input[$usernameAlt];
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
