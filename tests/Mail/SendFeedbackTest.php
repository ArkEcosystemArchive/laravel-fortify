<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Mail;

it('sends_the_mail_to_the_marketsquare_team', function () {
    Mail::fake();

    Mail::to(config('fortify.mail.feedback'))->send(new SendFeedback('feedback'));

    Mail::assertQueued(SendFeedback::class, function ($mail): bool {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->subject === trans('fortify::mails.feedback_subject') &&
            $mail->from === config('fortify::mail.default');
    });
});
