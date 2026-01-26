<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $memberId = $this->route('member');

        return [
            'name' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:members,registration_number,' . $memberId],
            'member_role_id' => ['required', 'exists:member_roles,id'],
            'functional_position_id' => ['required', 'exists:functional_positions,id'],
            'date_of_birth' => ['nullable', 'date'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'education' => ['nullable', 'string', 'max:100'],
            'job' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'registration_number.unique' => 'The registration number has already been taken.',
            'member_role_id.exists' => 'The selected member role is invalid.',
            'functional_position_id.exists' => 'The selected functional position is invalid.',
            'date_of_birth.date' => 'The date of birth is not a valid date.',
            'marital_status.string' => 'The marital status must be a string.',
            'marital_status.max' => 'The marital status may not be greater than 50 characters.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 500 characters.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.max' => 'The phone number may not be greater than 20 characters.',
            'education.string' => 'The education must be a string.',
            'education.max' => 'The education may not be greater than 100 characters.',
            'job.string' => 'The job must be a string.',
            'job.max' => 'The job may not be greater than 100 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator)->withInput();
    }
}
