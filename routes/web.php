<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TransaksisController;
use Illuminate\Support\Facades\Route;

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
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});


// gatau gadipake
Route::get('/login', [LibraryController::class, 'login'])->name('login');
Route::post('/register', [LibraryController::class, 'register'])->name('register');


// Admin
Route::prefix('admin')->middleware('auth')->group(function () {
    // view
    Route::get('/dashboard', [LibraryController::class, 'index_admin'])->name('dashboard_admin');
    Route::get('/data_siswa', [LibraryController::class, 'data_siswa'])->name('data_siswa');
    Route::get('/data_admin', [LibraryController::class, 'data_admin'])->name('data_admin');
    Route::get('/data_petugas', [LibraryController::class, 'data_petugas'])->name('data_petugas');
    Route::get('/profile_admin', [LibraryController::class, 'profile_admin'])->name('profile_admin');

    // delete
    Route::delete('/buku/{id}', [LibraryController::class, 'delete_buku'])->name('buku.delete');
    Route::delete('/data_siswa/{id}', [LibraryController::class, 'delete_siswa'])->name('siswa.delete');
    Route::delete('/data_admin/{id}', [LibraryController::class, 'delete_admin'])->name('admin.delete');
    Route::delete('/data_petugas/{id}', [LibraryController::class, 'delete_petugas'])->name('petugas.delete');

    // create
    Route::post('/buku', [LibraryController::class, 'create_buku'])->name('buku.create');
    Route::post('/data_siswa', [LibraryController::class, 'create_siswa'])->name('siswa.create');
    Route::post('/data_admin', [LibraryController::class, 'create_admin'])->name('admin.create');
    Route::post('/data_petugas', [LibraryController::class, 'create_petugas'])->name('petugas.create');

    // edit
    Route::put('/buku/{id}', [LibraryController::class, 'edit_buku'])->name('buku.edit');
    Route::put('/data_siswa/{id}', [LibraryController::class, 'edit_siswa'])->name('siswa.edit');
    Route::put('/data_admin/{id}', [LibraryController::class, 'edit_admin'])->name('admin.edit');
    Route::put('/data_petugas/{id}', [LibraryController::class, 'edit_petugas'])->name('petugas.edit');
});

// Siswa
Route::prefix('siswa')->middleware('auth:user')->group(function () {
    // view
    Route::get('/dashboard', [TransaksisController::class, 'index_siswa'])->name('dashboard_siswa');
    Route::get('/profile_siswa', [LibraryController::class, 'profile_siswa'])->name('profile_siswa');
    Route::get('/detail_buku/{id}', [libraryController::class, 'detail_buku'])->name('buku.show');
    Route::get('/favourite', [LibraryController::class, 'favourite'])->name('favourite');
    Route::get('/setting', [LibraryController::class, 'setting'])->name('setting');
    Route::get('/history', [LibraryController::class, 'borrow'])->name('borrow');

    // pinjam
    Route::post('/pinjam_buku/{id}', [TransaksisController::class, 'pinjam_buku'])->name('pinjam_buku');
    // Route::put('/')
});

Route::prefix('petugas')->middleware('auth')->group(function () {
    // view
    Route::get('/dashboard', [LibraryController::class, 'index_petugas'])->name('dashboard_petugas');
    Route::get('/profile_petugas', [LibraryController::class, 'profile_petugas'])->name('profile_petugas');
    Route::get('/data_pinjam', [TransaksisController::class, 'data_buku'])->name('data_pinjam');
    Route::post('/data_pinjam/{id}/update-status', [TransaksisController::class, 'updateStatus'])->name('data_pinjam.updateStatus');

    // delete
    Route::put('/data_pinjam/{id}', [TransaksisController::class, 'return_data_pinjam'])->name('data_pinjam.return');
    Route::delete('/buku/{id}', [LibraryController::class, 'delete_buku'])->name('buku.delete');

    // edit
    Route::put('/buku/{id}', [LibraryController::class, 'edit_buku'])->name('buku.edit');

    // create
    Route::post('/buku', [LibraryController::class, 'create_buku'])->name('buku.create');
});

// Login Register Logout Action
Route::post('/login', [AuthController::class, 'login'])->name('login_user');
Route::post('/register', [AuthController::class, 'register'])->name('register_user');
Route::get('/logout', [LibraryController::class, 'logout'])->name('logout');
