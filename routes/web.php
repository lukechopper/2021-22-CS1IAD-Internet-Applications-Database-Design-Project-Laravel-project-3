<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CVController;

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

Route::get('/', [CVController::class, 'returnHomeView'])->name('home');

Route::get('/login', function(){
    return view('login');
})->name('login');

Route::get('/signup', function(){
    return view('signup');
})->name('signup');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/register', [UserController::class, 'signup'])->name('register');

Route::post('/create-account', [UserController::class, 'login'])->name('createAccount');

Route::get('/create-cv', [CVController::class, 'tryToAccessCreateCV'])->name('create.cv')->middleware('auth');

Route::post('/create-cv', [CVController::class, 'createCV'])->name('post.create.cv');

Route::put('/update-cv', [CVController::class, 'updateCV'])->name('put.update.cv');

Route::get('/update-cv', [CVController::class, 'accessUpdateCV'])->name('update.cv')->middleware('auth');

Route::get('/cv/{id}', [CVController::class, 'viewCV'])->name('viewCV');

Route::get('/search-cv', [CVController::class, 'searchCV'])->name('searchCV');

Route::any('/{any}', function(){
    return view('welcome');
})->where('any', '.*');
