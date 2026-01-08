<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class CreateNoteRequest extends FormRequest
{
    public ?Team $team = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'max:50000'],
            'password' => ['nullable', 'string', 'max:255'],
            'expiry' => ['nullable', 'integer', 'min:1', 'max:365'],
            'max_views' => ['nullable', 'integer', 'min:1', 'max:100'],
            'notify_email' => ['nullable', 'email', 'max:255'],
            'team_id' => ['nullable', 'integer', 'exists:teams,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->team_id) {
                $this->team = Team::find($this->team_id);

                // Verify user is a member of this team
                if (!$this->team || !Auth::check() || !$this->team->isMember(Auth::user())) {
                    $validator->errors()->add('team_id', 'You are not a member of this team.');
                    return;
                }

                // Enforce team policies
                $expiry = (int) ($this->expiry ?? 7);
                $maxViews = (int) ($this->max_views ?? 1);

                if ($expiry < $this->team->policy_min_expiry_days) {
                    $validator->errors()->add('expiry', "Minimum expiry is {$this->team->policy_min_expiry_days} days for this team.");
                }

                if ($expiry > $this->team->policy_max_expiry_days) {
                    $validator->errors()->add('expiry', "Maximum expiry is {$this->team->policy_max_expiry_days} days for this team.");
                }

                if ($maxViews > $this->team->policy_max_view_limit) {
                    $validator->errors()->add('max_views', "Maximum views is {$this->team->policy_max_view_limit} for this team.");
                }

                if ($this->team->policy_require_password && empty($this->password)) {
                    $validator->errors()->add('password', 'Password is required for this team.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Please enter a note.',
            'note.max' => 'Note cannot exceed 50,000 characters.',
            'expiry.min' => 'Expiry must be at least 1 day.',
            'expiry.max' => 'Expiry cannot exceed 365 days.',
        ];
    }
}
