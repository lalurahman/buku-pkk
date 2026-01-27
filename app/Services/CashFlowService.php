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
            'receipt_number' => $this->generateReceiptNumber(),
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

    private function generateReceiptNumber(): string
    {
        $latestCashFlow = CashFlow::orderBy('created_at', 'desc')->first();
        $nextNumber = $latestCashFlow ? ((int) substr($latestCashFlow->receipt_number, -4)) + 1 : 1;
        return 'RCPT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
