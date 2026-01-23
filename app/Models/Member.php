<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function memberRole()
    {
        return $this->belongsTo(MemberRole::class);
    }

    public function functionalPosition()
    {
        return $this->belongsTo(FunctionalPosition::class);
    }
}
