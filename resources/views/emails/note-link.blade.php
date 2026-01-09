<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px; margin: 0;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            You've received a private note
        </h1>

        <p style="font-size: 15px; color: #6b7280; line-height: 1.6; margin: 0 0 24px 0;">
            Someone sent you a secure note using Burner Note. The note is encrypted and will be permanently deleted after it's read.
        </p>

        <a href="{{ $link }}" style="display: block; background-color: #111827; color: white; font-size: 15px; font-weight: 500; padding: 14px 24px; border-radius: 10px; text-decoration: none; text-align: center; margin-bottom: 24px;">
            View Note
        </a>

        <div style="background-color: #f3f4f6; border-radius: 12px; padding: 16px;">
            <p style="font-size: 13px; color: #6b7280; margin: 0; line-height: 1.5;">
                <strong style="color: #374151;">Security note:</strong> This link can only be used a limited number of times. Once the limit is reached, the note is permanently destroyed.
            </p>
        </div>
    </div>

    <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 24px;">
        Sent via <a href="{{ config('app.url') }}" style="color: #6b7280; text-decoration: none;">Burner Note</a> &mdash; encrypted self-destructing notes
    </p>
</body>
</html>
