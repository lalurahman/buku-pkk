<?php

namespace App\Services;

use App\Models\GuestBook;

class GuestBookService
{
    /**
     * Create a new guest book record
     */
    public function createGuestBook(array $data): GuestBook
    {
        $guestBook = GuestBook::create([
            'visitor_name' => $data['visitor_name'],
            'visit_date' => $data['visit_date'],
            'institution' => $data['institution'],
            'purpose' => $data['purpose'],
            'impressions' => $data['impressions'] ?? null,
        ]);

        return $guestBook;
    }

    /**
     * Get guest book by ID
     */
    public function getGuestBookById(string $id): ?GuestBook
    {
        return GuestBook::findOrFail($id);
    }

    /**
     * Update an existing guest book record
     */
    public function updateGuestBook(GuestBook $guestBook, array $data): GuestBook
    {
        $guestBook->update([
            'visitor_name' => $data['visitor_name'],
            'visit_date' => $data['visit_date'],
            'institution' => $data['institution'],
            'purpose' => $data['purpose'],
            'impressions' => $data['impressions'] ?? $guestBook->impressions,
        ]);

        return $guestBook->fresh();
    }

    /**
     * Delete a guest book record
     */
    public function deleteGuestBook(GuestBook $guestBook): bool
    {
        return $guestBook->delete();
    }
}
