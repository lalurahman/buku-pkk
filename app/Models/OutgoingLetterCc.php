<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetterCc extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function outgoingLetter()
    {
        return $this->belongsTo(OutgoingLetter::class);
    }
}
