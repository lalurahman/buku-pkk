<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterDisposition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function incomingLetter()
    {
        return $this->belongsTo(IncomingLetter::class);
    }
}
