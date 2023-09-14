<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    NoteController
};

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

Route::get('/', function () {
    return view('auth.login');
})
    ->middleware('guest')
    ->name('login');

Route::get('/register', function () {
    return view('auth.register');
})
    ->middleware('guest')
    ->name('register');

Route::controller(AuthController::class)
    ->group(function (){
        Route::post('login', 'login')->name('auth.login');
        Route::post('register', 'register')->name('auth.register');
        Route::post('logout', 'logout')
            ->middleware('auth')
            ->name('auth.logout');
    });

Route::resource('notes', NoteController::class)
    ->middleware('auth')
    ->scoped(['note' => 'slug']);
