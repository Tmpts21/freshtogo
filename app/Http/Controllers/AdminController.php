<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia ;
use App\Models\Category;
use App\Models\Product;


class AdminController extends Controller
{

    public function orders() { 
        return Inertia::render('Admin/Orders');
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

}
