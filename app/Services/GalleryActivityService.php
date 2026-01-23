<?php

namespace App\Services;

use App\Models\GalleryVillageActivity;
use Illuminate\Support\Facades\Storage;

class GalleryActivityService
{
    /**
     * Upload multiple images for village activity
     *
     * @param array $images
     * @param int $villageActivityId
     * @return array
     */
    public function uploadImages(array $images, int $villageActivityId)
    {
        $uploadedImages = [];

        foreach ($images as $image) {
            try {
                // Store image to public storage
                $imagePath = $image->store('gallery-village-activities', 'public');

                // Save to database
                $gallery = GalleryVillageActivity::create([
                    'village_activity_id' => $villageActivityId,
                    'image' => $imagePath,
                ]);

                $uploadedImages[] = $gallery;
            } catch (\Throwable $th) {
                // If one image fails, continue with others
                continue;
            }
        }

        return $uploadedImages;
    }

    /**
     * Delete image from storage and database
     *
     * @param int $galleryId
     * @return bool
     */
    public function deleteImage(int $galleryId)
    {
        try {
            $gallery = GalleryVillageActivity::findOrFail($galleryId);

            // Delete from storage
            if (Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            // Delete from database
            $gallery->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
