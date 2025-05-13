<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vision',
        'numAgent'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected $casts = [
        'password' => 'hashed'
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }
}
