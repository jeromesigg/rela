<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;
    public static function boot()
    {
        parent::boot();

        // here assign this team to a global user with global default role
        self::created(function (Camp $camp) {
            // get the admin user and assign roles/permissions on new team model
            CampUser::create([
                'user_id' => 1,
                'role_id' => config('status.role_Administrator'),
                'camp_id' => $camp['id'],
            ]);
        });
    }

    protected $fillable = [
        'name', 'user_id', 'independent_form_fill', 'global_camp', 'finish', 'code', 'end_date'
    ];

    protected $casts = [
        'independent_form_fill' => 'boolean',
        'global_camp' => 'boolean',
        'demo' => 'boolean',
        'finish' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function allUsers()
    {
        return $this->belongsToMany('App\Models\User', 'camp_users')->where('camp_users.role_id', '<>', config('status.role_Administrator'));
    }

    public function camp_users_all()
    {
        return $this->hasMany(CampUser::class)->where('camp_users.role_id', '<>', config('status.role_Administrator'));
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->where('questions.active', '=',true);
    }

    public function interventions()
    {
        return $this->hasManyThrough(Intervention::class, HealthInformation::class);
    }

}
