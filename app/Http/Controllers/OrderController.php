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
       
        $order = Order::findorfail($request->id); 
        $order->status = $request->status; 
        $order->driver_name = $request->driverName; 
        $order->driver_id = $driver[0]->id;  
        $order->save(); 

        return redirect()->route('admin.orders')->with('success' , 'Order Successfully updated ');

    }

    
}
