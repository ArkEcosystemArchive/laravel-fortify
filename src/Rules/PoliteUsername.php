<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;
use Snipe\BanBuilder\CensorWords;

final class PoliteUsername implements Rule
{
    public function __construct(public CensorWords $censor)
    {
        $this->censor->badwords = config('profanities.' . config('app.locale'));
    }

    public function passes($attribute, $value)
    {
        return count($this->censor->censorString($value)['matched']) === 0;
    }

    public function message()
    {
        return trans('fortify::validation.messages.polite_username');
    }
}
