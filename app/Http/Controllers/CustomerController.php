<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Feedback;
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

        $uniqueOrderId = substr(md5(mt_rand()), 0, 8);

        if($request->data['mop'] == 'Gcash') { 
            $amount_paid = $request->data['gcash_amount_paid'] ;
            $totalAmountToBePaid = $request->data['totalPriceOfAllProductsWithDeliveryFee'];
            $payment_status = '';
            if($amount_paid < $totalAmountToBePaid) { 
                $payment_status = 'partial'; 
            }elseif($amount_paid == $totalAmountToBePaid ) { 
                $payment_status = 'paid';
            }
        }
        

        foreach($request->data['cart'] as $product) { 

            $prod = json_decode($product);
            // create orders for individual product
            $product = Product::find($prod->id); 

            if($request->data['mop'] == 'Gcash') {
               

                $product->stock = $product->stock -= $prod->quantity;
                $product->save();
                
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
                    'gcash_amount_paid' => $request->data['gcash_amount_paid'],
                    'gcash_full_name' => $request->data['gcash_full_name'],
                    'gcash_reference_number' => $request->data['gcash_reference_number'], 
                    'unique_id' => $uniqueOrderId,
                    'payment_status' => $payment_status
                ]); 
                
            }else { 

                $product->stock = $product->stock -= $prod->quantity;
                $product->save();

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
                ]);

            }
            
        }

         return redirect()->route('customer.orders')->with('success' , 'Thanks for trusting freshToGo your order is now on the way 🚀 ');
  

    }

    public function orders() { 

        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->orderBy('created_at' ,'desc')->get();
       
        return Inertia::render('Customer/Orders' , ['orders' => $orders]); 

        
    }

    public function view_product($id) { 
        $product = Product::findorfail($id); 

        $categories = Category::all(); 

        $feedbacks = Feedback::where('product_id' , $id )->get();

        return Inertia::render('Customer/ViewProduct' , ['product' => $product , 'categories' => $categories ,'feedbacks' => $feedbacks ]);
    }

    public function feedback($id , $orderId) { 
        $product = Product::findorfail($id); 

        return Inertia::render('Customer/Feedback' , ['product' => $product ,'orderId' => $orderId]);
    }

    public function save_feedback(Request $request) { 
        $product = Product::findorfail($request->product_id); 
        $feedback = Feedback::create([
            'product_id' => $product->id , 
            'product_name' => $product->name , 
            'stars' => $request->stars , 
            'feedback' => $request->feedback ,
            'user_name' => Auth::user()->name ,
        ]); 

        $order = Order::find($request->orderId);
        $order->is_feedback = 1 ; 
        $order->save(); 

        return redirect()->route('customer.orders')->with('success' , 'Thanks for trusting freshToGo your feedback is successfully saved 🙏 ');
    }

}
