<?php

namespace App\Services;

use App\Models\CashFlow;

class CashFlowService
{
    /**
     * Create a new cash flow record
     */
    public function createCashFlow(array $data): CashFlow
    {
        $cashFlow = CashFlow::create([
            'type' => $data['type'],
            'source_fund_id' => $data['source_fund_id'],
            'receipt_number' => $data['receipt_number'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
        ]);

        return $cashFlow;
    }

    /**
     * Get cash flow by ID
     */
    public function getCashFlowById(string $id): ?CashFlow
    {
        return CashFlow::with('sourceFund')->findOrFail($id);
    }

    /**
     * Update an existing cash flow record
     */
    public function updateCashFlow(CashFlow $cashFlow, array $data): CashFlow
    {
        $cashFlow->update([
            'type' => $data['type'],
            'source_fund_id' => $data['source_fund_id'],
            'receipt_number' => $data['receipt_number'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? $cashFlow->description,
        ]);

        return $cashFlow->fresh();
    }

    /**
     * Delete a cash flow record
     */
    public function deleteCashFlow(CashFlow $cashFlow): bool
    {
        return $cashFlow->delete();
    }
}
