<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'numAgent',
        'nomSite'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
