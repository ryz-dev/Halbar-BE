<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['username', 'email', 'password', 'fullname', 'image', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'users_id', 'id');
    }

    public function checkout()
    {
        return $this->hasMany(Checkout::class, 'users_id', 'id');
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
