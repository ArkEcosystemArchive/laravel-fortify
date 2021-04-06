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
        'register_now'     => 'Not a member? <a href=":route" class="underline link font-semibold">Sign up</a>',
    ],

    'register-form' => [
        'conditions'         => "Creating an account means you're okay with our <a href=':termsOfServiceRoute' class='link'>Terms of Service</a> and <a href=':privacyPolicyRoute' class='link'>Privacy Policy</a>.",
        'create_account'     => 'Create Account',
        'already_member'     => 'Already have an account? <a href=":route" class="underline link font-semibold">Sign in</a>',
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

    'verify' => [
        'page_header'         => 'Verify Your Email Address',
        'link_description'    => 'A verification link has been sent to your email address.',
        'resend_verification' => '<span>Before proceeding, please check your email for a verification link.</span> <span>If you did not receive the email, <button x-ref="resend_submit" type="submit" class="link"><span x-ref="resend_tooltip" class="inline-block pointer-events-none" data-tippy-content="You need to wait 5 minutes before sending the link again. In the meantime you can check your spam folder.">click here to request another</span></button>.</span>',
    ],
];
