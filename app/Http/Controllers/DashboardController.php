<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Product ;
use App\Models\Order ;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function redirects() { 
        if(Auth::user()->role == 'admin') { 
            return redirect('/admin');
        }
        if(Auth::user()->role == 'driver') { 
            return redirect('/driver');
        }
        if(Auth::user()->role == 'customer') { 
            return redirect('/dashboard');
        }
    }

    
    public function customer_index() { 
        $products = Product::all();
        $categories = Category::all();  
        return Inertia::render('Customer/Dashboard' , [
            'products' => $products ,
            'categories' => $categories]); 
    }

    public function admin_index() { 
        return Inertia::render("Admin/AdminDashboard"); 
    }

    public function driver_index() {

        $orders = DB::table('orders')->select('*' , DB::raw('count(*) as total'))->groupBy('user_id')->get();

        return Inertia::render('Driver/DriverDashboard' ,[
                        'orders' => $orders ,]); 
    }

    public function profile() { 
        return Inertia::render('Profile'); 
    }

    public function update_profile(Request $request) { 

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'required|integer',
            'contact_no' => 'required|string|max:11',
        ]);

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image/profile', 'public');
            $validated['image'] = $image_path ; 
        }

        

        if(Auth::user()->update($validated)) { 
            return redirect()->back()->with('success' , 'Profile Successfully Updated ! ');
        }

        return redirect()->back()->with('error' , 'Something went wrong please check your inputs ! ');

    }   
    
}
