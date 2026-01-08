<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            Join {{ $invitation->team->name }} on Burner Note
        </h1>

        <p style="font-size: 14px; color: #4b5563; margin: 0 0 24px 0;">
            {{ $invitation->inviter->email }} has invited you to join their team as {{ $invitation->role === 'admin' ? 'an admin' : 'a member' }}.
        </p>

        <a href="{{ url('/invitation/' . $invitation->token) }}" style="display: inline-block; background-color: #111827; color: white; font-weight: 500; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-size: 14px;">
            Accept Invitation
        </a>

        <p style="font-size: 12px; color: #9ca3af; margin: 24px 0 0 0;">
            This invitation expires {{ $invitation->expires_at->diffForHumans() }}.
        </p>
    </div>
</body>
</html>
