<?php
namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Settings\EmailSettings;

class EmailSettingsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Standard-Fallbacks
        $this->setDefaultMailConfiguration();

        // Check if settings exists
        if (Schema::hasTable('settings')) {
            try {
                $settings = app(EmailSettings::class);

                // Using values from database
                Config::set('mail.mailers.smtp.host', $settings->smtp_host ?? Config::get('mail.mailers.smtp.host'));
                Config::set('mail.mailers.smtp.port', $settings->smtp_port ?? Config::get('mail.mailers.smtp.port'));
                Config::set('mail.mailers.smtp.encryption', $settings->smtp_encryption ?? Config::get('mail.mailers.smtp.encryption'));
                Config::set('mail.mailers.smtp.username', $settings->smtp_username ?? Config::get('mail.mailers.smtp.username'));
                Config::set('mail.mailers.smtp.password', isset($settings->smtp_password) ? decrypt($settings->smtp_password) : Config::get('mail.mailers.smtp.password'));
                Config::set('mail.from.address', $settings->from_address ?? Config::get('mail.from.address'));
                Config::set('mail.from.name', $settings->from_name ?? Config::get('mail.from.name'));
            } catch (\Exception $e) {
                \Log::error('Failed to load email settings from database: ' . $e->getMessage());
            }
        }
    }

    private function setDefaultMailConfiguration(): void
    {
        // Standard configuration
        Config::set('mail.default', config('mail.default'));
        Config::set('mail.mailers.smtp.host', config('mail.mailers.smtp.host'));
        Config::set('mail.mailers.smtp.port', config('mail.mailers.smtp.port'));
        Config::set('mail.mailers.smtp.encryption', config('mail.mailers.smtp.encryption'));
        Config::set('mail.mailers.smtp.username', config('mail.mailers.smtp.username'));
        Config::set('mail.mailers.smtp.password', config('mail.mailers.smtp.password'));
        Config::set('mail.from.address', config('mail.from.address'));
        Config::set('mail.from.name', config('mail.from.name'));
        Config::set('mail.mailers.smtp.stream', config('mail.mailers.smtp.stream'));
    }
}
