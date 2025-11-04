<?php

use App\Http\Controllers\FloorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FloorController::class, 'index'])->name('index');
Route::get('/create', [FloorController::class, 'create'])->name('create');
Route::post('/store', [FloorController::class, 'store'])->name('store');
Route::get('/edit/{id}', [FloorController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [FloorController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [FloorController::class, 'delete'])->name('delete');
