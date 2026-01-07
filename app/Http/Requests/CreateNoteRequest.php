<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'max:50000'],
            'password' => ['nullable', 'string', 'max:255'],
            'expiry' => ['nullable', 'integer', 'min:1', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Please enter a note.',
            'note.max' => 'Note cannot exceed 50,000 characters.',
            'expiry.min' => 'Expiry must be at least 1 day.',
            'expiry.max' => 'Expiry cannot exceed 30 days.',
        ];
    }
}
