<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $cashFlowId = $this->route('cash_flow');

        return [
            'type' => ['required', 'in:income,expense'],
            'source_fund_id' => ['required', 'exists:source_funds,id'],
            'receipt_number' => ['required', 'string', 'max:255', 'unique:cash_flows,receipt_number,' . $cashFlowId],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}
