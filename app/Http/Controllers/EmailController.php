<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Mail\NoteLinkMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailController extends Controller
{
    public function sendemail(SendEmailRequest $request): View
    {
        $validated = $request->validated();

        try {
            Mail::to($validated['email'])->send(new NoteLinkMail($validated['link']));
        } catch (Exception $e) {
            Log::error('Failed to send email', [
                'error' => $e->getMessage(),
            ]);
            return view('email-sent')->with('error', 'Failed to send email. Please try again.');
        }

        return view('email-sent');
    }
}
