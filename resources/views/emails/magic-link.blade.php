<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; padding: 40px 20px;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0 0 16px 0;">
            @if($isRegistration)
                Complete your Burner Note account
            @else
                Sign in to Burner Note
            @endif
        </h1>

        <p style="font-size: 15px; color: #6b7280; line-height: 1.6; margin: 0 0 24px 0;">
            @if($isRegistration)
                Click the button below to verify your email and complete your account setup. This link will expire in 15 minutes.
            @else
                Click the button below to sign in to your account. This link will expire in 15 minutes.
            @endif
        </p>

        <a href="{{ route('auth.verify', $token->token) }}" style="display: inline-block; background-color: #111827; color: white; font-size: 14px; font-weight: 500; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
            @if($isRegistration)
                Verify Email
            @else
                Sign In
            @endif
        </a>

        <p style="font-size: 13px; color: #9ca3af; line-height: 1.6; margin: 24px 0 0 0;">
            If you didn't request this email, you can safely ignore it. Someone may have entered your email address by mistake.
        </p>
    </div>

    <p style="text-align: center; font-size: 13px; color: #9ca3af; margin-top: 24px;">
        <a href="{{ config('app.url') }}" style="color: #6b7280; text-decoration: none;">Burner Note</a>
    </p>
</body>
</html>
