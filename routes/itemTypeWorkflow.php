<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemTypeWorkFlowController;

Route::get('/', [ItemTypeWorkFlowController::class, 'index'])->name('index');
Route::get('/get-item-types', [ItemTypeWorkFlowController::class, 'getItemTypeData'])->name('getItemTypeData');
Route::get('/create', [ItemTypeWorkFlowController::class, 'create'])->name('create');
Route::post('/store', [ItemTypeWorkFlowController::class, 'store'])->name('store');
Route::get('/edit/{id}', [ItemTypeWorkFlowController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [ItemTypeWorkFlowController::class, 'update'])->name('update');
