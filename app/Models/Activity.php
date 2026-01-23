<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subActivities()
    {
        return $this->hasMany(SubActivity::class, 'activity_id');
    }

    public function targetActivities()
    {
        return $this->hasMany(TargetActivity::class, 'activity_id');
    }

    public function innovationActivities()
    {
        return $this->hasMany(InnovationActivity::class, 'activity_id');
    }

    public function impactActivities()
    {
        return $this->hasMany(ImpactActivity::class, 'activity_id');
    }
}
