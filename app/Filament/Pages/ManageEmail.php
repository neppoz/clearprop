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
    protected static ?string $label = 'Email Settings';
    protected static ?string $title = 'Email Settings';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static string $settings = EmailSettings::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Email Settings';
    protected static ?int $navigationSort = 200;

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
                ->label('SMTP Host')
                ->rule('regex:/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\\.)+[a-zA-Z]{2,}$/')
                ->helperText('Enter a valid hostname, e.g., smtp.example.com')
                ->required(),

            Forms\Components\TextInput::make('smtp_port')
                ->label('SMTP Port')
                ->numeric()
                ->rule('in:25,465,587')
                ->helperText('Allowed ports: 25, 465, 587')
                ->required(),

            Forms\Components\TextInput::make('smtp_username')
                ->label('SMTP Username')
                ->rule('email')
                ->required(),

            Forms\Components\TextInput::make('smtp_password')
                ->label('SMTP Password')
                ->password()
                ->revealable()
                ->required(),

            Forms\Components\TextInput::make('from_address')
                ->label('From Address')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('from_name')
                ->label('From Name')
                ->required(),

        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->action(function (array $data) {
                    $data = $this->form->getState();
                    $this->saveSettings($data);

                    \Filament\Notifications\Notification::make()
                        ->title('Settings Saved')
                        ->body('The email settings have been saved successfully.')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-check')
                ->color('primary'),

            // Save & Test Action
            Action::make('save_and_test')
                ->label('Save & Test')
                ->action(function (array $data) {
                    $recipient = $data['test_email'];

                    if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                        \Filament\Notifications\Notification::make()
                            ->title('Invalid Email Address')
                            ->body('Please enter a valid email address.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $formData = $this->form->getState();
                    $this->saveSettings($formData);

                    try {
                        $this->refreshMailConfig();

                        Mail::raw('This is a test email.', function ($message) use ($recipient) {
                            $message->to($recipient)->subject('Test Email');
                        });

                        Notification::make()
                            ->title('Test email sent!')
                            ->body('The email has sent successfully!')
                            ->success()
                            ->send();
                    } catch (TransportException $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('SMTP Connection Error')
                            ->body('Failed to connect to the mail server. Please check your SMTP settings: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('Failed to send the test email: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->modalHeading('Enter Test Email Address')
                ->modalSubmitActionLabel('Send Test Email')
                ->form([
                    Forms\Components\TextInput::make('test_email')
                        ->label('Recipient Email')
                        ->placeholder('Enter a valid email address')
                        ->required()
                        ->email(),
                ]),
        ];
    }

    private function saveSettings(array $data): void
    {
        $settings = app(\App\Settings\EmailSettings::class);

        $settings->smtp_host = $data['smtp_host'];
        $settings->smtp_port = $data['smtp_port'];

        if ($data['smtp_port'] == 587) {
            $data['smtp_encryption'] = 'tls';
        }
        if ($data['smtp_port'] == 465) {
            $data['smtp_encryption'] = 'ssl';
        }
        if ($data['smtp_port'] == 25) {
            $data['smtp_encryption'] = 'null';
        }
        $settings->smtp_encryption = $data['smtp_encryption'];

        $settings->smtp_username = $data['smtp_username'];
        $settings->smtp_password = encrypt($data['smtp_password']);
        $settings->from_address = $data['from_address'];
        $settings->from_name = $data['from_name'];
        $settings->save();

        // Konfiguration neu laden
        $this->refreshMailConfig();
    }

    public function refreshMailConfig(): void
    {
        $settings = app(\App\Settings\EmailSettings::class);

        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.stream', [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
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
