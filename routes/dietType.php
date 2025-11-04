<?php

use App\Http\Controllers\DietTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DietTypeController::class, 'index'])->name('index');
Route::get('/create', [DietTypeController::class, 'create'])->name('create');
Route::post('/store', [DietTypeController::class, 'store'])->name('store');
Route::get('/edit/{id}', [DietTypeController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [DietTypeController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [DietTypeController::class, 'delete'])->name('delete');
