<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $address = ['Yangon','Bagan','Mandalay','Shan State'];
        return [
           'title' => $this->faker->sentence(8),
           'description' => $this->faker->text(500),
           'address' => $address[array_rand($address)],
           'price' => rand(10000,50000),
           'rating' => rand(0,5),
        ];
    }
}
