<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Fortify\Responses\RegisterResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Mockery;
use Mockery\Mock;

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
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();

    $response = (new RegisterResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain(route('verification.notice'));
});
