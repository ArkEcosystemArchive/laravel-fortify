<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Mail\SendFeedback;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View as ViewFacade;
use Livewire\Component;

final class SendFeedbackForm extends Component
{
    public string $subject = '';

    public string $message = '';

    public function submit(): void
    {
        $this->validate([
            'subject'    => ['required', 'string'],
            'message'    => ['required', 'string', 'min:5', 'max:500'],
        ]);

        Mail::to(config('fortify.mail.feedback'))
            ->send(new SendFeedback($this->subject, $this->message));

        $this->redirect(URL::signedRoute('profile.feedback.thank.you'));
    }

    public function render(): View
    {
        return ViewFacade::make('ark-fortify::profile.send-feedback-form');
    }
}
