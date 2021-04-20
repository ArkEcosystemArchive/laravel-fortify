<?php

namespace ARKEcosystem\Fortify\Http\Requests;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Laravel\Fortify\Http\Requests\TwoFactorLoginRequest;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use Illuminate\Contracts\Auth\PasswordBroker;

class TwoFactorResetPasswordRequest extends TwoFactorLoginRequest
{
    public function __construct(protected PasswordBroker $passwordBroker)
    {

    }

    /**
     * Determine if the reset token is valid
     *
     * @return bool
     */
    public function hasValidToken()
    {
        $user = $this->challengedUser();
        return $user && $this->passwordBroker->tokenExists($user, $this->token);
    }

    /**
     * Determine if there is a challenged user in the current session.
     *
     * @return bool
     */
    public function hasChallengedUser()
    {
        $model = app(StatefulGuard::class)->getProvider()->getModel();


        return $this->has('email') &&
            $model::whereEmail($this->email)->exists();
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @return mixed
     */
    public function challengedUser()
    {
        if ($this->challengedUser) {
            return $this->challengedUser;
        }

        $model = app(StatefulGuard::class)->getProvider()->getModel();

        if (! $this->has('email') ||
            ! $user = $model::whereEmail($this->email)->first()) {
            throw new HttpResponseException(
                app(FailedTwoFactorLoginResponse::class)->toResponse($this)
            );
        }

        return $this->challengedUser = $user;
    }

}
