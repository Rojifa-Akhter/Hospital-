<?php

use App\Traits\LookupData;
use App\Library\Template;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniformController;
Route::middleware(['auth'])->group(function () {
Route::get('/', [UniformController::class, 'index'])->name('index');
Route::get('/create', [UniformController::class, 'create'])->name('create');
Route::get('/get-data', [UniformController::class, 'getData'])->name('getData');
Route::post('/store', [UniformController::class, 'store'])->name('store');
Route::get('/edit/{id}', [UniformController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [UniformController::class, 'update'])->name('update');

Route::get('/uniform-request', [UniformController::class, 'uniformRequest'])->name('uniform-request');
Route::post('/uniform-request-store', [UniformController::class, 'uniformRequestStore'])->name('uniform-request-store');
Route::get('/uniform-issue', [UniformController::class, 'uniformIssue'])->name('uniform-issue');

});