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
            'name' => $this->faker->randomElement(['porkchops' , 'chicken neck' , 'chicken breast' ,'chicken thighs' , 'pork belly' ,'wagyu beef' ,'beef tapa']),
            'category_id' => $this->faker->randomElement([1 , 2 , 3 ]),
            'brand' => $this->faker->randomElement(['Magnolia' ,'tender juicy','Monterey']),
            'stock' => $this->faker->numberBetween(5 , 50),
            'price' => $this->faker->numberBetween(100 , 115),
            'description' =>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam accusantium dolor, omnis provident rem dolore unde incidunt neque explicabo quos numquam, sed sunt? Iusto doloribus enim nam ab suscipit ratione!',
        ];
    }
}
