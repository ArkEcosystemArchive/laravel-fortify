<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Rules\PoliteUsername;
use Snipe\BanBuilder\CensorWords;

it('can pass validation', function () {
    $subject = new PoliteUsername(new CensorWords());

    expect($subject->passes('name', 'foo'))->toBeTrue();
});

it('can fail validation', function () {
    $subject = new PoliteUsername(new CensorWords());

    expect($subject->passes('name', 'penis'))->toBeFalse();
});

it('shows the correct validation message', function () {
    $subject = new PoliteUsername(new CensorWords());

    expect($subject->message())->toBe(trans('fortify::validation.messages.polite_username'));
});

it('should use a default profanities list', function () {
    $subject = new PoliteUsername(new CensorWords());
    $defaultConfig = config('profanities.en');

    expect($subject->censor->badwords)->toBeArray();
    expect($subject->censor->badwords)->toBe($defaultConfig);
});
