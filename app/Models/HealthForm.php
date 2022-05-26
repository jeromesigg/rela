<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use OwenIt\Auditing\Contracts\Auditable;
use Khalyomede\EloquentUuidSlug\Sluggable;

class HealthForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'id','code', 'nickname', 'last_name', 'first_name', 'street', 'zip_code', 'city', 'group_id', 'emergency_contact_name', 'emergency_contact_address', 'emergency_contact_phone',
        'doctor_contact', 'health_insurance_contact', 'accident_insurance_contact', 'liability_insurance_contact', 'finish', 'birthday', 'phone_number', 'swimmer', 'file_vaccination', 'file_allergies'
    ];

    protected $connection = 'mysql_info';

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function getCodeAttribute($value)
    {
        return Crypt::decryptString($value);
    }

}
