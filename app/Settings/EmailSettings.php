<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EmailSettings extends Settings
{
    public string $smtp_host;
    public int $smtp_port;
    public string $smtp_encryption;
    public string $smtp_username;
    public string $smtp_password;
    public string $from_address;
    public string $from_name;

    public static function group(): string
    {
        return 'email';
    }
}
