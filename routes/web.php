<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

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


Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/', function () {
        return view('admin.home.index');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user-profile', function () {
        return view('userprofile');
    })->name('userprofile');

    Route::get('/add-merchant', function () {
        return view('addmerchant');
    })->name('addmerchant');
    Route::resource('/pembelian', TransactionController::class);
    
    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('addToCart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::get('remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::get('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
    Route::get('cartTable', [CartController::class, 'cartTable']);
    Route::get('cekCart', [CartController::class, 'cekCart']);

});


Route::get('autocomplete', [TransactionController::class, 'autocomplete'])->name('autocomplete');
Route::get('getProductIdByName', [TransactionController::class, 'getProductIdByName']);

require __DIR__ . '/auth.php';

// CART ROUTE
