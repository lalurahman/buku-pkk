<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InnovationActivity extends Model
{
    protected $guarded = [];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
