<?php

namespace Database\Factories;

use App\Models\HealthInformation;
use App\Models\Intervention;
use App\Models\InterventionClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Intervention::class;
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
            'intervention_class_id' => InterventionClass::pluck('id')[$this->faker->numberBetween(0,InterventionClass::count()-1)],
            'health_information_id' => HealthInformation::pluck('id')[$this->faker->numberBetween(0,HealthInformation::count()-1)]
        ];
    }
}
