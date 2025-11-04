<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhonebookController;
Route::middleware(['auth'])->group(function () {
Route::get('/', [PhonebookController::class, 'index'])->name('index');
Route::get('/create', [PhonebookController::class, 'create'])->name('create');
Route::get('/get-item-types', [PhonebookController::class, 'getItemTypeData'])->name('getItemTypeData');
Route::get('/delete/{id?}', [PhonebookController::class, 'delete'])->name('delete');
Route::post('/store', [PhonebookController::class, 'store'])->name('store');
Route::get('/edit/{id}', [PhonebookController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [PhonebookController::class, 'update'])->name('update');

});