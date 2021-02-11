<?php

declare(strict_types=1);

use App\Mail\SendFeedback;
use ARKEcosystem\Fortify\Components\SendFeedbackForm;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('can submit a feedback', function () {
    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', 'message')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('profile.feedback.thank.you'));

    Mail::assertQueued(SendFeedback::class, function ($mail) {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->reason === 'reason' &&
            $mail->message === 'message';
    });
});

it('cannot submit a feedback without subject', function () {
    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', '')
        ->set('message', 'message')
        ->call('submit')
        ->assertHasErrors(['subject']);

    Mail::assertNotQueued(SendFeedback::class);
});

it('cannot submit a feedback without message', function () {
    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});

it('cannot submit a feedback with message greater than 500 characters long', function () {
    Mail::fake();

    Livewire::test(SendFeedbackForm::class)
        ->set('subject', 'reason')
        ->set('message', $this->faker->text(999))
        ->call('submit')
        ->assertHasErrors(['message']);

    Mail::assertNotQueued(SendFeedback::class);
});
