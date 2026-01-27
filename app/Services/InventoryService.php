<?php

namespace App\Services;

use App\Models\Inventory;

class InventoryService
{
    /**
     * Create a new inventory record
     */
    public function createInventory(array $data): Inventory
    {
        $inventory = Inventory::create([
            'name' => $data['name'],
            'source' => $data['source'],
            'received_date' => $data['received_date'],
            'purchase_date' => $data['purchase_date'],
            'quantity' => $data['quantity'],
            'storage_location' => $data['storage_location'],
            'condition' => $data['condition'],
        ]);

        return $inventory;
    }

    /**
     * Get inventory by ID
     */
    public function getInventoryById(string $id): ?Inventory
    {
        return Inventory::findOrFail($id);
    }

    /**
     * Update an existing inventory record
     */
    public function updateInventory(Inventory $inventory, array $data): Inventory
    {
        $inventory->update([
            'name' => $data['name'],
            'source' => $data['source'],
            'received_date' => $data['received_date'],
            'purchase_date' => $data['purchase_date'],
            'quantity' => $data['quantity'],
            'storage_location' => $data['storage_location'],
            'condition' => $data['condition'],
        ]);

        return $inventory->fresh();
    }

    /**
     * Delete an inventory record
     */
    public function deleteInventory(Inventory $inventory): bool
    {
        return $inventory->delete();
    }
}
