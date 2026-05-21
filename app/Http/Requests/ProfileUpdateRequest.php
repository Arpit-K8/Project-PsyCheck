<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->input('form_type') === 'support_circle') {
            return [
                'target_score' => ['required', 'integer', 'min:1', 'max:100'],
                'emergency_contact_name' => ['nullable', 'string', 'max:255'],
                'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
                'trusted_email' => ['nullable', 'email', 'max:255'],
                'alert_on_critical' => ['nullable', 'boolean'],
            ];
        }

        if ($this->input('form_type') === 'profile_info') {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($this->user()->id),
                ],
            ];
        }

        // Fallback for tests or other calls not explicitly providing form_type
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'target_score' => ['nullable', 'integer', 'min:1', 'max:100'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'trusted_email' => ['nullable', 'email', 'max:255'],
            'alert_on_critical' => ['nullable', 'boolean'],
        ];
    }
}
