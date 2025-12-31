<?php

return [
    'general' => [
        'navigation_label' => 'General Settings',
        'navigation_group' => 'Settings',
        'title' => 'General Settings',
        'sections' => [
            'reservations' => 'Reservations',
        ],
        'fields' => [
            'check_medical' => 'Check medical validity',
            'check_medical_helper' => 'Check medical validity for reservations',
            'check_airworthiness' => 'Check airworthiness',
            'check_airworthiness_helper' => 'Check airworthiness for reservations',
            'airworthiness_limit_days' => 'Airworthiness look-back (days)',
            'check_balance' => 'Check finances',
            'check_balance_helper' => 'Check PIC finances for reservations',
            'balance_limit_amount' => 'Minimum balance required',
        ],
        'suffixes' => [
            'days' => 'days',
        ],
    ],
    'email' => [
        'navigation_label' => 'Email Settings',
        'navigation_group' => 'Settings',
        'title' => 'Email Settings',
        'fields' => [
            'smtp_host' => 'SMTP Host',
            'smtp_host_helper' => 'Enter a valid hostname, e.g., smtp.example.com',
            'smtp_port' => 'SMTP Port',
            'smtp_port_helper' => 'E.g. 587 (TLS), 465 (SSL), or 25 (none)',
            'smtp_username' => 'SMTP Username',
            'smtp_password' => 'SMTP Password',
            'from_address' => 'From Address',
            'from_name' => 'From Name',
            'allow_self_signed' => 'Allow insecure connection',
            'allow_self_signed_helper' => 'Disable certificate verification. Use only if you experience TLS/SSL errors.',
            'test_recipient' => 'Recipient Email',
            'test_recipient_placeholder' => 'Enter a valid email address',
        ],
        'actions' => [
            'save' => 'Save',
            'save_and_test' => 'Save & Test',
            'modal_heading' => 'Enter Test Email Address',
            'modal_submit' => 'Send Test Email',
        ],
        'notifications' => [
            'saved_title' => 'Settings Saved',
            'saved_body' => 'The email settings have been saved successfully.',
            'invalid_email_title' => 'Invalid Email Address',
            'invalid_email_body' => 'Please enter a valid email address.',
            'test_sent_title' => 'Test email sent!',
            'test_sent_body' => 'The email has sent successfully!',
            'smtp_error_title' => 'SMTP Connection Error',
            'smtp_error_body' => 'Failed to connect to the mail server. Please check your SMTP settings: :message',
            'generic_error_title' => 'Error',
            'generic_error_body' => 'Failed to send the test email: :message',
        ],
    ],
];
