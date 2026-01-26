<?php

namespace App\Services;

use App\Models\OutgoingLetter;
use Illuminate\Support\Facades\Storage;

class OutgoingLetterService
{
    public function createOutgoingLetter($data)
    {
        try {
            // Handle file upload
            $filePath = null;
            if (isset($data['file']) && $data['file']) {
                $file = $data['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('outgoing_letters', $fileName, 'public');
            }

            $outgoingLetter = OutgoingLetter::create([
                'letter_number' => $data['letter_number'],
                'letter_date' => $data['letter_date'],
                'recipient' => $data['recipient'],
                'subject' => $data['subject'],
                'has_attachment' => $data['has_attachment'] ?? false,
                'file' => $filePath,
            ]);

            // Handle CC recipients
            if (isset($data['cc_recipients']) && is_array($data['cc_recipients'])) {
                foreach ($data['cc_recipients'] as $ccRecipient) {
                    if (!empty($ccRecipient)) {
                        $outgoingLetter->outgoingLetterCcs()->create([
                            'cc_recipient' => $ccRecipient,
                        ]);
                    }
                }
            }

            return $outgoingLetter;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOutgoingLetterById($id)
    {
        return OutgoingLetter::find($id);
    }

    public function updateOutgoingLetter($outgoingLetter, $data)
    {
        try {
            // Handle file upload
            $filePath = $outgoingLetter->file;
            if (isset($data['file']) && $data['file']) {
                // Delete old file if exists
                if ($outgoingLetter->file && Storage::disk('public')->exists($outgoingLetter->file)) {
                    Storage::disk('public')->delete($outgoingLetter->file);
                }

                $file = $data['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('outgoing_letters', $fileName, 'public');
            }

            $outgoingLetter->update([
                'letter_number' => $data['letter_number'],
                'letter_date' => $data['letter_date'],
                'recipient' => $data['recipient'],
                'subject' => $data['subject'],
                'has_attachment' => $data['has_attachment'] ?? $outgoingLetter->has_attachment,
                'file' => $filePath,
            ]);

            // Handle CC recipients - delete old ones and create new ones
            if (isset($data['cc_recipients'])) {
                // Delete existing CCs
                $outgoingLetter->outgoingLetterCcs()->delete();

                // Create new CCs
                if (is_array($data['cc_recipients'])) {
                    foreach ($data['cc_recipients'] as $ccRecipient) {
                        if (!empty($ccRecipient)) {
                            $outgoingLetter->outgoingLetterCcs()->create([
                                'cc_recipient' => $ccRecipient,
                            ]);
                        }
                    }
                }
            }

            return $outgoingLetter;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteOutgoingLetter($outgoingLetter)
    {
        try {
            // Delete file if exists
            if ($outgoingLetter->file && Storage::disk('public')->exists($outgoingLetter->file)) {
                Storage::disk('public')->delete($outgoingLetter->file);
            }

            $outgoingLetter->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
