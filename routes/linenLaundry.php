<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinenLaundryController;
Route::middleware(['auth'])->group(function () {
/**************************************Send to Laundry (Create)****************************************/
Route::get('/create', [LinenLaundryController::class, 'create'])->name('create');
Route::post('/store', [LinenLaundryController::class, 'store'])->name('store');



/**************************************Request to Laundry****************************************/
Route::get('/', [LinenLaundryController::class, 'index'])->name('index');
Route::post('/request-to-laundry/filter', [LinenLaundryController::class, 'requestToLaundryFilter'])->name('requestToLaundryFilter');
Route::get('/request-to-laundry/details/{id}', [LinenLaundryController::class, 'requestToLaundryDetails'])->name('requestToLaundryDetails');



/**************************************Receive from Laundry****************************************/
Route::get('/receive-from-laundry', [LinenLaundryController::class, 'receiveFromLaundry'])->name('receiveFromLinenLaundry');
Route::post('/receive-from-laundry/filter', [LinenLaundryController::class, 'receiveFromLaundryFilter'])->name('receiveFromLaundryFilter');
Route::get('/receive-from-laundry/details/{id}', [LinenLaundryController::class, 'receiveFromLaundryDetails'])->name('receiveFromLaundryDetails');
Route::post('/itemReceiveFromLinenLaundry', [LinenLaundryController::class, 'itemReceiveFromLinenLaundry'])->name('itemReceiveFromLinenLaundry');



/**************************************Received from Laundry****************************************/
Route::get('/received-from-laundry', [LinenLaundryController::class, 'receivedFromLaundry'])->name('receivedFromLinenLaundry');
Route::post('/received-from-laundry/filter', [LinenLaundryController::class, 'receivedFromLaundryFilter'])->name('receivedFromLaundryFilter');
Route::get('/received-from-laundry/details/{id}', [LinenLaundryController::class, 'receivedFromLaundryDetails'])->name('receivedFromLaundryDetails');



/**************************************Returned to Department****************************************/
Route::get('/returned-to-department', [LinenLaundryController::class, 'returnedToDepartment'])->name('returnedToDepartment');
Route::post('/returned-to-laundry/filter', [LinenLaundryController::class, 'returnedToDepartmentFilter'])->name('returnedToDepartmentFilter');
Route::get('/returned-to-department/details/{id}', [LinenLaundryController::class, 'returnedToDepartmentDetails'])->name('returnedToDepartmentDetails');



/**************************************Receive from Department****************************************/
Route::get('/receive-from-department', [LinenLaundryController::class, 'receiveFromDepartment'])->name('linenLaundryReceive');
Route::post('/receive-from-department/filter', [LinenLaundryController::class, 'receiveFromDepartmentFilter'])->name('receiveFromDepartmentFilter');
Route::get('/receive-from-department/details/{id}', [LinenLaundryController::class, 'receiveFromDepartmentDetails'])->name('receiveFromDepartmentDetails');
Route::post('/receiveByLaundry', [LinenLaundryController::class, 'receiveByLaundry'])->name('receiveByLaundry');



/**************************************Return to Department****************************************/
Route::get('/return-to-department', [LinenLaundryController::class, 'returnToDepartment'])->name('linenLaundryReturn');
Route::post('/return-to-department/filter', [LinenLaundryController::class, 'returnToDepartmentFilter'])->name('returnToDepartmentFilter');
Route::get('/return-to-department/details/{id}', [LinenLaundryController::class, 'returnToDepartmentDetails'])->name('returnToDepartmentDetails');
Route::get('/return-to-department/history/{id}', [LinenLaundryController::class, 'returnToDepartmentHistory'])->name('returnToDepartmentHistory');
Route::post('/returnBackToDept', [LinenLaundryController::class, 'returnBackToDept'])->name('returnBackToDept');



Route::get('/returned-to-department/history/{id}', [LinenLaundryController::class, 'history'])->name('history');
Route::get('/print/{id}', [LinenLaundryController::class, 'print'])->name('print');



/**************************************Item List****************************************/
Route::get('/item-list', [LinenLaundryController::class, 'itemList'])->name('itemList');
Route::post('/item-list-search', [LinenLaundryController::class, 'searchItemList'])->name('searchItemList');


///////////////////////////////////////////////////////////////////////////////////////////














Route::get('/get-data', [LinenLaundryController::class, 'getData'])->name('getData');
Route::get('/details/{id}', [LinenLaundryController::class, 'details'])->name('details');


Route::post('/send-to-laundry/filter', [LinenLaundryController::class, 'sendToLinenLaundryFilter'])->name('sendToLinenLaundryFilter');

Route::get('/get-laundry-receive-data', [LinenLaundryController::class, 'getLinenLaundryReceiveData'])->name('getLinenLaundryReceiveData');


Route::get('/get-laundry-return-data', [LinenLaundryController::class, 'getLinenLaundryReturnData'])->name('getLinenLaundryReturnData');


Route::get('/get-return-receive-data', [LinenLaundryController::class, 'getReturnReceiveData'])->name('getReturnReceiveData');

});