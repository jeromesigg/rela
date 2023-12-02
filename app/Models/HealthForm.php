<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use OwenIt\Auditing\Contracts\Auditable;

class HealthForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'id','code', 'nickname', 'last_name', 'first_name', 'street', 'zip_code', 'city', 'group_id', 'emergency_contact_name', 'emergency_contact_address', 'emergency_contact_phone', 'ahv',
        'doctor_contact', 'health_insurance_contact', 'accident_insurance_contact',
        'liability_insurance_contact', 'finish', 'birthday', 'phone_number', 'swimmer', 'vaccination', 'file_allergies', 'camp_id'
    ];

    protected $connection = 'mysql_info';
    public $timestamps = false;

    public $incrementing = false;

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function health_form_questions()
    {
        return $this->hasMany(HealthInformationQuestion::class);
    }

    public function getCodeAttribute($value)
    {
        return Crypt::decryptString($value);
    }

}
