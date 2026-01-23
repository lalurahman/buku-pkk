<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    protected $guarded = [];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function villageActivities()
    {
        return $this->hasMany(VillageActivity::class, 'sub_activity_id');
    }
}
