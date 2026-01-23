<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceFund extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cashFlows()
    {
        return $this->hasMany(CashFlow::class);
    }
}
