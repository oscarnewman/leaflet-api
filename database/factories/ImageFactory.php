<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $picId = $this->faker->numberBetween(1, 11);
        return [
            'url' => "https://res.cloudinary.com/saythanks/image/upload/v1608836159/leaflet/apt_$picId.jpg",
            'width' => 500,
            'height' => 500,
        ];
    }
}
