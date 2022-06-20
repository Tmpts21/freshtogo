<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        //generate all three type of users 

        \App\Models\User::factory()->create([
            'name' => 'driver',
            'email' => 'driver@mail.com',
            'role' => 'driver',

        ]);

        \App\Models\User::factory()->create([
            'name' => 'customer',
            'email' => 'customer@mail.com',
            'role' => 'customer',

        ]);

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',

        ]);

        // generate Category 

        \App\Models\Category::factory()->create([
            'name' => 'chicken',
        ]);

        \App\Models\Category::factory()->create([
            'name' => 'pork',
        ]);

        \App\Models\Category::factory()->create([
            'name' => 'beef',
        ]);

        
        // generate some products
        \App\Models\Product::factory(15)->create();

    }
}
