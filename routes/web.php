<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceController;


Route::get('', function(){
    return redirect()->route('login');
});

Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::group([ 
    'middleware' => 'guest'
    ], function() {
        Route::get('masuk', [AuthController::class, 'login'])->name('login');
        Route::post('masuk', [AuthController::class, 'loginProcess'])->name('login_process');
        Route::get('lupa-password', [AuthController::class, 'forgetPassword'])->name('forget_password');
        Route::post('lupa-password', [AuthController::class, 'forgetPasswordProcess'])->name('forget_password_process');
        Route::get('reset-password/{email}/{token}', [AuthController::class, 'resetPassword'])->name('reset_password');
        Route::post('reset-password', [AuthController::class, 'resetPasswordProcess'])->name('reset_password_process');    
    }
);
Route::get('keluar', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::group([
    'middleware' => 'auth'
], function(){
    Route::get('edit-profil', [UserController::class, 'profileEdit'])->name('profile.edit');
    Route::put('update-profil', [UserController::class, 'profileUpdate'])->name('profile.update');
});

Route::group([
    'prefix' => 'pengguna',
    'middleware' => ['auth', 'superadmin']
], function(){
    Route::get('', [UserController::class, 'index'])->name('users.index');
    Route::get('tambah', [UserController::class, 'create'])->name('users.create');
    Route::post('simpan', [UserController::class, 'store'])->name('users.store');
    Route::get('detail/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('ubah/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('perbarui', [UserController::class, 'update'])->name('users.update');
    Route::delete('hapus', [UserController::class, 'destroy'])->name('users.delete');
});


Route::group([
    'prefix' => 'layanan/kategori',
    'middleware' => 'auth'
], function(){
    Route::get('', [ServiceCategoryController::class, 'index'])->name('service_categories.index');
    Route::get('tambah', [ServiceCategoryController::class, 'create'])->name('service_categories.create');
    Route::post('simpan', [ServiceCategoryController::class, 'store'])->name('service_categories.store');
    Route::get('detail/{id}', [ServiceCategoryController::class, 'show'])->name('service_categories.show');
    Route::get('ubah/{id}', [ServiceCategoryController::class, 'edit'])->name('service_categories.edit');
    Route::put('perbarui', [ServiceCategoryController::class, 'update'])->name('service_categories.update');
    Route::delete('hapus', [ServiceCategoryController::class, 'destroy'])->name('service_categories.delete');

    Route::get('get-services/{id}',[ServiceCategoryController::class, 'getServices'])->name('service_categories.get_services');
});

Route::group([
    'prefix' => 'layanan',
    'middleware' => 'auth'
], function(){
    Route::get('', [ServiceController::class, 'index'])->name('services.index');
    Route::get('tambah', [ServiceController::class, 'create'])->name('services.create');
    Route::post('simpan', [ServiceController::class, 'store'])->name('services.store');
    Route::get('detail/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('ubah/{id}', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('perbarui', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('hapus', [ServiceController::class, 'destroy'])->name('services.delete');
});


Route::group([
    'prefix' => 'klien',
    'middleware' => 'auth'
], function(){
    Route::get('', [ClientController::class, 'index'])->name('clients.index');
    Route::get('tambah', [ClientController::class, 'create'])->name('clients.create');
    Route::post('simpan', [ClientController::class, 'store'])->name('clients.store');
    Route::get('detail/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('ubah/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('perbarui', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('hapus', [ClientController::class, 'destroy'])->name('clients.delete');
});


Route::group([
    'prefix' => 'invoice',
    'middleware' => 'auth'
], function(){
    Route::get('', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('tambah', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('simpan', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('detail/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('ubah/{id}', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('perbarui', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('hapus', [InvoiceController::class, 'destroy'])->name('invoices.delete');

    Route::get('get-services/{id}',[InvoiceController::class, 'getServices'])->name('invoices.get_services');

    Route::get('ubah/get-services/{id}',[InvoiceController::class, 'getServices'])->name('invoices.edit_get_services');
    Route::get('ubah/get-services-error/{id}',[InvoiceController::class, 'editGetServices'])->name('invoices.edit_get_services');

    Route::get('preview/{id}',[InvoiceController::class, 'preview'])->name('invoices.preview');
    Route::get('unduh/{id}',[InvoiceController::class, 'download'])->name('invoices.download');
});


Route::group([
    'prefix' => 'transaksi',
    'middleware' => ['auth', 'superadmin']
], function(){
    Route::get('', [TransactionController::class, 'index'])->name('transactions.index');
});