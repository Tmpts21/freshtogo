<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Product ;
use App\Models\Feedback ;
use App\Models\Order ;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;



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
        // get total pending,cancelled and delivered orders 
        $status = DB::table('orders')->select('*' , DB::raw('count(*) as total , SUM(total_price) as totalPrice'))->groupBy('status')->orderBy('status', 'desc')->get();
        // get monthly sales
        $salesPerMonth = [] ; 
        for($i = 1 ; $i <= 12 ; $i++ ){ 
            $orders = Order::query()
            ->whereMonth('created_at', $i)
            ->where('status' , 'delivered')->get();
            $sum = 0; 
            foreach($orders as $order) { 
                $sum+=$order->total_price;
        }       
            array_push($salesPerMonth , $sum);
           

        }

        // count kg's sold per product

        $kgSoldPerProduct = DB::table('orders')->where('status' , 'delivered')->select('*' , DB::raw('SUM(quantity) as total_quantity'))->groupBy('product_name')->get();
        $totalKgSoldPerProduct = [] ; 
        $productNames = []; 
        $allProduct = []; 
        foreach($kgSoldPerProduct as $kg) { 
            array_push($totalKgSoldPerProduct , $kg->total_quantity); 
            array_push($productNames , $kg->product_name);
        }
        foreach(Product::all() as $product) { 
            array_push($allProduct , $product->name) ; 
        }
        $productNames = array_unique(array_merge($allProduct , $productNames));
        

        return Inertia::render("Admin/AdminDashboard" ,
                    ['statusTotal' => $status,
                     'productNames' => $productNames , 
                     'kgPerProduct' => $totalKgSoldPerProduct , 
                     'salesPerMonth' => $salesPerMonth ,
                ]); 
    }

    public function driver_index() {

        // dd(Order::all()->where('driver_id' , Auth::user()->id)
        //                 ->where('status' , 'assigned'));

        $orders = DB::table('orders')->select('*' , DB::raw('count(*) as total'))
        ->where('driver_id' , Auth::user()->id)->groupBy('user_id')
        ->groupBy('unique_id')->get();

        return Inertia::render('Driver/DriverDashboard' ,[
                        'orders' => $orders ,]); 
    }

    public function profile() { 
        return Inertia::render('Profile'); 
    }

    public function edit_profile() { 
        return Inertia::render('EditProfile'); 
    }

    public function update_profile(Request $request) { 

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'required|integer',
            'contact_no' => 'required|string|max:11',
        ]);

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image/profile', 'public');
            $validated['image'] = $image_path ; 
            $validated['name'] = "{$request->firstName} {$request->middleName} {$request->lastName}" ; 

        }

        

        if(Auth::user()->update($validated)) { 
            return redirect()->route('profile')->with('success' , 'Profile Successfully Updated ! ');
        }

        return redirect()->back()->with('error' , 'Something went wrong please check your inputs ! ');

    }   

    public function guest_view_product($id) { 
        $product = Product::findorfail($id); 

        $categories = Category::all(); 

        $feedbacks = Feedback::where('product_id' , $id )->get();

        return Inertia::render('GuestView' , ['product' => $product , 'categories' => $categories ,'feedbacks' => $feedbacks ]);
    }

    public function feedback() { 
        $feedbacks = Feedback::inRandomOrder()->limit(5)->get();

        return Inertia::render('Feedback' , ['feedbacks' => $feedbacks ]);

    }

    public function contact() { 
        return Inertia::render('Contact');
    }

    public function change_password() { 
        return inertia::render('ChangePassword');
    }

    public function update_password(Request $request) { 
        $user =  User::findorfail(Auth::user()->id);

        $request->validate([
            'new' => 'required|string|max:255|min:8',
        ]);

        //check if old password is current password 
        if (!Hash::check($request->old ,$user->password)) { 
            return redirect()->back()->with('error' , 'Old password does not match ! ');
        }

        if($request->new != $request->confirm) { 
            return redirect()->back()->with('error' , 'Confirm Password does not match !');
        }
        
        // update 
        $user->password = Hash::make($request->new); 
        $user->save(); 

        return redirect()->route('profile')->with('success' , 'Password Successfully Changed ! ✨');
    }
    
}
