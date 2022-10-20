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
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'required|integer',
            'contact_no' => 'required|string|max:11',
        ]);

        $fields = $validated;

        //default password
        $fields['password'] = Hash::make('password123');
        $fields['email'] = $request->email;

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

    public function edit_user($id) { 
        $user = User::findorfail($id); 
        return Inertia::render('Admin/UserEdit' , ['user' => $user ]);
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
        ]);

        $fields = $validated; 
        unset($fields[0]);

        $user = User::findorfail($request->id); 

        if($user){ 
            $user->update($fields); 
            return redirect()->back()->with('success' , 'User Successfully updated ! ');
        }

        return redirect()->back()->with('error' , 'Something went wrong please check your inputs !');

    }

}
