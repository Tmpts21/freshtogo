<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia ;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;




class AdminController extends Controller
{

    public function orders() { 
        
        $orders = DB::table('orders')->select('*' , DB::raw('count(*) as total'))->groupBy('unique_id')->orderBy('created_at' ,'desc')->get();

        return Inertia::render('Admin/Orders' , ['orders' => $orders]);
    }

    public function category() { 

        $categories = Category::all(); 
        foreach($categories as $category) { 
            $category->count = $category->products()->count();
        }

        return Inertia::render('Admin/Category' , ['categories' => $categories]); 
    }

    public function products() { 

        $products = Product::all(); 

        $categories = Category::all(); 

        return Inertia::render('Admin/Product' , [
                'products' => $products ,
                'categories' => $categories
        ]); 

    }

    public function create_category() { 
        return Inertia::render('Category/Create');
    }

    public function save_category(Request $request) { 

        //check if category exists 
        if(Category::where('name' ,'=',$request->name)->count()) { 
            return redirect()->back()->with('error' , 'Category already existing ! ');
        }

        $category = category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success' , 'Category successfully created ! ');

    }

    public function edit_category($id) { 
        $category = Category::findorfail($id); 
        return Inertia::render('Category/Edit' , [
            'category' => $category 
        ]); 

    }

    public function save_edited_category(Request $request) {

        //check if category name exists
        if(Category::where('name' ,'=',$request->name)->count()) { 
            return redirect()->back()->with('error' , 'Category already existing ! ');
        }

        $category = Category::findorfail($request->categoryId); 
        $category->name = $request->name ; 
        $category->save(); 

        return redirect()->back()->with('success' , 'Category Successfully updated ! ');
        
    }

    public function users()  {
       
       $users = User::all(); 

       return Inertia::render('Admin/Users', ['users' => $users ] ); 

    }
    
    public function create_user() { 
        return Inertia::render('Admin/UserCreate');
    }

    public function save_user(Request $request) { 
    
        $validated =  $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'required|integer',
            'contact_no' => 'required|integer',
        ]);

        $fields = $validated;

        //default password
        $fields['password'] = Hash::make('password123');
        $fields['email'] = $request->email;
        $fields['name'] = "{$request->firstName} {$request->middleName} {$request->lastName}"; 
        $fields['role'] = $request->role;

        // check if email is existing 
        if(User::where('email',$request->email)->count()) { 
            return redirect()->back()->with('error' , 'Email already existing ! ');
        }

        $user = User::create($fields);
        
     

        if($user) { 
            return redirect()->back()->with('success' , 'User Successfully created ! ');
        }

        return redirect()->back()->with('error' , 'Something went wrong please check your inputs !');

    }   

    public function view_user($id) { 
        $user = User::findorfail($id); 
        return Inertia::render('Admin/View' , ['user' => $user ]);
    }

    public function edit_status($id) { 
        $user = User::findorfail($id); 
        return Inertia::render('Admin/EditStatus' , ['user' => $user ]);
    }

    public function update_status(Request $request) { 

        $user = User::findorfail($request->id); 
        $user->status = $request->status ;
        $user->save(); 
        if($user->save()) { 
            return redirect()->route('admin.view_user' , ['id' => $user->id])->with('success' , 'User Update Successfully 🎉');
        }

        return redirect()->back()->with('error' , 'Something went wrong please contact your admin');

    }

    

    public function update_user(Request $request) { 

        $validated =  $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'required|integer',
            'contact_no' => 'required|string|max:11',
            'status' => 'required',
            'role' => 'required',
        ]);

        $fields = $validated; 
        unset($fields[0]);

        if(User::findorfail($request->id)->update($fields)){ 
            return redirect()->back()->with('success' , 'User Successfully updated ! ');
        }

        return redirect()->back()->with('error' , 'Something went wrong please check your inputs !');

    }

    public function viewDriverLocation($id) { 
        $user = User::findorfail($id); 
        return Inertia::render('Admin/DriverLocation' ,
             ['lat' => $user->lat , 
             'lon' => $user->lon 
            ]);
    }

}
