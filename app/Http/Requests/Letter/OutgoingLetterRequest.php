<?php

namespace App\Http\Requests\Letter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OutgoingLetterRequest extends FormRequest
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
        $outgoingLetterId = $this->route('outgoing_letter');

        return [
            'letter_number' => ['required', 'string', 'max:255', 'unique:outgoing_letters,letter_number,' . $outgoingLetterId],
            'letter_date' => ['required', 'date'],
            'recipient' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:500'],
            'has_attachment' => ['nullable', 'boolean'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'cc_recipients' => ['nullable', 'array'],
            'cc_recipients.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'letter_number.required' => 'Nomor surat wajib diisi.',
            'letter_number.unique' => 'Nomor surat sudah terdaftar.',
            'letter_date.required' => 'Tanggal surat wajib diisi.',
            'recipient.required' => 'Penerima wajib diisi.',
            'subject.required' => 'Perihal wajib diisi.',
            'file.mimes' => 'File harus berformat: pdf',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator)->withInput();
    }
}
