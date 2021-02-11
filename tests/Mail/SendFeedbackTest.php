<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Mail;

it('sends_the_mail_to_the_marketsquare_team', function () {
    Mail::fake();

    Mail::to(config('fortify.mail.feedback'))->send(new SendFeedback('reason', 'message'));

    Mail::assertQueued(SendFeedback::class, fn ($mail) => $mail->hasTo(config('fortify.mail.feedback.address')));
});

it('builds_the_mail_with_the_correct_subject', function () {
    $mail = (new SendFeedback('reason', 'message'));

    expect($mail->build()->subject)->toBe('reason');
});
