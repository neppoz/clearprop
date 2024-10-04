<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.check_medical', false);
        $this->migrator->add('general.check_balance', false);
        $this->migrator->add('general.check_activities', false);
        $this->migrator->add('general.check_ratings', false);
        $this->migrator->add('general.check_balance_limit_amount', -200);
        $this->migrator->add('general.check_activities_limit_days', 90);
    }
};
