<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController; 
use App\Http\Controllers\API\LibraryController;   
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

// === AUTH ===

// register
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/registeradmin', [AuthController::class, 'RegisterAdmin']);

// login
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/loginadmin', [AuthController::class, 'LoginAdmin']);

// logout
Route::post('/logout', [AuthController::class, 'Logout']);

// === END AUTH ===

// === BUKU ===

Route::post('/Createbuku', [LibraryController::class, 'CreateBukuA']);

Route::get('/Getbuku', [LibraryController::class, 'getAllBuku']);

Route::get('/showUlasan/{bukuId?}', [LibraryController::class, 'show_ulasan']);

// === END BUKU ===