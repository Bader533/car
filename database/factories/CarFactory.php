<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cars>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'owner_id' => 3,
            'car_name' => $this->faker->name(),
            'description' => $this->faker->userName(),
            'price' => '88',
            'fueltype' => 'gasoline',
            'cartype' =>  'Normal',
            'city_id' =>  1,
        ];
    }
}
