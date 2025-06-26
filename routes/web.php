<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\JFPCController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/user', function () {
    return view('user');
})->middleware(['auth', 'verified'])->name('user');

Route::get('/sales', function () {
    return view('sales');
})->middleware(['auth', 'verified'])->name('sales');

Route::get('/delivery', function () {
    return view('delivery');
})->middleware(['auth', 'verified'])->name('delivery');

Route::get('/inventory', function () {
    return view('inventory');
})->middleware(['auth', 'verified'])->name('inventory');

Route::post('/add-user', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('add-user');



Route::get('/warehouse/pcsi', [InventoryController::class, 'index'])->middleware(['auth', 'verified'])->name('warehouse/pcsi');
Route::get('/item-master', [ItemMasterController::class, 'index'])->middleware(['auth', 'verified'])->name('item-master');

Route::post('/items/{id}/update', [ItemMasterController::class, 'update'])->name('items.update');
Route::post('/warehouse/pcsi/add', [InventoryController::class, 'add'])->name('warehouse.pcsi.add');

Route::get('/warehouse/jfpc', [JFPCController::class, 'index'])->middleware(['auth', 'verified'])->name('warehouse/jfpc');
Route::post('/warehouse/jfpc/add', [JFPCController::class, 'add'])->name('warehouse.jfpc.add');
Route::post('/item-master/add', [ItemMasterController::class, 'add'])->name('item-master.add');
