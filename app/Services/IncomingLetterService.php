<?php

namespace App\Services;

use App\Models\IncomingLetter;
use Illuminate\Support\Facades\Storage;

class IncomingLetterService
{
    public function createIncomingLetter($data)
    {
        try {
            // Handle file upload
            $filePath = null;
            if (isset($data['file']) && $data['file']) {
                $file = $data['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('incoming_letters', $fileName, 'public');
            }

            $incomingLetter = IncomingLetter::create([
                'letter_number' => $data['letter_number'],
                'received_date' => $data['received_date'],
                'letter_date' => $data['letter_date'],
                'sender' => $data['sender'],
                'subject' => $data['subject'],
                'has_attachment' => $data['has_attachment'] ?? false,
                'file' => $filePath,
            ]);

            // Handle dispositions
            if (isset($data['dispositions']) && is_array($data['dispositions'])) {
                foreach ($data['dispositions'] as $disposition) {
                    if (!empty($disposition['disposition_to'])) {
                        $incomingLetter->letterDispositions()->create([
                            'disposition_to' => $disposition['disposition_to'],
                            'instructions' => $disposition['instructions'] ?? null,
                            'disposition_date' => $disposition['disposition_date'] ?? null,
                            'from' => $disposition['from'] ?? null,
                            'priority' => $disposition['priority'] ?? 'normal',
                        ]);
                    }
                }
            }

            return $incomingLetter;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getIncomingLetterById($id)
    {
        return IncomingLetter::find($id);
    }

    public function updateIncomingLetter($incomingLetter, $data)
    {
        try {
            // Handle file upload
            $filePath = $incomingLetter->file;
            if (isset($data['file']) && $data['file']) {
                // Delete old file if exists
                if ($incomingLetter->file && Storage::disk('public')->exists($incomingLetter->file)) {
                    Storage::disk('public')->delete($incomingLetter->file);
                }

                $file = $data['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('incoming_letters', $fileName, 'public');
            }

            $incomingLetter->update([
                'letter_number' => $data['letter_number'],
                'received_date' => $data['received_date'],
                'letter_date' => $data['letter_date'],
                'sender' => $data['sender'],
                'subject' => $data['subject'],
                'has_attachment' => $data['has_attachment'] ?? $incomingLetter->has_attachment,
                'file' => $filePath,
            ]);

            // Handle dispositions - delete old ones and create new ones
            if (isset($data['dispositions'])) {
                // Delete existing dispositions
                $incomingLetter->letterDispositions()->delete();

                // Create new dispositions
                if (is_array($data['dispositions'])) {
                    foreach ($data['dispositions'] as $disposition) {
                        if (!empty($disposition['disposition_to'])) {
                            $incomingLetter->letterDispositions()->create([
                                'disposition_to' => $disposition['disposition_to'],
                                'instructions' => $disposition['instructions'] ?? null,
                                'disposition_date' => $disposition['disposition_date'] ?? null,
                                'from' => $disposition['from'] ?? null,
                                'priority' => $disposition['priority'] ?? 'normal',
                            ]);
                        }
                    }
                }
            }

            return $incomingLetter;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteIncomingLetter($incomingLetter)
    {
        try {
            // Delete file if exists
            if ($incomingLetter->file && Storage::disk('public')->exists($incomingLetter->file)) {
                Storage::disk('public')->delete($incomingLetter->file);
            }

            $incomingLetter->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
