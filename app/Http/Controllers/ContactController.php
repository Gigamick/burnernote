<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
        ]);

        Mail::to('burnernote@dept91.com')
            ->send(new ContactMail($validated['email'], $validated['message']));

        return redirect('/contact')->with('success', 'Message sent! We\'ll get back to you soon.');
    }
}
