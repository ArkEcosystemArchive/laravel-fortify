<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\SendFeedbackForm;
use ARKEcosystem\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('can submit a feedback form', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('message', 'message')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('profile.feedback.thank-you'));

    Mail::assertQueued(SendFeedback::class, function ($mail) {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->message === 'message';
    });
});

it('cannot submit a feedback form without message', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});

it('cannot submit a feedback with message greater than 500 characters long', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('message', Str::random(999))
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});
