<?php

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
    return view('home');
})->middleware('auth');
Route::get('/text', function () {
    return view('layouts/app');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {


//Roles
Route::get('/medicines', [App\Http\Controllers\MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/create', [App\Http\Controllers\MedicineController::class, 'create'])->name('medicines.create');
Route::post('/medicines/store', [App\Http\Controllers\MedicineController::class, 'store'])->name('medicines.store');
Route::get('/medicines/{id}/view', [App\Http\Controllers\MedicineController::class, 'view'])->name('medicines.view');
Route::get('/medicines/{id}/edit', [App\Http\Controllers\MedicineController::class, 'edit'])->name('medicines.edit');
Route::post('/medicines/{id}/update', [App\Http\Controllers\MedicineController::class, 'update'])->name('medicines.update');
Route::delete('/medicines/{id}/destroy', [App\Http\Controllers\MedicineController::class, 'destroy'])->name('medicines.destroy');


//Suppliers
Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/suppliers/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('suppliers.create');
Route::post('/suppliers/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/{id}/view', [App\Http\Controllers\SupplierController::class, 'view'])->name('suppliers.view');
Route::get('/suppliers/{id}/edit', [App\Http\Controllers\SupplierController::class, 'edit'])->name('suppliers.edit');
Route::post('/suppliers/{id}/update', [App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');
Route::delete('/suppliers/{id}/destroy', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('suppliers.destroy');




//Stock-In
Route::get('/stock_in', [App\Http\Controllers\StockInController::class, 'index'])->name('stock_in.index');
Route::get('/stock_in/create', [App\Http\Controllers\StockInController::class, 'create'])->name('stock_in.create');
Route::post('/stock_in/store', [App\Http\Controllers\StockInController::class, 'store'])->name('stock_in.store');
Route::get('/get/medicine', [App\Http\Controllers\StockInController::class, 'getMedicine'])->name('getMedicine.all');
Route::get('/stock_in/{id}/view', [App\Http\Controllers\StockInController::class, 'view'])->name('stock_in.view');
Route::get('/stock_in/{id}/edit', [App\Http\Controllers\StockInController::class, 'edit'])->name('stock_in.edit');
Route::post('/stock_in/{id}/update', [App\Http\Controllers\StockInController::class, 'update'])->name('stock_in.update');
Route::delete('/stock_in/{id}/destroy', [App\Http\Controllers\StockInController::class, 'destroy'])->name('stock_in.destroy');



//Stock-In
Route::get('/stock_available', [App\Http\Controllers\AvailableStockController::class, 'index'])->name('stock_available.index');
Route::get('/stock_available/{id}/edit', [App\Http\Controllers\AvailableStockController::class, 'edit'])->name('stock_available.edit');
Route::post('/stock_available/{id}/update', [App\Http\Controllers\AvailableStockController::class, 'update'])->name('stock_available.update');
Route::delete('/stock_available/{id}/destroy', [App\Http\Controllers\AvailableStockController::class, 'destroy'])->name('stock_available.destroy');

});
