<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasDistrict extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
