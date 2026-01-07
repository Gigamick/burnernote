<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Resend\Laravel\Facades\Resend;

class EmailController extends Controller
{
    public function sendemail(SendEmailRequest $request): View
    {
        $validated = $request->validated();

        try {
            Resend::emails()->send([
                'from' => 'Burner Note <noreply@burnernote.com>',
                'to' => [$validated['email']],
                'subject' => 'A link from Burner Note',
                'text' => "You've been sent a note from Burner Note: " . $validated['link'],
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send email via Resend', [
                'error' => $e->getMessage(),
            ]);
            return view('email-sent')->with('error', 'Failed to send email. Please try again.');
        }

        return view('email-sent');
    }
}
