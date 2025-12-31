<?php

return [
    'navigation' => [
        'singular' => 'User',
        'plural' => 'Users',
    ],
    'navigation_group' => 'Management',

    'sections' => [
        'profile' => 'Profile Information',
        'login' => 'Login Credentials',
        'contact' => 'Contact Details',
        'access' => 'Access Rights',
        'verification' => 'Verification',
        'timestamps' => 'Timestamps',
        'password' => 'Update Password',
        'password_description' => 'Ensure your account is using a long, random password to stay secure.',
        'profile_description' => 'Update your personal and contact information.',
    ],

    'fields' => [
        'name' => 'Name',
        'email' => 'Email (Login)',
        'password' => 'New Password',
        'current_password' => 'Current Password',
        'password_confirmation' => 'Confirm Password',
        'medical_due' => 'Medical valid until',
        'license' => 'License',
        'phone_1' => 'Phone (Mobile)',
        'phone_2' => 'Phone (Work)',
        'address' => 'Address',
        'city' => 'City',
        'taxno' => 'VAT Number',
        'email_verified_at' => 'Email Verified',
        'privacy_confirmed_at' => 'Privacy Confirmed',
        'role' => 'Access Level',
        'created_at' => 'Created at',
        'updated_at' => 'Last modified at',
    ],

    'helper' => [
        'email' => 'This is also the user\'s login address.',
        'email_fixed' => 'This is your login email and cannot be changed.',
        'role' => 'Select the role to assign to the user.',
        'email_verified_at' => 'Toggle this to mark the email as verified.',
    ],

    'notifications' => [
        'profile_updated' => 'Profile updated successfully.',
        'password_updated' => 'Password updated successfully.',
        'email_settings_missing_title' => 'Email settings missing',
        'email_settings_missing_body' => 'Please configure the email settings in the settings page.',
        'invitation_error_title' => 'Invitation Error',
        'invitation_existing' => 'A user with this email already exists.',
        'invitation_existing_deleted' => 'A user with this email already exists but has been deleted.',
        'invited_success_title' => 'Invitation sent',
        'invited_success_body' => 'User invited successfully!',
        'email_sending_failed_title' => 'Email sending failed',
        'email_sending_failed_body' => 'There was an error sending the email. Please check your email configuration.',
        'unexpected_error_title' => 'Unexpected error',
        'unexpected_error_body' => 'An unexpected error occurred while sending the email. Please try again later.',
    ],

    'actions' => [
        'save_profile' => 'Save Profile',
        'save_password' => 'Update Password',
        'create' => 'Create user',
        'send_invitation' => 'Send invitation',
    ],

    'table' => [
        'email' => 'Email Address',
        'mobile' => 'Mobile',
        'office' => 'Office',
        'roles' => 'Roles',
    ],
];
