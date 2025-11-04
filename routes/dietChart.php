<?php

use App\Http\Controllers\DietChartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DietChartController::class, 'index'])->name('index');
Route::get('/get-foods-by-meal-type/{id}', [DietChartController::class, 'getFoodsByMealType'])->name('getFoodsByMealType');
Route::get('/create', [DietChartController::class, 'create'])->name('create');
Route::post('/store', [DietChartController::class, 'store'])->name('store');
Route::get('/edit/{id}', [DietChartController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [DietChartController::class, 'update'])->name('update');
Route::get('/details/{id}', [DietChartController::class, 'details'])->name('details');
Route::delete('/delete/{id}', [DietChartController::class, 'delete'])->name('delete');
Route::post('/report', [DietChartController::class, 'report'])->name('report');
Route::post('/report/v1', [DietChartController::class, 'reportV1'])->name('reportV1');
