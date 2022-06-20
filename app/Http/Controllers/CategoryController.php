<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia ;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index() { 

        $categories = Category::all(); 
        foreach($categories as $category) { 
            $category->count = $category->products()->count();
        }

        return Inertia::render('Category/Index' , ['categories' => $categories]); 
    }

    public function create() { 
        return Inertia::render('Category/Create');
    }

    public function save(Request $request) { 

        //check if category exists 
        if(Category::where('name' ,'=',$request->name)->count()) { 
            return redirect()->back()->with('error' , 'Category already existing ! ');
        }

        $category = category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success' , 'Category successfully created ! ');

    }

    public function edit($id) { 
        $category = Category::findorfail($id); 
        return Inertia::render('Category/Edit' , [
            'category' => $category 
        ]); 

    }

    public function put(Request $request) {

        //check if category name exists
        if(Category::where('name' ,'=',$request->name)->count()) { 
            return redirect()->back()->with('error' , 'Category already existing ! ');
        }

        $category = Category::findorfail($request->categoryId); 
        $category->name = $request->name ; 
        $category->save(); 

        return redirect()->back()->with('success' , 'Category Successfully updated ! ');
        
    }

    public function delete($id) { 

        $category = Category::where('id' , '=' , $id )->delete(); 

        return redirect()->back()->with('success' , 'Category Successfully deleted ! ');
    }

}
