<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BurnMeNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'max:50000'],
            'client_key' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Please enter a note.',
            'note.max' => 'Note cannot exceed 50,000 characters.',
            'client_key.required' => 'Encryption key is required.',
        ];
    }
}
