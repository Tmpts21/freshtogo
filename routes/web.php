<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Models\Category;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $productController = new ProductController ;
    $categories = Category::all();  
    
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'products' => $productController->getAllProducts(),
        'categories' => $categories 
    ]);
})->name('welcome');


Route::get('/redirects', [DashboardController::class, 'redirects'])->middleware(['auth', 'verified'])->name('redirects');

Route::get('/dashboard', [DashboardController::class, 'customer_index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [DashboardController::class, 'admin_index'])->middleware(['auth', 'verified'])->name('admin');

Route::get('/driver', [DashboardController::class, 'driver_index'])->middleware(['auth', 'verified'])->name('driver');



Route::get('/feedback', function () {

    
})->name('feedback');

Route::get('/contact', function () {

    
})->name('contact');


Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

Route::post('/profile/update', [DashboardController::class, 'update_profile'])->name('profile.update');


Route::group(['prefix' => 'admin', 'middleware' => ['auth' ,'verified' ]], function(){

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'create_user'])->name('admin.create_user');
    Route::post('/users/save', [AdminController::class, 'save_user'])->name('admin.save_user');
    Route::get('/users/edit/{id}', [AdminController::class, 'edit_user'])->name('admin.edit_user');
    Route::post('/users/update', [AdminController::class, 'update_user'])->name('admin.update_user');


    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::post('/update/order', [OrderController::class, 'update'])->name('update.order');

    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/create/category', [CategoryController::class, 'create'])->name('create.category');
    Route::post('/save/category', [CategoryController::class, 'save'])->name('save.category');
    Route::get('/edit/category/{id}', [CategoryController::class, 'edit'])->name('edit.category');
    Route::post('/update/category', [CategoryController::class, 'update'])->name('put.category');
    Route::post('/delete/category/{id}', [CategoryController::class, 'delete'])->name('delete.category');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/create/product', [ProductController::class, 'create'])->name('create.product');
    Route::post('/save/product', [ProductController::class, 'save'])->name('save.product');
    Route::get('/edit/product/{id}', [ProductController::class, 'edit'])->name('edit.product');
    Route::post('/update/product', [ProductController::class, 'update'])->name('put.product');
    Route::get('/show/product/{id}', [ProductController::class, 'show'])->name('show.product');

});


Route::group(['prefix' => 'customer', 'middleware' => ['auth' ,'verified' ]], function(){
    Route::post('/placeorder', [CustomerController::class, 'place_order'])->name('customer.placeorder');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
});

require __DIR__.'/auth.php';
