<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.engine_warmup', false);
    }

    public function down(): void
    {
        $this->migrator->delete('general.engine_warmup');
    }
};
