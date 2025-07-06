<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOperationsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\JFPCController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PODController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\SignaturesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


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
Route::post('/notifications/read-all', function () {
    DB::table('notifications')->whereNull('read_at')->update([
        'read_at' => now()
    ]);
    return response()->json(['success' => true]);
});


Route::post('/notifications/marked', function () {
    DB::table('notifications')->whereNull('marked_as_read')->update([
        'marked_as_read' => 'marked_as_read'
    ]);
    return response()->json(['success' => true]);
});


Route::post('/warehouse/pcsi/ship', [InventoryController::class, 'ship'])->name('warehouse.pcsi.ship');


Route::get('/return-item', [ReturnItemController::class, 'index'])->name('return-item');


Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
Route::get('/pod', [PODController::class, 'index'])->name('pod');
Route::get('/operations', [DeliveryOperationsController::class, 'index'])->name('operations');
Route::post('/delivery/load', [DeliveryOperationsController::class, 'load'])->name('delivery.load');


Route::get('/truck-loading-data', [DeliveryOperationsController::class, 'showTruckLoading']);
Route::get('/truck-loading-data', [DeliveryOperationsController::class, 'showTruckLoading']);
Route::get('/signatures', [SignaturesController::class, 'index']);
Route::post('/signatures/submit', [SignaturesController::class, 'submit'])->name('signatures.submit');

Route::post('/save-signature', [DeliveryOperationsController::class, 'storeSignature']);