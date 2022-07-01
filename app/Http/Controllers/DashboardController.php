<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Product ;

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
        return Inertia::render('Driver/DriverDashboard'); 
    }
    
}
