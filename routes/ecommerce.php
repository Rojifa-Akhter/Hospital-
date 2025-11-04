<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;

Route::middleware(['auth'])->group(function () {
Route::get('ecommerce/orders',[OrdersController::class,'orderList'])->name('ecommerce.orders');
Route::post('ecommerce/orders-list-search',[OrdersController::class,'orderListSearch'])->name('ecommerce.orders-list-search');
});
