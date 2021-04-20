<?php

namespace ARKEcosystem\Fortify\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use ARKEcosystem\Fortify\Http\Requests\TwoFactorResetPasswordRequest;

class TwoFactorAuthenticatedPasswordResetController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the two factor authentication challenge view.
     *
     * @param  \Laravel\Fortify\Http\Requests\TwoFactorLoginRequest  $request
     * @return View
     */
    public function create(TwoFactorResetPasswordRequest $request, string $token): View
    {
        if (! $request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('login'));
        }

        if(! $request->hasValidToken()) {
            throw new HttpResponseException(redirect()->route('login')->withErrors(['email' => trans('fortify::validation.password_reset_link_invalid')]));
        }

        return view('ark-fortify::auth.two-factor-challenge', [
            'token' => $token,
            'resetPassword' => true,
            'email' => $request->challengedUser()->email,
        ]);
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     *
     * @param  TwoFactorResetPasswordRequest  $request
     * @return mixed
     */
    public function store(TwoFactorResetPasswordRequest $request, string $token)
    {
        $user = $request->challengedUser();

        if(! $request->hasValidToken()) {
            throw new HttpResponseException(redirect()->route('login')->withErrors(['email' => trans('fortify::validation.password_reset_link_invalid')]));
        }

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return app(FailedTwoFactorLoginResponse::class);
        }

        return view('ark-fortify::auth.reset-password');
    }
}
