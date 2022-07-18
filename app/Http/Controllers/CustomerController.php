<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia ;

class CustomerController extends Controller
{
    public function place_order(Request $request) { 
        foreach($request->data['cart'] as $product) { 
            $prod = json_decode($product);
            // create orders for individual product
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
                'mop' => $request->data['mop'] 
            ]);
        }

         return redirect()->route('customer.orders')->with('success' , 'Thanks for trusting fresh to go your order is now on the way :) ');
  

    }

    public function orders() { 

        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->orderBy('created_at' ,'desc')->get();
        
        return Inertia::render('Customer/Orders' , ['orders' => $orders]); 

        
    }

}
