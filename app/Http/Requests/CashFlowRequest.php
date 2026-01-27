<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CashFlowRequest extends FormRequest
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
            'type' => ['required', 'in:income,expense'],
            'source_fund_id' => ['required', 'exists:source_funds,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Tipe arus kas wajib diisi.',
            'type.in' => 'Tipe arus kas tidak valid.',
            'source_fund_id.required' => 'Sumber dana wajib diisi.',
            'source_fund_id.exists' => 'Sumber dana tidak valid.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Tanggal tidak valid.',
            'amount.required' => 'Jumlah wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah tidak boleh kurang dari 0.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator)->withInput();
    }
}
