<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area' => $this->faker->streetName(),
            'bedrooms' => $this->faker->randomDigitNot(0),
            'rent' => floor($this->faker->numberBetween(500, 1500) / 10) * 10,
            'start_date' => $this->faker->dateTimeBetween('now', '+ 2 months'),
            'end_date' => $this->faker->dateTimeBetween('+ 2 months', '+ 6 months')
        ];
    }
}
