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
                ->label(__('user.actions.create')),
            Actions\Action::make('inviteUser')
                ->label(__('user.actions.send_invitation'))
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
                            ->title(__('user.notifications.email_settings_missing_title'))
                            ->body(__('user.notifications.email_settings_missing_body'))
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
                            ? __('user.notifications.invitation_existing_deleted')
                            : __('user.notifications.invitation_existing');

                        Notification::make()
                            ->title(__('user.notifications.invitation_error_title'))
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
                            ->title(__('user.notifications.invited_success_title'))
                            ->body(__('user.notifications.invited_success_body'))
                            ->success()
                            ->send();
                    } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                        // Handle email sending failure
                        Notification::make()
                            ->title(__('user.notifications.email_sending_failed_title'))
                            ->body(__('user.notifications.email_sending_failed_body'))
                            ->danger()
                            ->send();
                    } catch (\Exception $e) {
                        // Handle unexpected errors
                        Notification::make()
                            ->title(__('user.notifications.unexpected_error_title'))
                            ->body(__('user.notifications.unexpected_error_body'))
                            ->danger()
                            ->send();
                    }
                }),

        ];
    }
}
