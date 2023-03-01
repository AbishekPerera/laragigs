<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'tags' => $this->faker->words(3, true),
            'company' => $this->faker->company, 
            'location' => $this->faker->city,
            'email' => $this->faker->email,
            'website' => $this->faker->domainName,
            'description' => $this->faker->paragraph(5),
        ];
    }
}
