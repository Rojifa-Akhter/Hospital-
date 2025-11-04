<?php

use App\Http\Controllers\DietFoodController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DietFoodController::class, 'index'])->name('index');
Route::get('/create', [DietFoodController::class, 'create'])->name('create');
Route::post('/store', [DietFoodController::class, 'store'])->name('store');
Route::get('/edit/{id}', [DietFoodController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [DietFoodController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [DietFoodController::class, 'delete'])->name('delete');
