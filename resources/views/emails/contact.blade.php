<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            New Contact Form Message
        </h1>

        <div style="background-color: #f3f4f6; border-radius: 12px; padding: 16px; margin-bottom: 16px;">
            <p style="font-size: 13px; color: #6b7280; margin: 0;">
                <strong style="color: #374151;">From:</strong> {{ $email }}
            </p>
        </div>

        <div style="background-color: #f3f4f6; border-radius: 12px; padding: 16px;">
            <p style="font-size: 13px; color: #374151; margin: 0; white-space: pre-wrap;">{{ $messageContent }}</p>
        </div>
    </div>
</body>
</html>
