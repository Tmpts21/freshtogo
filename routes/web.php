<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Order;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/redirects', [DashboardController::class, 'redirects'])->middleware(['auth', 'verified'])->name('redirects');

Route::get('/dashboard', [DashboardController::class, 'customer_index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [DashboardController::class, 'admin_index'])->middleware(['auth', 'verified'])->name('admin');

Route::get('/driver', [DashboardController::class, 'driver_index'])->middleware(['auth', 'verified'])->name('driver');






Route::group(['prefix' => 'admin', 'middleware' => ['auth' ,'verified' ]], function(){

    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/products', [AdminController::class, 'index'])->name('admin.products');

    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/create/category', [CategoryController::class, 'create'])->name('create.category');
    Route::post('/save/category', [CategoryController::class, 'save'])->name('save.category');
    Route::get('/edit/category/{id}', [CategoryController::class, 'edit'])->name('edit.category');
    Route::post('/put/category', [CategoryController::class, 'put'])->name('put.category');
    Route::post('/delete/category/{id}', [CategoryController::class, 'delete'])->name('delete.category');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/create/product', [ProductController::class, 'create'])->name('create.product');
    Route::post('/save/product', [ProductController::class, 'save'])->name('save.product');
    Route::get('/edit/product/{id}', [ProductController::class, 'edit'])->name('edit.product');
    Route::post('/put/product', [ProductController::class, 'put'])->name('put.product');
    Route::get('/show/product/{id}', [ProductController::class, 'show'])->name('show.product');

});


require __DIR__.'/auth.php';
