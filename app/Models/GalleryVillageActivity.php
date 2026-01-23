<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryVillageActivity extends Model
{
    protected $guarded = [];

    public function villageActivity()
    {
        return $this->belongsTo(VillageActivity::class, 'village_activity_id');
    }
}
