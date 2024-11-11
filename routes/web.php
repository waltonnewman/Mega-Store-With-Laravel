<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\RegisteredAdminController;
use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SellerRequestController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PasswordResetController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/users/dashboard', [SellerRequestController::class, 'dashboard'])->name('dashboard');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/shop', [ShopController::class, 'index']);
Route::get('/search', SearchController::class)->name('search');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/users/products/create', [ProductController::class, 'create']);
Route::get('/users/products/all', [ProductController::class, 'allProducts'])->name('products.all');
Route::post('/products', [ProductController::class, 'store']);
Route::get('products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/users/products/{product}/edit', [ProductController::class, 'edit'])
    ->middleware('auth')->name('products.edit');
    Route::get('/users/ordered-products', [ProductController::class, 'showOrderedProducts'])->middleware('auth');
Route::patch('/users/products/{product}/edit', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/orders/{order}/update-status', [CheckoutController::class, 'updateStatus'])->name('orders.updateStatus');
//Route::get('/oder/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
Route::get('/oders/{order}', [CheckoutController::class, 'showUserOrder'])->name('orders.show');

// Passing Admin Routes through the middleware for authentication

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    
    Route::get('/admins/dashboard', function () {
    return view('admins/dashboard');
});
Route::get('/admins/allUsers', [AdminController::class, 'allUsers'])->name('admins.allUsers');
Route::get('/admins/orders', [CheckoutController::class, 'allOrders'])->name('admins.orders');
Route::delete('/admins/orders/{order}', [CheckoutController::class, 'destroy'])->name('orders.destroy');
Route::get('/admins/products/all', [AdminController::class, 'allProducts'])->name('products.all');
Route::get('/admins/products/new_product', [AdminController::class, 'create'])->name('products.new_product');;
Route::post('/admins/products', [AdminController::class, 'store']);
Route::delete('/admins/{user}', [AdminController::class, 'destroy'])->name('admins.destroy');
Route::get('/admins/allRequest', [SellerRequestController::class, 'allRequest'])->name('admins.allRequest');
Route::delete('allRequest/{seller_request}', [SellerRequestController::class, 'destroy'])->name('seller_request.destroy');
Route::post('/allRequest/{seller_request}/update-status', [SellerRequestController::class, 'updateRequest'])->name('allRequest.updateStatus');
Route::get('/admins/view_request/{seller_request}', [SellerRequestController::class, 'showRequest'])
->name('view_request');
Route::get('/signup', [RegisteredAdminController::class, 'create']);
Route::get('/category', [CategoryController::class, 'create']);
Route::post('/category', [CategoryController::class, 'store']);

});


//Admin Login Auth
Route::get('/signin', [AdminSessionController::class, 'create'])->name('signin');
Route::post('/signin', [AdminSessionController::class, 'store']);


Route::view('/contact', 'contact')->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Users Register Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/users/profile/{user}/settings', [RegisteredUserController::class, 'settings'])->name('profile.settings');
Route::patch('/users/profile/{user}/settings', [RegisteredUserController::class, 'update'])->name('profile.update');

// Admin Register Auth
Route::post('/signup', [RegisteredAdminController::class, 'store']);

//Login Auth
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
Route::delete('/logout', [AdminController::class, 'destroy'])->middleware('auth');


//Shopping Cart logics

Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'index'])->name('mycart');


//Checkout logics

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store']);
//Route::post('/checkout/store/{orderId}', [CheckoutController::class, 'store']);
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/users/orders', [CheckoutController::class, 'showOrders'])->name('user.orders')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('/seller-request/create', [SellerRequestController::class, 'create'])->name('seller.request.create');
    Route::post('/seller-request', [SellerRequestController::class, 'store'])->name('seller.request.store');
});

Route::post('/orders/{order}/tracking', [TrackingController::class, 'create'])->name('tracking.create');
Route::get('/orders/{order}/tracking', [TrackingController::class, 'show'])->name('tracking.show');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking', [TrackingController::class, 'track'])->name('tracking.track');

//Password Reset 
Route::get('password/reset', [PasswordResetController::class, 'showResetRequestForm'])->name('password.reset.request');
Route::post('password/reset', [PasswordResetController::class, 'sendResetLink'])->name('password.reset.send');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/reset/update', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
