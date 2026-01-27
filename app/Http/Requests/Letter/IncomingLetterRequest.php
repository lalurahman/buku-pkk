<?php

namespace App\Http\Requests\Letter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class IncomingLetterRequest extends FormRequest
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
        $incomingLetterId = $this->route('incoming_letter');

        return [
            'letter_number' => ['required', 'string', 'max:255', 'unique:incoming_letters,letter_number,' . $incomingLetterId],
            'received_date' => ['required', 'date'],
            'letter_date' => ['required', 'date'],
            'sender' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:500'],
            'has_attachment' => ['nullable', 'boolean'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'dispositions' => ['nullable', 'array'],
            'dispositions.*.disposition_to' => ['nullable', 'string', 'max:255'],
            'dispositions.*.instructions' => ['nullable', 'string'],
            'dispositions.*.disposition_date' => ['nullable', 'date'],
            'dispositions.*.from' => ['nullable', 'string', 'max:255'],
            'dispositions.*.priority' => ['nullable', 'in:normal,important,urgent'],
        ];
    }

    public function messages(): array
    {
        return [
            'letter_number.required' => 'Nomor surat wajib diisi.',
            'letter_number.unique' => 'Nomor surat sudah terdaftar.',
            'received_date.required' => 'Tanggal terima wajib diisi.',
            'letter_date.required' => 'Tanggal surat wajib diisi.',
            'sender.required' => 'Pengirim wajib diisi.',
            'subject.required' => 'Perihal wajib diisi.',
            'file.mimes' => 'File harus berformat: pdf.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator)->withInput();
    }
}
