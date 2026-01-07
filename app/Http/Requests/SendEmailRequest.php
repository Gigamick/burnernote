<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'link' => ['required', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'link.required' => 'Note link is required.',
            'link.url' => 'Invalid note link.',
        ];
    }
}
