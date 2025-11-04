<?php

use App\Http\Controllers\AssetDepreciationController;
use App\Http\Controllers\StaffBenefitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('asset-depreciations', [AssetDepreciationController::class, 'index'])->name('asset-depreciations.index');
    Route::post('asset-depreciations/search', [AssetDepreciationController::class, 'assetDepreciationsSearch'])->name('asset-depreciations.search');
    Route::post('asset-depreciations/save', [AssetDepreciationController::class, 'assetDepreciationsSave'])->name('asset-depreciations.save');

    Route::post('get-sub-category-by-category', [AssetDepreciationController::class, 'getSubCategoryByCategory'])->name('get-sub-category-by-category');

    Route::get('asset-depreciations/master', [AssetDepreciationController::class, 'assetDepreciationsMaster'])->name('asset-depreciations.master');

    Route::get('asset-depreciations/excel', [AssetDepreciationController::class, 'assetDepreciationsExcel'])->name('asset-depreciations.excel');

    //***********************************************************************************************************************************/

    // Route::get('enquiry-activities', 'BillingController@enquiryActivities')->name('enquiry-activities');

    // Route::post('asset-depreciations/delete', [AssetDepreciationController::class, 'assetDepreciationsDelete'])->name('asset-depreciations.delete');

    Route::get('staff-benefits', [StaffBenefitController::class, 'index'])->name('staff-benefits.index');
    Route::post('staff-benefits', [StaffBenefitController::class, 'store'])->name('staff-benefits.store');
    Route::get('staff-benefits/list', [StaffBenefitController::class, 'list'])->name('staff-benefits.list');

    Route::post('staff-benefits/opd-list', [StaffBenefitController::class, 'opdList'])->name('staff-benefits.opd-list');
    Route::post('staff-benefits/ipd-list', [StaffBenefitController::class, 'ipdList'])->name('staff-benefits.ipd-list');

    Route::post('staff-benefits/data', [StaffBenefitController::class, 'staffBenefitsListData'])->name('staff-benefits.listing.data');
    Route::get('staff-benefits/{id}/details', [StaffBenefitController::class, 'staffBenefitsListDetails'])->name('staff-benefits.listing.details');
});
