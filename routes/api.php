<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{
    LoginController,
    RegisterController
};
use App\Http\Controllers\Api\{
    NoteController,
    CategoryController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function (){
   Route::post("login", LoginController::class)->name('auth.login');
   Route::post("register", RegisterController::class)->name('auth.register');
});

//Route::apiResource('notes', NoteController::class)
//    ->middleware('auth:sanctum');

Route::apiResource('notes', NoteController::class)->names('api.notes');
Route::apiResource('categories', CategoryController::class)->names('api.categories');

Route::get('notes/{note}/relationships/category', fn()=> 'todo')
    ->name('api.notes.relationships.category');

Route::get('notes/{note}/category', fn()=> 'todo')
    ->name('api.notes.category');
