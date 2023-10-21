<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_Admin', 'is_Manager', 'is_Helper', 'slug',
        'role_id', 'camp_id'
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
        return ($this->role['is_admin']);
    }

    public function isManager(){
        return (($this->role['is_manager'] )|| $this->isAdmin());
    }

    public function isHelper(){
        return (($this->role['is_helper']) || $this->isManager());
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function camp()
    {
        return $this->belongsTo('App\Models\Camp');
    }

    public function camps()
    {
        return $this->belongsToMany('App\Models\Camp', 'camp_users')->where('finish', '=', false);
    }
}
