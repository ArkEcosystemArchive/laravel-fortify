<?php

declare(strict_types=1);

use Illuminate\View\View;
use function Tests\createUserModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use ARKEcosystem\Fortify\Http\Requests\TwoFactorResetPasswordRequest;
use ARKEcosystem\Fortify\Http\Controllers\TwoFactorAuthenticatedPasswordResetController;

it('shows the two auth challengue form', function () {
    $user = createUserModel();

    $request = $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(true)
        ->shouldReceive('challengedUser')
        ->andReturn($user);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $response = $controller->create($request, $token);
    expect($response)->toBeInstanceOf(View::class);
    expect($response->getName())->toBe('ark-fortify::auth.two-factor-challenge');
    expect($response->getData())->toEqual([
        'token' => $token,
        'resetPassword' => true,
        'email' => $user->email,
    ]);
});

it('throws an http exception if the token is invalid', function () {
    $this->expectException(HttpResponseException::class);

    createUserModel();

    $request = $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $controller->create($request, $token);
});

it('throws an http exception if is not able to get the user', function () {
    $this->expectException(HttpResponseException::class);

    createUserModel();

    $request = $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $controller->create($request, $token);
});
