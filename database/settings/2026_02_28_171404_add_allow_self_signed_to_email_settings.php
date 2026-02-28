<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        if (! $this->migrator->exists('email.allow_self_signed')) {
            $this->migrator->add('email.allow_self_signed', false);
        }
    }
};
