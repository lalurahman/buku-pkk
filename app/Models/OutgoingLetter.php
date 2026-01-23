<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function outgoingLetterCcs()
    {
        return $this->hasMany(OutgoingLetterCc::class);
    }
}
