<?php

use App\Http\Controllers\HousekeepingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('housekeeping/worklist', [HousekeepingController::class, 'worklist'])->name('housekeeping.worklist');
    Route::post('housekeeping/washed-worklist', [HousekeepingController::class, 'washedWorklist'])->name('housekeeping.washed-worklist');
    Route::resource('housekeeping', HousekeepingController::class);
    Route::post('housekeeping-report-search', [HousekeepingController::class, 'hkReportSearch'])->name('housekeeping-report-search');
    Route::post('housekeeping-report-report-pdf', [HousekeepingController::class, 'hkReportPdf'])->name('housekeeping-report-pdf');
    Route::get('create-loundry-requst', [HousekeepingController::class, 'loundryRequest'])->name('create-loundry-requst');
    Route::post('housekeeping-store-requst', [HousekeepingController::class, 'loundryRequestStore'])->name('housekeeping-store-requst');
    Route::post('housekeeping-store-item', [HousekeepingController::class, 'loundryReceivedStore'])->name('housekeeping-store-item');
    Route::post('consumption-store', [HousekeepingController::class, 'consumptionStore'])->name('consumption-store');
    Route::get('create-consumption/{cons_id?}', [HousekeepingController::class, 'consumptionCreate'])->name('create-consumption');

    Route::get('ipd/housekeeping-req-list', [HousekeepingController::class, 'housekeepingReqList'])->name('ipd.housekeeping-req-list');
    Route::post('ipd/housekeeping-req-list', [HousekeepingController::class, 'searchHousekeepingReqList'])->name('ipd.housekeeping-req-list-search');

});
