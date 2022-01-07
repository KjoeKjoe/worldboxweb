<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SlaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->name(),
        ];
    }
}
