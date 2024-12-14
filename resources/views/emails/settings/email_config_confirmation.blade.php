<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('email_config_confirmation.subject', ['appName' => config('app.name')]) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background-color: #f3f3f3; font-family: 'Lato', Arial, sans-serif;">
<table role="presentation"
       style="width: 100%; border-spacing: 0; border-collapse: collapse; background-color: #f3f3f3; margin: 0; padding: 0;">
    <tr>
        <td style="text-align: center;">
            <table role="presentation"
                   style="max-width: 600px; width: 100%; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); font-family: 'Lato', Arial, sans-serif;">
                <tr>
                    <td style="padding: 20px 30px; text-align: center; font-family: 'Lato', Arial, sans-serif;">
                        <h1 style="color: #333333; font-size: 24px; font-weight: bold; margin: 0 0 20px; font-family: 'Lato', Arial, sans-serif;">
                            {{ __('email_config_confirmation.greeting') }}
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 30px 20px; color: #4d4d4d; font-size: 16px; line-height: 1.6; text-align: left; font-family: 'Lato', Arial, sans-serif;">
                        {{ __('email_config_confirmation.intro', ['appName' => config('app.name')]) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 30px 20px; color: #4d4d4d; font-size: 16px; line-height: 1.6; text-align: left; font-family: 'Lato', Arial, sans-serif;">
                        {{ __('email_config_confirmation.body') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 30px; text-align: center;">
                        <a href="{{ config('app.url') }}"
                           style="display: inline-block; background-color: #333333; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: bold; font-size: 16px; text-align: center; margin: 20px 0; font-family: 'Lato', Arial, sans-serif;">
                            {{ __('email_config_confirmation.visit_site', ['appName' => config('app.name')]) }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 30px; color: #999999; font-size: 12px; text-align: center; font-family: 'Lato', Arial, sans-serif;">
                        {{ __('email_config_confirmation.signature', ['appName' => config('app.name')]) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
