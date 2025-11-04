<?php

use App\Http\Controllers\FoodTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FoodTypeController::class, 'index'])->name('index');
Route::get('/create', [FoodTypeController::class, 'create'])->name('create');
Route::post('/store', [FoodTypeController::class, 'store'])->name('store');
Route::get('/edit/{id}', [FoodTypeController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [FoodTypeController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [FoodTypeController::class, 'delete'])->name('delete');
