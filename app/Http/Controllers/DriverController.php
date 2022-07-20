<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia ;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

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
                ->where('user_id' , $request->customerId)
                ->where('status' , $request->status); 
            
        if($request->orderStatus == 'cancelled') { 
            if($request->remarks) { 

                foreach($orders as $o) {
                    $o->status = $request->orderStatus; 
                    $o->remarks = $request->remarks;  
                    $o->save();  
                }

                return redirect()->back()->with('success' , 'Order status successfully updated ! ');
            }
            else { 
                return redirect()->back()->with('error' , 'Remarks for cancelled orders is mandatory');
            }
        }

        foreach($orders as $o) {
            $o->status = $request->orderStatus; 
            $o->save();  
        }

        return redirect()->back()->with('success' , 'Order status successfully updated ! ');

    }
}
