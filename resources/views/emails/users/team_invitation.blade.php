<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('team_invitation.subject', ['appName' => $appName]) }}</title>
</head>
<body style="font-family: 'Lato', Arial, sans-serif; background-color: #f9fafb; color: #333333; line-height: 1.6; margin: 0; padding: 0;">
<table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; border-collapse: collapse; overflow: hidden;">
    <tr>
        <td style="background-color: #333333; color: #ffffff; text-align: center; padding: 15px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 700;">
                {{ __('team_invitation.subject', ['appName' => $appName]) }}
            </h1>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px; font-size: 16px; color: #333333;">
            <p>{{ __('team_invitation.greeting') }}</p>
            <p>{{ __('team_invitation.message', ['appName' => $appName]) }}</p>
            <br>
            <a href="{{ $acceptUrl }}"
               style="background-color: #333333; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-size: 16px; font-weight: 700;">{{ __('team_invitation.button') }}</a>
            <br><br>
            <p style="color: #666666;">{{ __('team_invitation.fallback') }}</p>
            <p><a href="{{ $acceptUrl }}" style="color: #1d4ed8; text-decoration: none;">{{ $acceptUrl }}</a></p>
            <p>{{ __('team_invitation.note') }}</p>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: 12px; color: #6b7280; padding: 15px;">
            &copy; {{ date('Y') }} {{ $appName }}. {{ __('team_invitation.footer') }}
            <br>
            <a href="{{ config('app.url') }}"
               style="color: #1d4ed8; text-decoration: none;">{{ __('team_invitation.visit') }}</a>
        </td>
    </tr>
</table>
</body>
</html>
