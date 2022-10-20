<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia ;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DriverController extends Controller
{
    public function edit($id) { 
        $order = Order::findorfail($id); 
        
        return Inertia::render('Driver/UpdateOrderStatus' , ['order' => $order ]) ;
    }

    public function view($id) { 
        $order = Order::findorfail($id);

        return Inertia::render('Driver/EditOrder' , ['order' => $order]) ; 

    }

    public function update(Request $request) { 

        if(!$request->orderStatus) { 
            return redirect()->back()->with('error' , 'Status is required');
        }
        
        $order = Order::findorfail($request->orderId);

        $orders = Order::all()
                ->where('unique_id' , $order->unique_id)
                ->where('driver_id' , Auth::user()->id); 

            
        if($request->orderStatus == 'cancelled') { 
            if($request->remarks) { 
                
                foreach($orders as $o) {
                    $product = Product::findorfail($order->product_id); 
                    $product->stock = $product->stock += $order->quantity ; 
                    $product->save(); 

                    $o->status = $request->orderStatus; 
                    $o->payment_status = 'cancelled'; 
                    $o->remarks = $request->remarks;  
                    $o->save();  
                }

                return redirect()->route('driver')->with('success' , 'Order Successfully Updated ! ');

            }
            else { 
                return redirect()->back()->with('error' , 'Remarks for cancelled orders is mandatory');
            }
        }

        foreach($orders as $o) {
            //update how many sold in product 
            $product = Product::findorfail($o->product_id);
            $product->sold = $product->sold += $order->quantity;
            $product->save(); 
            $o->status = $request->orderStatus; 
            $o->payment_status = 'paid';
            $o->save();  
        }

        return redirect()->back()->with('success' , 'Order status successfully updated ! ');

    }

    public function viewOrders($id , $status) { 
        $order = Order::findorfail($id); 
        $orders = Order::all()
                        ->where('unique_id', $order->unique_id)
                        ->where('driver_id' , $order->driver_id);

        $totalPrice = 0 ; 
        $deliveryFee = 0;
        
        foreach($orders as $o) {             
            $totalPrice += $o->total_price ;
            $deliveryFee = $o->deliveryFee ; 
        }

        return Inertia::render('Driver/ViewOrders' , [
                'orders' => $orders ,
                'deliveryFee' => $deliveryFee , 
                'totalPrice' => $totalPrice + $deliveryFee
            ]) ;
    }

    public function updateDriverPosition(Request $request) { 
        $user = User::findorfail(Auth::user()->id); 
        $user->lat = $request->lat ; 
        $user->lon = $request->lon ; 
        $user->save();
    }

    
}
