<?php

use App\Http\Controllers\AmbulanceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/ambulance/ambulance-billing/{id?}', [AmbulanceController::class, 'ambulanceBilling'])->name('ambulance.ambulance-billing');
    Route::post('/ambulance/store-ambulance-billing', [AmbulanceController::class, 'storeAmbulanceBilling'])->name('ambulance.store-ambulance-billing');
    Route::get('/ambulance/bill-invoice/{id}/{trx?}', [AmbulanceController::class, 'ambulanceBillInvoice'])->name('ambulance.bill-invoice');
    Route::get('/ambulance/bill-invoice-print-A5/{id}/{page?}/{trx?}', [AmbulanceController::class, 'ambulancebillInvoicePrintA5'])->name('ambulance.bill-invoice-print-A5');

    Route::get('/ambulance/billing-list', [AmbulanceController::class, 'billingList'])->name('ambulance.billing-list');
    Route::post('/ambulance/bill-list', [AmbulanceController::class, 'billList'])->name('ambulance.bill-list');
    Route::post('/ambulance/search-bill-list', [AmbulanceController::class, 'searchBilllist'])->name('ambulance.search-bill-list');
    Route::get('/ambulance/bill-invoice-app-print/{id}/{page?}/{trx?}', [AmbulanceController::class, 'bill_invoice_app_print'])->name('ambulance.bill-invoice-app-print');
    Route::get('/ambulance/bill-invoice-app/{id}/{trx?}', [AmbulanceController::class, 'bill_invoice_app'])->name('ambulance.bill-invoice-app');

    Route::get('/ambulance/ambulance-trip-setup', [AmbulanceController::class, 'ambulanceTripSetup'])->name('ambulance.ambulance-trip-setup');
    Route::get('/ambulance/ambulance-trip-edit/{id}', [AmbulanceController::class, 'ambulanceTripEdit'])->name('ambulance.ambulance-trip-edit');
    Route::post('/ambulance/ambulance-trip-save', [AmbulanceController::class, 'ambulanceTripSave'])->name('ambulance.ambulance-trip-save');
    Route::get('/ambulance/ambulance-trip-list', [AmbulanceController::class, 'ambulanceTripList'])->name('ambulance.ambulance-trip-list');
    Route::get('/ambulance/ambulance-trip-get-data', [AmbulanceController::class, 'ambulanceTripGetData'])->name('ambulance.ambulance-trip-get-data');
    Route::get('/ambulance/ambulance-trip-get-completed-data', [AmbulanceController::class, 'ambulanceTripGetCompletedData'])->name('ambulance.ambulance-trip-get-completed-data');

    // ambulance setup

    Route::get('/ambulance/ambulance-setup', [AmbulanceController::class, 'ambulanceSetup'])->name('ambulance.ambulance-setup');
    Route::get('/ambulance/ambulance-setup-list', [AmbulanceController::class, 'ambulanceSetupList'])->name('ambulance.ambulance-list');
    Route::get('/ambulance/ambulance-setup-edit/{id}', [AmbulanceController::class, 'ambulanceSetupEdit'])->name('ambulance.ambulance-setup-edit');
    Route::post('/ambulance/ambulance-setup-save', [AmbulanceController::class, 'ambulanceSetupSave'])->name('ambulance.ambulance-setup-save');

});
