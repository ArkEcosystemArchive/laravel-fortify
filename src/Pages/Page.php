<?php

namespace ARKEcosystem\Fortify;

use InvalidArgumentException;

abstract class Page
{
    private $allowedPages = [
        'login',
        'twoFactorChallenge',
        'register',
        'requestPasswordResetLink',
        'resetPassword',
        'verifyEmail',
        'confirmPassword',
    ];

    private $titles = [];

    private $descriptions = [];

    public function title(string $page, string $value): void
    {
        if (! in_array($page, $this->allowedPages, true)) {
            throw new InvalidArgumentException('wai');
        }

        $this->titles[$page] = $value;
    }

    public function description(string $page, string $value): void
    {
        if (! in_array($page, $this->allowedPages, true)) {
            throw new InvalidArgumentException('wai');
        }

        $this->descriptions[$page] = $value;
    }
}
