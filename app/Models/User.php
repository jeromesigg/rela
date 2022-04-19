<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_Admin', 'is_Manager', 'is_Helper', 'slug'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_Admin' => 'boolean',
        'is_Manager' => 'boolean',
        'is_Helper' => 'boolean',
    ];

    public function isAdmin(){
        return ($this['is_Admin'] == 1);
    }

    public function isManager(){
        return (($this['is_Manager'] == 1 )|| $this->isAdmin());
    }

    public function isHelper(){
        return (($this['is_Helper'] == 1) || $this->isManager());
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
