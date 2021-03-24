<?php

declare(strict_types=1);

return [
    'password_doesnt_match'         => 'The provided password does not match your current password.',
    'password_doesnt_match_records' => 'This password does not match our records.',

    'messages' => [
        'one_time_password'           => 'We were not able to enable two-factor authentication with this one-time password.',
        'polite_username'             => 'The given username contains words with profanities.',

        'username' => [
            'special_character_start'         => 'Username must not start or end with special characters',
            'special_character_end'           => 'Username must not start or end with special characters',
            'consecutive_special_characters'  => 'Username must not contain consecutive special characters',
            'forbidden_special_characters'    => 'Username must only contain letters, numbers and _ .',
        ],
    ],
];
