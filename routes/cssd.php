<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CssdController;

/**************************************Send to CSSD (Create)****************************************/
Route::get('/create', [CssdController::class, 'create'])->name('create');
Route::post('/store', [CssdController::class, 'store'])->name('store');



/**************************************Request to CSSD****************************************/
Route::get('/', [CssdController::class, 'index'])->name('index');
Route::post('/request-to-cssd/filter', [CssdController::class, 'requestToCssdFilter'])->name('requestToCssdFilter');
Route::get('/request-to-cssd/details/{id}', [CssdController::class, 'requestToCssdDetails'])->name('requestToCssdDetails.details');



/**************************************Receive from CSSD****************************************/
Route::get('/receive-from-cssd', [CssdController::class, 'receiveFromCssd'])->name('receiveFromCssd');
Route::post('/receive-from-cssd/filter', [CssdController::class, 'receiveFromCssdFilter'])->name('receiveFromCssdFilter');
Route::get('/receive-from-cssd/details/{id}', [CssdController::class, 'receiveFromCssdDetails'])->name('receiveFromCssd.details');
Route::post('/itemReceiveFromCssd', [CssdController::class, 'itemReceiveFromCssd'])->name('itemReceiveFromCssd');



/**************************************Receive from Department****************************************/
Route::get('/receive-from-department', [CssdController::class, 'cssdPendingReceive'])->name('cssdPendingReceive');
Route::post('/receive-from-department/filter', [CssdController::class, 'receiveFromDepartmentFilter'])->name('receiveFromDepartmentFilter');
Route::get('/receive-from-department/details/{id}', [CssdController::class, 'receiveFromDepartmentDetails'])->name('receiveFromDepartment.details');
Route::post('/receiveByCssd', [CssdController::class, 'receiveByCssd'])->name('receiveByCssd');
Route::post('/cancelByCssd', [CssdController::class, 'cancelByCssd'])->name('cancelByCssd');



/**************************************Return to Department****************************************/
Route::get('/return-to-department', [CssdController::class, 'cssdPendingReturn'])->name('cssdPendingReturn');
Route::post('/return-to-department/filter', [CssdController::class, 'returnToDepartmentFilter'])->name('returnToDepartmentFilter');
Route::get('/return-to-department/details/{id}', [CssdController::class, 'returnToDepartmentDetails'])->name('returnToDepartment.details');
Route::post('/returnBackToDept', [CssdController::class, 'returnBackToDept'])->name('returnBackToDept');



Route::get('/print/{id}', [CssdController::class, 'print'])->name('print');



/**************************************Item List****************************************/
Route::get('/item-list', [CssdController::class, 'itemList'])->name('itemList');
Route::post('/item-list-search', [CssdController::class, 'searchItemList'])->name('searchItemList');
