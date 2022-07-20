<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() { 

        $orders = DB::table('orders')->orderBy('id' ,'desc')->get();

        return Inertia::render('Admin.Orders' , ['orders' => $orders ]);
    }

    public function edit($id) { 
        $order = Order::findorfail($id); 
        $drivers = User::where('role' , 'driver')->get(); 

        return Inertia::render('Order/Edit' , 
            [
                'order' => $order ,
                'drivers' => $drivers , 
        ]); 

    }

    public function update(Request $request) { 

        $validated = $request->validate([
            'status' => 'required|max:255',
            'driverName' => 'required|max:255',
        ]);

        $driver = User::where('name', $validated['driverName'])->get();
        

        $orders = Order::all()
                ->where('user_id' , $request->customer_id)
                ->where('status' , $request->status); 
                
        foreach($orders as $order) { 
            
            $order->status = $request->status; 
            $order->driver_name = $request->driverName; 
            $order->driver_id = $driver[0]->id;  
            $order->save(); 
        }

        return redirect()->route('admin.orders')->with('success' , 'Order Successfully updated ');

    }

    public function view($id) { 
        $order = Order::findorfail($id); 
        $orders = Order::all()->where('user_id', $order->user_id); 
        $totalPrice = 0 ; 
        $deliveryFee = 0;
        
        foreach($orders as $o) { 
            $totalPrice += $o->total_price ;
            $deliveryFee = $o->deliveryFee ; 
        }

        return Inertia::render('Admin/ViewOrders' , [
                'orders' => $orders ,
                'deliveryFee' => $deliveryFee , 
                'totalPrice' => $totalPrice + $deliveryFee
            ]) ;
    }

    
}
