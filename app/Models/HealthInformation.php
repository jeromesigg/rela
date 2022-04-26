<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'recent_issues', 'recent_issues_doctor', 'drugs', 'drugs_only_contact', 'chronicle_diseases'
    ];

    public function allergies(){
        return $this->hasMany(AllergyHealthInformation::class, 'health_information_id');
    }

    public function observations(){
        return $this->hasMany(Observation::class, 'health_information_id');
    }

    public function healthstatus(){
        return $this->observations()->where('observation_class_id','=',config('observations.healthstatus'));
    }

    public function incidents(){
        return $this->observations()->where('observation_class_id', '=', config('observations.incident'));
    }

    public function measures(){
        return $this->observations()->where('observation_class_id', '=', config('observations.measure'));
    }

    public function medications(){
        return $this->observations()->where('observation_class_id', '=', config('observations.medication'));
    }

    public function monitorings(){
        return $this->observations()->where('observation_class_id', '=', config('observations.monitoring'));
    }

    public function surveillances(){
        return $this->observations()->where('observation_class_id', '=', config('observations.surveillance'));
    }

    public function getRouteKeyName()
    {
        return 'code';
    }


}
