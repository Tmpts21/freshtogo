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
            'postal_code' => '4114' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823',
            'status' => 'active' 


        ]);

        \App\Models\User::factory()->create([
            'name' => 'ian vincent driver',
            'email' => 'driver123@mail.com',
            'role' => 'driver',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823' ,
            'status' => 'active' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'jhun juhn driver',
            'email' => 'driver321@mail.com',
            'role' => 'driver',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy valenzuela',
            'contact_no' => '09163410823' ,
            'status' => 'active' 

        ]);

        \App\Models\User::factory()->create([
            'name' => 'regular customer',
            'email' => 'customer@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Makati',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823' ,
            'status' => 'active' 


        ]);

        \App\Models\User::factory()->create([
            'name' => 'jhun jhun customer',
            'email' => 'customer321@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Las Pinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823',
            'status' => 'active' 


        ]);

        \App\Models\User::factory()->create([
            'name' => 'ian vincent customer ',
            'email' => 'customer123@mail.com',
            'role' => 'customer',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Las Pinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy makati',
            'contact_no' => '09163410823',
            'status' => 'active' 


        ]);

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            'street_address' => 'Blk 23 Lt 2 Ph 6 Dasma3' ,
            'city' => 'Dasmarinas',
            'postal_code' => '4114' ,
            'barangay' => 'Brngy Salawag' ,
            'contact_no' => '09163410823',
            'status' => 'active' 
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


        $months = ['january','february','march','april','may','june','july','august','september','october','november','december'];
        $customer_ids = [4 , 5 , 6 ]; 
        $product_ids = [1 ,  2 , 3 ] ; 

        $product_names = ['porkchops' , 'chicken neck' , 'chicken breast' ,'chicken thighs' , 'pork belly' ,'wagyu beef' ,'beef tapa'];
        $statuses = ['cancelled' , 'pending' , 'delivered'] ; 

        for($i = 0 ; $i <= 5 ; $i++ ) { 
            $random_quantity = [1,2 , 3 , 5 ] ;
            $unique_id = substr(md5(mt_rand()), 0, 8);
            for($x = 0 ; $x < $random_quantity[array_rand($random_quantity , 1 )] ; $x++) { 
                \App\Models\Order::factory()->create([
                    'product_id' => $product_ids[array_rand($product_ids , 1)],
                    'user_id' => $customer_ids[array_rand($customer_ids , 1)],
                    'status' => $statuses[array_rand($statuses , 1)],
                    'customer_name' => 'Ian Vincent Tampos' ,
                    'product_name' => $product_names[array_rand($product_names , 1)] , 
                    'total_price' => rand( 500  , 1000) ,
                    'deliveryFee' => rand(101 , 115), 
                    'quantity' => rand(5 , 15), 
                    'mop' => 'Cash On Delivery', 
                    'address' => 'Cavite' , 
                    'unique_id' => $unique_id, 
                    'image' => 'image/products/dZMQdmrdJVa7WRtI2IAsJhEIBiirQyGfS7yVQKwB.jpg'
                ]);  
            }
        }
        
    }
}
