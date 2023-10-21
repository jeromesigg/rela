<?php

namespace Database\Factories;

use App\Helper\Helper;
use App\Http\Controllers\HealthFormController;
use App\Models\Group;
use App\Models\HealthForm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthForm>
 */
class HealthFormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = HealthForm::class;
    public function definition()
    {
        $code =  Helper::generateUniqueCode();
        return [
            //

            'code' => Crypt::encryptString($code),
            'first_name' =>  $this->faker->firstName(),
            'last_name' =>  $this->faker->lastName(),
            'nickname' => $this->faker->word(),
            'street' =>  $this->faker->streetAddress(),
            'zip_code' =>  $this->faker->postcode(),
            'city' =>  $this->faker->city(),
            'birthday' =>  $this->faker->date(),
            'ahv' => $this->faker->ahv13(),
            'phone_number' => $code,
            'group_id' => Group::pluck('id')[$this->faker->numberBetween(0,Group::count()-1)]
        ];
    }
}
