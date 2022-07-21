<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia ;

class CustomerController extends Controller
{
    public function place_order(Request $request) {

        if($request->data['mop'] == 'Gcash') {

            if($request->data['gcash_proof_of_payment'] == null || $request->data['gcash_reference_number'] == null  ) { 
                return redirect()->back()->with('error' , 'Proof of payment and Reference number is required');
            };

            if(!is_numeric($request->data['gcash_reference_number']) ) { 
                return redirect()->back()->with('error' , 'Reference number must be a number ');
            };

            $image_path = $request->data['gcash_proof_of_payment']->store('image/payments', 'public');

        }

        $uniqueOrderId = substr(md5(mt_rand()), 0, 7);

        foreach($request->data['cart'] as $product) { 

            $prod = json_decode($product);
            // create orders for individual product

            if($request->data['mop'] == 'Gcash') {

                Order::create([
                    'product_id' => $prod->id,
                    'user_id' => Auth::user()->id ,
                    'status' => 'pending' ,
                    'product_name' => $prod->name ,
                    'customer_name' => Auth::user()->name ,
                    'user_id' => Auth::user()->id ,
                    'total_price' => $prod->total ,
                    'deliveryFee' => $request->data['deliveryCharge'],
                    'quantity' => $prod->quantity,
                    'image' => $prod->image,
                    'mop' => $request->data['mop'] ,
                    'address' => $request->data['address'],
                    'gcash_proof_of_payment' => $image_path,
                    'gcash_reference_number' => $request->data['gcash_reference_number'], 
                    'unique_id' => $uniqueOrderId,
                    'payment_status' => 'paid'

                ]); 
                
            }else { 
                Order::create([
                    'product_id' => $prod->id,
                    'user_id' => Auth::user()->id ,
                    'status' => 'pending' ,
                    'product_name' => $prod->name ,
                    'customer_name' => Auth::user()->name ,
                    'total_price' => $prod->total ,
                    'deliveryFee' => $request->data['deliveryCharge'],
                    'quantity' => $prod->quantity,
                    'image' => $prod->image,
                    'mop' => $request->data['mop'] ,
                    'address' => $request->data['address'],
                    'unique_id' => $uniqueOrderId,
                    'unique_id' => 'pending'


                ]);

            }
            
        }

         return redirect()->route('customer.orders')->with('success' , 'Thanks for trusting fresh to go your order is now on the way :) ');
  

    }

    public function orders() { 

        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->orderBy('created_at' ,'desc')->get();
        
        return Inertia::render('Customer/Orders' , ['orders' => $orders]); 

        
    }

}
