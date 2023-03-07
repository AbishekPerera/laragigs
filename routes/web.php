<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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


// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  


Route::get('/', [ListingController::class, 'index']);

//create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
// show edit form 
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// show register 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// creat new user 
Route::post('/users', [UserController::class, 'store']);

// // logout 
// Route::get('/logout', function () {
//     auth()->logout();
//     return redirect('/');
// });

//logout 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// login 
Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');

// authenticate user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);














Route::get('/listings/{listing}', [ListingController::class, 'show']);




