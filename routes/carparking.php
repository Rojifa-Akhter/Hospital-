<?php

use App\Http\Controllers\CarparkingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    // car parking policy
    Route::get('v1/car-parking-policy', [CarparkingController::class, 'carparkingPolicy'])->name('v1.car-parking-policy');
    Route::post('carparking/policy-store', [CarparkingController::class, 'carparkingPolicyStore'])->name('carparking.policy-store');
    Route::post('carparking/policy-list',  [CarparkingController::class, 'carparkingPolicyList'])->name('carparking.policy-list');
    Route::get('carparking/policy-delete/{id?}', [CarparkingController::class, 'carparkingPolicyDelete'])->name('carparking.policy-delete');
    Route::get('carparking/policy-edit/{id?}', [CarparkingController::class, 'carparkingPolicyEdit'])->name('carparking.policy-edit');

    //car parking in
    Route::get('carparking/car-parking-in', [CarparkingController::class, 'carPparkingIn'])->name('carparking.car-parking-in');
    Route::post('carparking/store-car-parking-in', [CarparkingController::class, 'storeCarParkingIn'])->name('carparking.store-car-parking-in');
    Route::post('v1/get-parking-data', [CarparkingController::class, 'getParkingData'])->name('v1.get-parking-data');
    Route::post('v1/save-parking-data', [CarparkingController::class, 'parkingServiceBill'])->name('v1.save-parking-data');
    Route::get('carparking/car-parking-worklist', [CarparkingController::class, 'carParkingWorklist'])->name('carparking.car-parking-worklist');
    Route::get('carparking/print-car-parking-token/{id}', [CarparkingController::class, 'printCarParkingToken'])->name('carparking.print-car-parking-token');

});
