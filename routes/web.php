<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ThankyouComponent;
// use App\Http\Livewire\PackageComponent;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class);
Route::get('/shop', ShopComponent::class);
Route::get('/cart', CartComponent::class)->name('product.cart');
Route::get('/checkout', CheckoutComponent::class)->name('checkout');

Route::group(['middleware' => [ 'auth:sanctum', 'verified' ]], function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
   
    Route::get('/packages', function () {
        return view('packages');
    })->name('packages');

    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');

    Route::get('/thank-you', ThankyouComponent::class)->name('thankyou');
    

});