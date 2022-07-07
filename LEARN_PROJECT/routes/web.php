<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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
Route::resource('listings',ListingController::class)->except([
  'index',
  'show',
])->middleware('auth');

Route::resource('listings',ListingController::class)->only([
  'show',
]);

Route::get('/',
[ListingController::class, 'index']);

Route::get('/listings/manage',
[ListingController::class, 'manage'])->middleware('auth');

Route::get('/register',
[UserController::class, 'create'])->middleware('guest');

Route::post('/users',
[UserController::class, 'store']);

Route::get('/logout',
[UserController::class, 'logout'])->middleware('auth');

Route::get('/login',
[UserController::class, 'login'])->name('login')
                                ->middleware('guest');

Route::post('users/authenticate',
[UserController::class, 'authenticate']);
