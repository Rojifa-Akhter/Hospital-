<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorporateController;

Route::middleware(['auth'])->group(function () {
    Route::get('corporate/client-entry/form', [CorporateController::class, 'corporateClientEntryForm'])->name('corporate.client-entry-form');
    Route::get('corporate/client-entry', [CorporateController::class, 'corporateClientEntry'])->name('corporate.client-entry');
    Route::get('corporate/client-popup', [CorporateController::class, 'corporateClientEntryPopup'])->name('corporate.client-popup');
    Route::post('corporate/client-store', [CorporateController::class, 'clientStore'])->name('corporate.client-store');
    Route::post('corporate/client-list', [CorporateController::class, 'clientList'])->name('corporate.client-list');
    Route::get('corporate/client-entry/{id?}', [CorporateController::class, 'editCorporateEntry'])->name('corporate.client-entry-edit');



    // Added By Nazmul 20.01.2022
    Route::get('corporate/entry', [CorporateController::class, 'corporateEntry'])->name('corporate.entry');
    Route::post('corporate/entry/store', [CorporateController::class, 'corporateEntryStore'])->name('corporate.entry.store');

    Route::get('corporate/worklist', [CorporateController::class, 'corporateWorklist'])->name('corporate.worklist');
    Route::post('search/corporate/worklist', [CorporateController::class, 'corporateWorklistSearch'])->name('corporate.search-worklist');
    Route::post('search/corporate/worklist/pdf', [CorporateController::class, 'corporateWorklistSearchPdf'])->name('corporate.search-worklist-pdf');
    Route::get('corporate-form', [CorporateController::class, 'getCorporateForm'])->name('corporate-form');
    Route::get('corporate-form-edit/{id?}', [CorporateController::class, 'editCorporateForm'])->name('corporate-form-edit');



    Route::get('corporate/staff-entry', [CorporateController::class, 'corporateStaffEntry'])->name('corporate.staff-entry');
    Route::post('corporate/staff-add', [CorporateController::class, 'corporateStaffAdd'])->name('corporate.staff.add');
    Route::get('corporate/staff-add/form/{id?}', [CorporateController::class, 'corporateStaffAddForm'])->name('corporate.staff-add.form');
    Route::post('corporate/staff/store', [CorporateController::class, 'corporateStaffStore'])->name('corporate.staff.store');
    Route::get('corporate/staff/list', [CorporateController::class, 'getStaffList'])->name('corporate.staff.list');
    Route::get('corporate/staff/edit/{id?}', [CorporateController::class, 'editStaff'])->name('corporate.staff.edit');
    Route::get('corporate/staff/add/dependent/{id?}', [CorporateController::class, 'addStaffDependent'])->name('corporate.staff.dependent');
    Route::post('corporate/staff/store/dependent', [CorporateController::class, 'storeStaffDependent'])->name('store.staff.dependent');
    Route::get('corporate/staff/dependent', [CorporateController::class, 'getStaffDependentList'])->name('corporate.staff.dependent.list');
    Route::get('corporate/dependent/edit/{id?}', [CorporateController::class, 'editDependent'])->name('corporate.dependent.edit');







    Route::get('corporate/policy', [CorporateController::class, 'corporatePolicy'])->name('corporate.policy');
    Route::post('corporate/policy/store', [CorporateController::class, 'storeCorporatePolicy'])->name('corporate.policy.store');
    Route::get('corporate/policy/list', [CorporateController::class, 'corporatePolicyList'])->name('corporate.policy.list');
    Route::get('corporate/policy/edit/{id?}', [CorporateController::class, 'editCorporatePolicy'])->name('corporate.policy.edit');
    Route::get('corporate/policy/show/{id?}', [CorporateController::class, 'showCorporatePolicy'])->name('corporate.policy.show');
    // Route::delete('corporate/policy/delete/{id?}', [CorporateController::class, 'deleteCorporatePolicy'])->name('corporate.policy.delete');
    Route::post('corporate/policy/delete/', [CorporateController::class, 'deleteCorporatePolicy'])->name('corporate.policy.delete');



    // Policy Add
    Route::get('corporate-item-type-policy/{id}/{type?}', [CorporateController::class, 'corporateItemTypePolicy'])->name('corporate.item-type-policy');
    Route::get('corporate-item-type-policy-edit/{id}', [CorporateController::class, 'corporateItemWisePolicyEdit'])->name('corporate.item-type-policy-edit');
    Route::post('corporate-item-typ-store', [CorporateController::class, 'corporateItemTypeStore'])->name('corporate-item-type-store');
    Route::post('item-type-policy-delete', [CorporateController::class, 'itemTypePolicyDelete'])->name('item-type-policy-delete');

    Route::get('corporate-department-type-policy/{id}', [CorporateController::class, 'corporateDepartmentWisePolicy'])->name('corporate-department-type-policy');
    Route::post('corporate-service-unit-type-store', [CorporateController::class, 'corporateUnitType'])->name('corporate-service-unit-type-store');
    Route::get('corporate-dept-wise-policy-edit/{id}', [CorporateController::class, 'corporateDeptWisePolicyEdit'])->name('corporate.dept-wise-policy-edit');

    Route::get('corporate-item-wise-policy/{id}', [CorporateController::class, 'corporateItemWisePolicy'])->name('corporate.item-wise-policy');
    Route::post('corporate--item-wise-data-store', [CorporateController::class, 'corporateItemWiseDataStore'])->name('corporate.item-wise-data-store');
    // Route::get('corporate-item-policy-edit/{id}', [CorporateController::class,'corporateItemTypePolicy'])->name('corporate.item-policy-edit');





    // Reports
    Route::get('reports/corporate-sales-summary', [CorporateController::class, 'corporateSalesSummary'])->name('reports.corporate-sales-summary');
    Route::get('reports/corporate-sales-details', [CorporateController::class, 'corporateSalesDetails'])->name('reports.corporate-sales-details');
    Route::get('reports/corporate-stock-ledger', [CorporateController::class, 'corporateStockLedger'])->name('reports.corporate-stock-ledger');

    Route::post('search/corporate/sales', [CorporateController::class, 'corporateWorklistSalesSearch'])->name('corporate.search-sales-worklist');
    Route::post('search/corporate/sales/pdf', [CorporateController::class, 'corporateWorklistSalesSearchPdf'])->name('corporate.search-sales-worklist-pdf');

    Route::post('search/corporate/stock-ledger', [CorporateController::class, 'corporateWorklistStockSearch'])->name('corporate.search-stock-ledger-worklist');
    Route::post('search/corporate/stock-ledger/pdf', [CorporateController::class, 'corporateWorklistStockSearchPdf'])->name('corporate.search-stock-ledger-worklist-pdf');


    Route::get('reports/corporate-marketing-report', [CorporateController::class, 'corporateMarketingReport'])->name('reports.corporate-marketing-report');
    Route::post('reports/corporate-marketing-report-data', [CorporateController::class, 'corporateMarketingReportData'])->name('reports/corporate-marketing-report-data');
    Route::post('reports/corporate-marketing-report-pdf', [CorporateController::class, 'corporateMarketingReportPdf'])->name('reports/corporate-marketing-report-pdf');




    Route::get('reports/corporate-performance-report-v2', [CorporateController::class, 'corporatePerformanceReportv2'])->name('reports.corporate-performance-report-v2');
    Route::post('reports/corporate-performance-report-data-v2', [CorporateController::class, 'corporatePerformanceReportDatav2'])->name('reports.corporate-performance-report-data-v2');
    Route::post('reports/corporate-performance-report-pdf-v2', [CorporateController::class, 'corporatePerformanceReportPdfv2'])->name('reports.corporate-performance-report-pdf-v2');

});
