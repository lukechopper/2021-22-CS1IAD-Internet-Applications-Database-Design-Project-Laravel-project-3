<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\NewPasswordController;

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

Route::get('/login', [UserController::class, 'accessLogin'])->name('login');

Route::get('/signup', [UserController::class, 'accessSignup'])->name('signup');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/register', [UserController::class, 'signup'])->name('register')->middleware('guest');

Route::post('/create-account', [UserController::class, 'login'])->name('createAccount')->middleware('guest');

Route::get('/create-cv', [CVController::class, 'tryToAccessCreateCV'])->name('create.cv')->middleware('auth');

Route::post('/create-cv', [CVController::class, 'createCV'])->name('post.create.cv')->middleware('auth');;

Route::put('/update-cv', [CVController::class, 'updateCV'])->name('put.update.cv')->middleware('auth');

Route::get('/update-cv', [CVController::class, 'accessUpdateCV'])->name('update.cv')->middleware('auth');

Route::get('/cv/{id}', [CVController::class, 'viewCV'])->name('viewCV');

Route::get('/search-cv', [CVController::class, 'searchCV'])->name('searchCV');

Route::get('/get-more-blank-cv', [CVController::class, 'getMoreBlankCVs'])->name('getMoreBlankCVs');

Route::get('/request-to-change-password', function(){
    return view('requestToChangePassword');
})->name('requestToChangePassword')->middleware('guest');

Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword'])->name('forgotPassword')->middleware('guest');

Route::post('/reset-password', [NewPasswordController::class, 'resetPassword'])->name('resetPassword')->middleware('guest');

Route::get('/reset-password', [NewPasswordController::class, 'resetPasswordView'])->name('resetPasswordView')->middleware('guest');

Route::any('/{any}', function(){
    return redirect()->route('home');
})->where('any', '.*');
