<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'numAgent',
        'nomAgent',
        'prenomAgent',
    ];
}
