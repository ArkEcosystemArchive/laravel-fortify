<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

final class SendFeedback extends Mailable implements ShouldQueue
{
    use Queueable;

    public string $reason;

    public string $message;

    public function __construct(string $reason, string $message)
    {
        $this->reason  = $reason;
        $this->message = $message;
    }

    public function build(): self
    {
        return $this
            ->from(config('fortify.mail.default'))
            ->subject($this->reason)
            ->markdown('ark-fortify::mails.profile.feedback');
    }
}
