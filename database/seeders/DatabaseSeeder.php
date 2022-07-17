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
            'name' => 'regular driver',
            'email' => 'driver@mail.com',
            'role' => 'driver',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => 'Valenzuela' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'ian vincent driver',
            'email' => 'driver123@mail.com',
            'role' => 'driver',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => 'Valenzuela' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823' 
        ]);

        \App\Models\User::factory()->create([
            'name' => 'jhun juhn driver',
            'email' => 'driver321@mail.com',
            'role' => 'driver',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => 'Valenzuela' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823' 
        ]);

        \App\Models\User::factory()->create([
            'name' => 'regular customer',
            'email' => 'customer@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Makati',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'jhun jhun customer',
            'email' => 'customer321@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Las Pinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'ian vincent customer ',
            'email' => 'customer123@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Las Pinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy Salawag' ,
            'contact_no' => '09163410823' 
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
        \App\Models\Product::factory(3)->create();

    }
}
