<?php

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
        'register_now'     => 'Not a member? <a href=":route" class="link">Sign up now</a>',
    ],

    'register-form' => [
        'conditions'         => "Creating an account means you're okay with our <a href=':termsOfServiceRoute' class='link'>Terms of Service</a> and <a href=':privacyPolicyRoute' class='link'>Privacy Policy</a>.",
        'create_account'     => 'Create Account',
        'already_member'     => 'Already a member? <a href=":route" class="link">Sign in</a>',
    ],

    'register' => [
        'page_header'      => 'Sign Up',
    ],

    'reset-password' => [
        'page_header' => 'Reset Password',
    ],

    'two-factor' => [
        'page_header' => 'Two-Factor Authentication',
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
