<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageActivity extends Model
{
    protected $guarded = [];

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class, 'sub_activity_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function galleries()
    {
        return $this->hasMany(GalleryVillageActivity::class, 'village_activity_id');
    }
}
