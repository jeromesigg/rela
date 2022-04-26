<?php

namespace Database\Factories;

use App\Models\HealthInformation;
use App\Models\Observation;
use App\Models\ObservationClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Observation::class;
    public function definition()
    {
        return [
            //
            'date' => $this->faker->dateTimeBetween('-7 days', 'now'),
            'time' => $this->faker->time(),
            'parameter' => $this->faker->word(2, true),
            'value' => $this->faker->word(),
            'comment' => $this->faker->sentence(),
            'user_id' => 1,
            'observation_class_id' => ObservationClass::pluck('id')[$this->faker->numberBetween(0,ObservationClass::count()-1)],
            'health_information_id' => HealthInformation::pluck('id')[$this->faker->numberBetween(0,HealthInformation::count()-1)]
        ];
    }
}
