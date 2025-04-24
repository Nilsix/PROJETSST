<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $fillable = [
        'site'
    ];

    public function agents(){
        return $this->hasMany(Agent::class);
    }
}
