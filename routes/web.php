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
use App\Http\Controllers\DriverController;

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


Route::get('/redirects', [DashboardController::class, 'redirects'])->middleware(['auth', 'verified' ,'isActive'])->name('redirects');

Route::get('/dashboard', [DashboardController::class, 'customer_index'])->middleware(['auth', 'verified' ,'customer'])->name('dashboard');

Route::get('/admin', [DashboardController::class, 'admin_index'])->middleware(['auth', 'verified' ,'admin'])->name('admin');

Route::get('/driver', [DashboardController::class, 'driver_index'])->middleware(['auth', 'verified' ,'driver'])->name('driver');



Route::get('/feedback', [DashboardController::class, 'feedback'])->name('guest.feedback');


Route::get('/contact', [DashboardController::class, 'contact'])->name('guest.contact');


Route::get('/guest/view/product/{id}', [DashboardController::class, 'guest_view_product'])->name('guest.view_product');

Route::get('/profile', [DashboardController::class, 'profile'])->name('profile')->middleware(['auth' , 'isActive']);

Route::get('/edit/profile', [DashboardController::class, 'edit_profile'])->name('edit_profile')->middleware(['auth' , 'isActive']);

Route::post('/profile/update', [DashboardController::class, 'update_profile'])->name('profile.update')->middleware(['auth' , 'isActive']);

Route::get('/profile/update/creds', [DashboardController::class, 'change_password'])->name('change.password')->middleware(['auth' , 'isActive']);

Route::post('/profile/update/creds', [DashboardController::class, 'update_password'])->name('update.password')->middleware(['auth' , 'isActive']);



Route::group(['prefix' => 'admin', 'middleware' => ['auth' ,'verified' , 'admin' ,'isActive' ]], function(){

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'create_user'])->name('admin.create_user');
    Route::post('/users/save', [AdminController::class, 'save_user'])->name('admin.save_user');
    Route::get('/users/view/{id}', [AdminController::class, 'view_user'])->name('admin.view_user');
    Route::post('/users/update', [AdminController::class, 'update_user'])->name('admin.update_user');
    Route::get('/users/edit/status/{id}', [AdminController::class, 'edit_status'])->name('admin.edit_status');
    Route::post('/users/edit/status', [AdminController::class, 'update_status'])->name('admin.update_status');


    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::get('/orders/view/{id}/{unique_id}', [OrderController::class, 'view'])->name('order.view');
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
    Route::get('/view/driver/{id}', [AdminController::class, 'viewDriverLocation'])->name('admin.view_driver_location');
});


Route::group(['prefix' => 'customer', 'middleware' => ['auth' ,'verified','customer','isActive' ]], function(){
    Route::post('/placeorder', [CustomerController::class, 'place_order'])->name('customer.placeorder');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/view/{id}', [CustomerController::class, 'view'])->name('customer.view_order');
    Route::get('/add/feedback/{id}/{orderId}', [CustomerController::class, 'feedback'])->name('customer.feedback');
    Route::get('/view/product/{id}', [CustomerController::class, 'view_product'])->name('customer.view_product');
    Route::post('/save/feedback', [CustomerController::class, 'save_feedback'])->name('customer.save_feedback');
    Route::get('/view/orders/{id}/{status}', [CustomerController::class, 'viewOrders'])->name('customer.view_orders');
});


Route::group(['prefix' => 'driver', 'middleware' => ['auth' ,'verified','driver' ,'isActive' ]], function(){
    Route::get('/edit/orders/{id}', [DriverController::class, 'edit'])->name('driver.edit_order');
    Route::get('/view/orders/{id}', [DriverController::class, 'view'])->name('driver.view_order');
    Route::post('/update/order', [DriverController::class, 'update'])->name('driver.update_order_status');
    Route::get('/viewOrders/{id}/{status}', [DriverController::class, 'viewOrders'])->name('driver.view_orders');
    
    Route::post('/updateDriverPosition', [DriverController::class, 'updateDriverPosition'])->name('driver.updateDriverPosition');


});


require __DIR__.'/auth.php';
