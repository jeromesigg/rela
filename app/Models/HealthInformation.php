<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class HealthInformation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SearchableTrait;

    protected $fillable = [
        'code', 'recent_issues', 'recent_issues_doctor', 'drugs', 'drugs_only_contact', 'ointment_only_contact', 'chronicle_diseases'
    ];

    protected $searchable = [
        'columns' => [
            'code' => 1,
        ]
    ];

    public function allergies(){
        return $this->hasMany(AllergyHealthInformation::class, 'health_information_id');
    }

    public function interventions(){
        return $this->hasMany(Intervention::class, 'health_information_id');
    }

    public function healthstatus(){
        return $this->interventions()->where('intervention_class_id','=',config('interventions.healthstatus'));
    }

    public function incidents(){
        return $this->interventions()->where('intervention_class_id', '=', config('interventions.incident'));
    }

    public function measures(){
        return $this->interventions()->where('intervention_class_id', '=', config('interventions.measure'));
    }

    public function medications(){
        return $this->interventions()->where('intervention_class_id', '=', config('interventions.medication'));
    }

    public function monitorings(){
        return $this->interventions()->where('intervention_class_id', '=', config('interventions.monitoring'));
    }

    public function surveillances(){
        return $this->interventions()->where('intervention_class_id', '=', config('interventions.surveillance'));
    }

    public function getRouteKeyName()
    {
        return 'code';
    }


}
