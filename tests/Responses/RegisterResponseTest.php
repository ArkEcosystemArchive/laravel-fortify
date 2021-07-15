<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Fortify\Models;
use ARKEcosystem\Fortify\Models\User;
use ARKEcosystem\Fortify\Responses\RegisterResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Mockery;
use Mockery\MockInterface;

it('can return json', function () {
    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnTrue();

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(JsonResponse::class);
    expect($response->getData())->toBe('');
});

it('can return redirect', function () {
    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request
        ->shouldReceive('get')
        ->once()
        ->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain(route('verification.notice'));
});

it('redirects to the accept invite route', function () {
    Config::set('fortify.models.invitation', \Tests\stubs\TestUser::class);
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.accept_invitation_route', 'invitations.accept');

    $user = User::factory()->create();

    // Initialize the invitation
    $invitation = Models::invitation()::findByUuid('uuid-uuid-uuid-uuid');
    $invitation->update(['user_id' => $user->id]);

    $this->mock(\Illuminate\Contracts\Routing\UrlGenerator::class, function (MockInterface $mock) use ($invitation) {
        $mock->shouldReceive('route')
            ->with('invitations.accept', $invitation)
            ->andReturn('http://localhost/accept-invite');
    });

    $request = Mockery::mock(\Illuminate\Http\Request::class);

    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();

    $request->shouldReceive('get')
        ->with('invitation')
        ->once()
        ->andReturn('uuid-uuid-uuid-uuid');

    $request->shouldReceive('user')
        ->once()
        ->andReturn($user);

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain('http://localhost/accept-invite');
});

it('redirects to the default url if no route for accept an invitation is set', function () {
    Config::set('fortify.models.invitation', \Tests\stubs\TestUser::class);
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);
    Config::set('fortify.accept_invitation_route', null);

    $user = User::factory()->create();

    // Initialize the invitation
    $invitation = Models::invitation()::findByUuid('uuid-uuid-uuid-uuid');
    $invitation->update(['user_id' => $user->id]);

    $request = Mockery::mock(\Illuminate\Http\Request::class);

    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain(route('verification.notice'));
});

it('redirects to home if the username is used instead of the email', function () {
    Config::set('fortify.email', null);
    Config::set('fortify.username', 'username');
    Config::set('fortify.models.user', \ARKEcosystem\Fortify\Models\User::class);

    $request = Mockery::mock(\Illuminate\Http\Request::class);

    $request
        ->shouldReceive('get')
        ->once()
        ->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->getTargetUrl())->toBe('http://localhost');
});
