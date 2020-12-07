<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

it('The success response flash a message', function () {
    $response = new SuccessfulPasswordResetLinkRequestResponse(Password::RESET_LINK_SENT);
    $response = $response->toResponse(new Request());

    expect($response->getStatusCode())->toBe(302);

    expect(app('session.store')->get('laravel_flash_message'))->toHaveKey('message');
});
