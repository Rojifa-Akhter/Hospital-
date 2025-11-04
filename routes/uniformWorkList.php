<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformWorklistController;
Route::middleware(['auth'])->group(function () {
Route::get('/', [UniformWorklistController::class, 'index'])->name('index');
Route::get('/create', [UniformWorklistController::class, 'create'])->name('create');
Route::get('/get-data', [UniformWorklistController::class, 'getData'])->name('getData');
Route::post('/store', [UniformWorklistController::class, 'store'])->name('store');
Route::get('/allocation-history/{id}', [UniformWorklistController::class, 'allocationHistory'])->name('allocationHistory');
Route::get('/allocate/{id}/{designation_id}', [UniformWorklistController::class, 'allocate'])->name('allocate');
// Route::post('/update/{id}', [UniformWorklistController::class, 'update'])->name('update');
});