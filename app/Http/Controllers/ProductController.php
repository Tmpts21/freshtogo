<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia ;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index() { 

        $products = Product::all(); 

        $categories = Category::all(); 

        return Inertia::render('Product/Index' , [
                'products' => $products ,
                'categories' => $categories
        ]); 

    }

    public function create() { 

        $categories = Category::all(); 

        return Inertia::render('Product/Create' , ['categories' => $categories ]);

    }

    public function save(Request $request) { 

        if (Product::where('name' ,'=' , $request->name)->count()) return redirect()->back()->with('error' , 'Product name already existing ! ');
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|numeric',
            'brand' => 'required|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $product = Product::Create($validated);

        return redirect()->back()->with('success' , 'Product successfully created ! ');

    }

    public function edit($id) { 
        $product = Product::findorfail($id); 

        $categories = Category::all(); 

        return Inertia::render('Product/Edit' , ['product' => $product , 'categories' => $categories ]);
    }

    public function put(Request $request) { 


        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|numeric',
            'brand' => 'required|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $product = Product::findorfail($request->productId)->update($validated);

        return redirect()->back()->with('success' , 'Product successfully updated ! ');

    }

    public function show($id) { 

        $product = Product::findorfail($id); 

        $categories = Category::all(); 

        return Inertia::render('Product/View' , ['product' => $product , 'categories' => $categories ]);

    }
}
