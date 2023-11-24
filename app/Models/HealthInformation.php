<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class HealthInformation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SearchableTrait;
    use HasUuid;

    protected $fillable = [
        'code', 'recent_issues', 'recent_issues_doctor', 'drug_longterm', 'drug_demand', 'drug_emergency', 'drugs_only_contact',
        'ointment_only_contact', 'chronicle_diseases', 'file_protocol', 'allergy', 'camp_id', 'health_status_id', 'accept_privacy_agreement'
    ];

    protected $searchable = [
        'columns' => [
            'code' => 1,
        ]
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function interventions(){
        return $this->hasMany(Intervention::class, 'health_information_id');
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

    public function health_status(){
        return $this->belongsTo(HealthStatus::class);
    }

    public function questions()
    {
        return $this->hasMany(HealthInformationQuestion::class);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

}
