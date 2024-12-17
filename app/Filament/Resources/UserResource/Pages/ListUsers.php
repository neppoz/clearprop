<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Invitation;
use App\Settings\EmailSettings;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create'),
            Actions\Action::make('inviteUser')
                ->label('Send invitation')
                ->icon('heroicon-m-envelope')
                ->outlined()
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->before(function () {
                    // Validate if email settings are properly configured
                    $settings = app(EmailSettings::class);

                    if (
                        empty($settings->smtp_host) ||
                        empty($settings->smtp_port) ||
                        empty($settings->smtp_username) ||
                        empty($settings->smtp_password) ||
                        empty($settings->from_address)
                    ) {
                        Notification::make()
                            ->title('Email settings missing')
                            ->body('Please configure the email settings in the settings page.')
                            ->danger()
                            ->send();

                        return false;
                    }

                    return true;
                })
                ->action(function ($data) {
                    // Check if the email already exists in the users table, including soft-deleted users
                    $existingUser = \App\Models\User::withTrashed()->where('email', $data['email'])->first();

                    if ($existingUser) {
                        $message = $existingUser->trashed()
                            ? 'A user with this email already exists but has been deleted.'
                            : 'A user with this email already exists.';

                        Notification::make()
                            ->title('Invitation Error')
                            ->body($message)
                            ->danger()
                            ->send();

                        return; // Stop further execution if the email exists
                    }

                    // Try to send the invitation
                    try {
                        $invitation = Invitation::create(['email' => $data['email']]);
                        $acceptUrl = URL::signedRoute('invitation.accept', ['invitation' => $invitation]);

                        $subject = __('team_invitation.subject', ['appName' => config('app.name')]);

                        // Send the invitation email
                        Mail::send('emails.users.team_invitation', [
                            'acceptUrl' => $acceptUrl,
                            'appName' => config('app.name'),
                        ], function ($message) use ($invitation, $subject) {
                            $message->to($invitation->email)
                                ->subject($subject);
                        });

                        // Show success notification
                        Notification::make('invitedSuccess')
                            ->body('User invited successfully!')
                            ->success()
                            ->send();
                    } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                        // Handle email sending failure
                        Notification::make()
                            ->title('Email sending failed')
                            ->body('There was an error sending the email. Please check your email configuration.')
                            ->danger()
                            ->send();
                    } catch (\Exception $e) {
                        // Handle unexpected errors
                        Notification::make()
                            ->title('Unexpected error')
                            ->body('An unexpected error occurred while sending the email. Please try again later.')
                            ->danger()
                            ->send();
                    }
                }),

        ];
    }
}
