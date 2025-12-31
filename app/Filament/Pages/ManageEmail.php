<?php

namespace App\Filament\Pages;

use App\Settings\EmailSettings;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

class ManageEmail extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static string $settings = EmailSettings::class;
    protected static ?int $navigationSort = 200;

    public static function getNavigationGroup(): ?string
    {
        return __('settings.email.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('settings.email.navigation_label');
    }

    public static function getLabel(): string
    {
        return __('settings.email.title');
    }

    public function getTitle(): string
    {
        return __('settings.email.title');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('viewSettings');
    }

    public static function canView(): bool
    {
        return Gate::allows('viewSettings');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('smtp_host')
                ->label(__('settings.email.fields.smtp_host'))
                ->rule('regex:/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\\.)+[a-zA-Z]{2,}$/')
                ->helperText(__('settings.email.fields.smtp_host_helper'))
                ->required(),

            Forms\Components\TextInput::make('smtp_port')
                ->label(__('settings.email.fields.smtp_port'))
                ->numeric()
                ->required()
                ->helperText(__('settings.email.fields.smtp_port_helper')),

            Forms\Components\TextInput::make('smtp_username')
                ->label(__('settings.email.fields.smtp_username'))
                ->required(),

            Forms\Components\TextInput::make('smtp_password')
                ->label(__('settings.email.fields.smtp_password'))
                ->password()
                ->revealable()
                ->required(),

            Forms\Components\TextInput::make('from_address')
                ->label(__('settings.email.fields.from_address'))
                ->email()
                ->required(),

            Forms\Components\TextInput::make('from_name')
                ->label(__('settings.email.fields.from_name'))
                ->required(),

            Forms\Components\Toggle::make('allow_self_signed')
                ->label(__('settings.email.fields.allow_self_signed'))
                ->helperText(__('settings.email.fields.allow_self_signed_helper'))
                ->default(false),


        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('settings.email.actions.save'))
                ->action(function (array $data) {
                    $data = $this->form->getState();
                    $this->saveSettings($data);

                    Notification::make()
                        ->title(__('settings.email.notifications.saved_title'))
                        ->body(__('settings.email.notifications.saved_body'))
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-check')
                ->color('primary'),

            // Save & Test Action
            Action::make('save_and_test')
                ->label(__('settings.email.actions.save_and_test'))
                ->action(function (array $data) {
                    $recipient = $data['test_email'];

                    if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                        Notification::make()
                            ->title(__('settings.email.notifications.invalid_email_title'))
                            ->body(__('settings.email.notifications.invalid_email_body'))
                            ->danger()
                            ->send();

                        return;
                    }

                    $formData = $this->form->getState();
                    $this->saveSettings($formData);

                    try {
                        $this->refreshMailConfig();

                        $subject = __('email_config_confirmation.subject', ['appName' => config('app.name')]);

                        Mail::send('emails.settings.email_config_confirmation', [], function ($message) use ($recipient, $subject) {
                            $message->to($recipient)
                                ->subject($subject);
                        });

                        Notification::make()
                            ->title(__('settings.email.notifications.test_sent_title'))
                            ->body(__('settings.email.notifications.test_sent_body'))
                            ->success()
                            ->send();
                    } catch (TransportException $e) {
                        Notification::make()
                            ->title(__('settings.email.notifications.smtp_error_title'))
                            ->body(__('settings.email.notifications.smtp_error_body', ['message' => $e->getMessage()]))
                            ->danger()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(__('settings.email.notifications.generic_error_title'))
                            ->body(__('settings.email.notifications.generic_error_body', ['message' => $e->getMessage()]))
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->outlined()
                ->modalHeading(__('settings.email.actions.modal_heading'))
                ->modalSubmitActionLabel(__('settings.email.actions.modal_submit'))
                ->form([
                    Forms\Components\TextInput::make('test_email')
                        ->label(__('settings.email.fields.test_recipient'))
                        ->placeholder(__('settings.email.fields.test_recipient_placeholder'))
                        ->required()
                        ->email(),
                ]),
        ];
    }

    private function saveSettings(array $data): void
    {
        $settings = app(\App\Settings\EmailSettings::class);

        $settings->smtp_host = $data['smtp_host'];
        $port = (int)$data['smtp_port'];
        $encryption = match ($port) {
            465 => 'ssl',
            587, 2525 => 'tls',
            default => null,
        };
        $settings->smtp_encryption = $encryption;
        $settings->smtp_username = $data['smtp_username'];
        $settings->smtp_password = encrypt($data['smtp_password']);
        $settings->from_address = $data['from_address'];
        $settings->from_name = $data['from_name'];
        $settings->allow_self_signed = $data['allow_self_signed'] ?? false;

        $settings->save();

        $this->refreshMailConfig();
    }

    public function refreshMailConfig(): void
    {
        $settings = app(\App\Settings\EmailSettings::class);

        Config::set('mail.default', 'smtp');
        if ($settings->smtp_encryption === 'ssl' || $settings->allow_self_signed) {
            Config::set('mail.mailers.smtp.stream', [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
        } else {
            Config::set('mail.mailers.smtp.stream', null);
        }
        Config::set('mail.mailers.smtp.host', $settings->smtp_host);
        Config::set('mail.mailers.smtp.port', $settings->smtp_port);
        Config::set('mail.mailers.smtp.encryption', $settings->smtp_encryption);
        Config::set('mail.mailers.smtp.username', $settings->smtp_username);
        Config::set('mail.mailers.smtp.password', decrypt($settings->smtp_password));
        Config::set('mail.from.address', $settings->from_address);
        Config::set('mail.from.name', $settings->from_name);

        // Purge Mailer-Cache
        Mail::purge('smtp');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!empty($data['smtp_password'])) {
            try {
                $data['smtp_password'] = decrypt($data['smtp_password']);
            } catch (\Exception $e) {
                $data['smtp_password'] = '';
            }
        }

        return $data;
    }

}
