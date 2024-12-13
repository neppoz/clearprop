<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('email.smtp_host', "mailserver.example.com");
        $this->migrator->add('email.smtp_port', 587);
        $this->migrator->add('email.smtp_encryption', "tls");
        $this->migrator->add('email.smtp_username', "hello@example.com");
        $this->migrator->add('email.smtp_password', "your_password");
        $this->migrator->add('email.from_address', "hello@example.com");
        $this->migrator->add('email.from_name', "Name");
    }
};
