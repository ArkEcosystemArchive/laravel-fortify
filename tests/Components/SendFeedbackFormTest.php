<?php

declare(strict_types=1);

use Livewire\Livewire;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use ARKEcosystem\Fortify\Mail\SendFeedback;
use ARKEcosystem\Fortify\Components\SendFeedbackForm;

it('can submit a feedback', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', 'message')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(URL::signedRoute('profile.feedback.thank.you'));

    Mail::assertQueued(SendFeedback::class, function ($mail) {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->reason === 'reason' &&
            $mail->message === 'message';
    });
});

it('cannot submit a feedback without subject', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', '')
        ->set('message', 'message')
        ->call('submit')
        ->assertHasErrors(['subject']);

    Mail::assertNotQueued(SendFeedback::class);
});

it('cannot submit a feedback without message', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});

it('cannot submit a feedback with message greater than 500 characters long', function () {
    Route::get('/', fn () => [])->name('home');

    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', Str::random(999))
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});
