<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasVillage extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }
}
