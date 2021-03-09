<?php

declare(strict_types=1);

return [
    'confirm-password' => [
        'page_header' => 'Confirm Password',
    ],

    'forgot-password' => [
        'page_header' => 'Password Reset Email',
        'reset_link'  => 'Send Password Reset Link',
    ],

    'sign-in' => [
        'forgot_password'  => 'Forgot password?',
        'register_now'     => 'Not a member? <a href=":route" class="underline link semibold">Sign up</a>',
    ],

    'register-form' => [
        'conditions'         => "Creating an account means you're okay with our <a href=':termsOfServiceRoute' class='link'>Terms of Service</a>, <a href=':privacyPolicyRoute' class='link'>Privacy Policy</a> and our default <a href=':notificationSettingsRoute' class='link'>Notification Settings</a>.",
        'create_account'     => 'Create Account',
        'already_member'     => 'Already have an account? <a href=":route" class="underline link semibold">Sign in</a>',
    ],

    'register' => [
        'page_header'      => 'Sign Up',
    ],

    'reset-password' => [
        'page_header' => 'Reset Password',
    ],

    'two-factor' => [
        'page_header'      => '2FA Authentication',
        'page_description' => 'Enter your 2FA code below to sign in.',
    ],

    'verified' => [
        'page_header'      => 'Congratulations!',
        'page_description' => 'Your email address has been verified.',
        'cta'              => 'Homepage',
    ],

    'verify' => [
        'page_header'         => 'Verify Your Email Address',
        'link_description'    => 'A verification link has been sent to your email address.',
        'resend_verification' => 'Before proceeding, please check your email for a verification link. If you did not receive the email, <button type="submit" class="link">click here to request another</button>.',
    ],
];
