<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'category_id' => $this->faker->randomElement([1 , 2 , 3 ]),
            'brand' => $this->faker->randomElement(['Magnolia' ,'tender juicy','Monterey']),
            'quantity' => $this->faker->numberBetween(5 , 50),
            'price' => $this->faker->numberBetween(100 , 115),
        ];
    }
}
