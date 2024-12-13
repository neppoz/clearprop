<?php

namespace App\Filament\Pages;

use App\Settings\EmailSettings;
use Filament\Forms;
use Filament\Forms\Form;
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('test_email')
                        ->label('Test Email')
                        ->action(function (array $data) {
                            $recipient = $data['email_address'];

                            if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Invalid Email Address')
                                    ->body('Please enter a valid email address.')
                                    ->danger()
                                    ->send();

                                return;
                            }

                            try {
                                // Refresh Mail Configuration
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
                                // SMTP-Transportfehler
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
                        ->modalHeading('Send Test Email')
                        ->modalSubmitActionLabel('Send now!')
                        ->form([
                            Forms\Components\TextInput::make('email_address')
                                ->label('Recipient Email')
                                ->placeholder('Enter a valid email address')
                                ->required()
                                ->email(), // Validierung auf eine E-Mail-Adresse
                        ]),
                ])
                    ->columnSpan(2)
                    ->alignEnd(),

            ])
            ->columns(2);

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['smtp_password'])) {
            try {
                decrypt($data['smtp_password']);
            } catch (\Exception $e) {
                $data['smtp_password'] = encrypt($data['smtp_password']);
            }
        }

        if ($data['smtp_port'] == 587) {
            $data['smtp_encryption'] = 'tls';
        }

        return $data;
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
