<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px; margin: 0;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            Someone sent you a private note
        </h1>

        <p style="font-size: 15px; color: #6b7280; line-height: 1.6; margin: 0 0 24px 0;">
            Someone used your Burn Box inbox to send you an encrypted note. The note is end-to-end encrypted and will be permanently deleted after you read it.
        </p>

        <a href="{{ $noteUrl }}"
           style="display: block; background-color: #111827; color: white; font-size: 15px; font-weight: 500; padding: 14px 24px; border-radius: 10px; text-decoration: none; text-align: center; margin-bottom: 16px;">
            View Note
        </a>

        <p style="font-size: 14px; color: #6b7280; text-align: center; margin: 0 0 24px 0;">
            Or view in your <a href="{{ config('app.url') }}/account/inbox" style="color: #111827; text-decoration: underline;">Burn Box Inbox</a>
        </p>

        <div style="background-color: #f3f4f6; border-radius: 12px; padding: 16px;">
            <p style="font-size: 13px; color: #6b7280; margin: 0; line-height: 1.5;">
                <strong style="color: #374151;">Security note:</strong> This note is encrypted and can only be viewed once. After viewing, it will be permanently destroyed.
            </p>
        </div>
    </div>

    <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 24px;">
        <a href="{{ config('app.url') }}" style="color: #6b7280; text-decoration: none;">Burner Note</a>
    </p>
</body>
</html>
