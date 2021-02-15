<?php

declare(strict_types=1);

return [
    'user-settings' => [
        '2fa_title'                         => 'Two Factor Authentication',
        '2fa_description'                   => 'Add additional security to your account using two factor authentication.',
        '2fa_enabled_title'                 => 'You have enabled two factor authentication.',
        '2fa_not_enabled_title'             => 'You have not enabled two factor authentication.',
        '2fa_summary'                       => "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's <a href='https://authy.com' target='_blank' class='font-bold'>Authy</a> or <a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2' target='_blank' class='font-bold'>Google Authenticator</a> application.",
        'one_time_password'                 => 'One-Time Password',
        '2fa_reset_code_title'              => 'Two-Factor Authentication Reset Code',
        '2fa_reset_code_description'        => 'Reset Code',
        '2fa_warning_text'                  => 'If you lose your two-factor authentication device, you may use this emergency reset token to disable two-factor authentication on your account. <strong>This is the only time this token will be displayed, so be sure not to lose it!</strong>',
        'reset_link_email'                  => 'Request submitted. If your email address is associated with an account, you will receive an email with instructions on how to reset your password.',
        'update_timezone_title'             => 'Timezone',
        'update_timezone_description'       => 'Select a Timezone below and update it by clicking the update button.',
        'timezone_updated'                  => 'Timezone was successfully updated',
        'password_information_title'        => 'Password',
        'password_information_description'  => 'Ensure your account is using a long, random password to stay secure.',
        'contact_information_title'         => 'Contact Information',
        'contact_information_description'   => "Update your account's contact information and email address.",
        'gdpr_title'                        => 'General Data Protection Regulation (GDPR)',
        'gdpr_description'                  => 'This will will create a zip containing all personal data to respect your right to data portability. You will receive the zip file on the email address linked to your account.',
        'delete_account_title'              => 'Account Deletion',
        'delete_account_description'        => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'update_password_alert_description' => 'The Security Settings allow you to change your passwords and enable or disable 2FA. Please remember the changes made for when you next sign in.',
        'password_updated'                  => 'Password was successfully updated',
    ],

    'feedback' => [
        'title'       => 'Provide feedback and help us improve!',
        'description' => 'We value every member of our community and would love to know what we did wrong. Please leave an email address if you would like us to contact you directly.',
    ],

    'feedback_thank_you' => [
        'title'       => 'Thank you for the feedback',
        'description' => 'We are sad to see you go but you are welcome back any time. After 30 days you will be required to create a new account.',
        'home_page'   => 'Home page',
    ],
];
