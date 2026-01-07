<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            Your note was viewed
        </h1>

        <p style="font-size: 15px; color: #6b7280; line-height: 1.6; margin: 0 0 24px 0;">
            The Burner Note you created was just opened and read. As requested, the note has been permanently deleted from our servers.
        </p>

        <div style="background-color: #f3f4f6; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
            <p style="font-size: 13px; color: #6b7280; margin: 0;">
                <strong style="color: #374151;">Viewed at:</strong> {{ $receipt->viewed_at->format('M j, Y \a\t g:i A') }}
            </p>
        </div>

        <a href="{{ config('app.url') }}" style="display: inline-block; background-color: #111827; color: white; font-size: 14px; font-weight: 500; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
            Create Another Note
        </a>
    </div>

    <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 24px;">
        <a href="{{ config('app.url') }}" style="color: #6b7280; text-decoration: none;">Burner Note</a>
    </p>
</body>
</html>
