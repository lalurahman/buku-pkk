<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class MeetingMinuteRequest extends FormRequest
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
        return [
            'meeting_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i:s,H:i'],
            'end_time' => ['nullable', 'date_format:H:i:s,H:i', 'after:start_time'],
            'meeting_type' => ['nullable', 'string', 'max:255'],
            'leader' => ['nullable', 'string', 'max:255'],
            'invited_count' => ['nullable', 'integer', 'min:0'],
            'attended_count' => ['nullable', 'integer', 'min:0'],
            'agenda' => ['nullable', 'string'],
            'discussion' => ['nullable', 'string'],
            'conclusion' => ['nullable', 'string'],
            'follow_up' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'meeting_date.required' => 'Tanggal rapat wajib diisi.',
            'meeting_date.date' => 'Tanggal rapat tidak valid.',
            'location.required' => 'Lokasi rapat wajib diisi.',
            'location.string' => 'Lokasi rapat harus berupa teks.',
            'location.max' => 'Lokasi rapat may not be greater than 255 characters.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'start_time.date_format' => 'Waktu mulai tidak valid. Gunakan format HH:MM atau HH:MM:SS.',
            'end_time.date_format' => 'Waktu selesai tidak valid. Gunakan format HH:MM atau HH:MM:SS.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'meeting_type.string' => 'Tipe rapat harus berupa teks.',
            'meeting_type.max' => 'Tipe rapat may not be greater than 255 characters.',
            'leader.string' => 'Pimpinan rapat harus berupa teks.',
            'leader.max' => 'Pimpinan rapat may not be greater than 255 characters.',
            'invited_count.integer' => 'Jumlah undangan harus berupa angka bulat.',
            'invited_count.min' => 'Jumlah undangan tidak boleh kurang dari 0.',
            'attended_count.integer' => 'Jumlah hadir harus berupa angka bulat.',
            'attended_count.min' => 'Jumlah hadir tidak boleh kurang dari 0.',
            'agenda.string' => 'Agenda harus berupa teks.',
            'discussion.string' => 'Pembahasan harus berupa teks.',
            'conclusion.string' => 'Kesimpulan harus berupa teks.',
            'follow_up.string' => 'Tindak lanjut harus berupa teks.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator)->withInput();
    }
}
