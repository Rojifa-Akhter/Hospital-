<?php

use App\Http\Controllers\GenericItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GenericItemController::class, 'index'])->name('index');
Route::get('/create', [GenericItemController::class, 'create'])->name('create');
Route::post('/store', [GenericItemController::class, 'store'])->name('store');
Route::get('/edit/{id}', [GenericItemController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [GenericItemController::class, 'update'])->name('update');
Route::post('/delete-generic-item', [GenericItemController::class, 'delete'])->name('delete-generic-item');
