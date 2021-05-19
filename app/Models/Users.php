<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Users extends Model implements AuthenticatableContract
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory,Authenticatable;
    // protected $table='users';
    protected $fillable=[
        'login',
        'password',
        'name',
        'email',
        'profile_pictures',
        'faves',
        'rating',
        'role'
    ];
    protected $casts = [
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
        'login' => 'string',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'picture' => 'integer',
        'rating' => 'integer',
        'role' => 'string'
    ];
}
