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

    public function healthstatus(){
        return $this->hasMany(HealthStatus::class, 'health_information_id');
    }

    public function incidents(){
        return $this->hasMany(Incident::class, 'health_information_id');
    }

    public function measures(){
        return $this->hasMany(Measure::class, 'health_information_id');
    }

    public function medications(){
        return $this->hasMany(Medication::class, 'health_information_id');
    }

    public function monitorings(){
        return $this->hasMany(Monitoring::class, 'health_information_id');
    }

    public function surveillances(){
        return $this->hasMany(Surveillance::class, 'health_information_id');
    }

    public function getRouteKeyName()
    {
        return 'code';
    }


}
