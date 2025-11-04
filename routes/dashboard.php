<?php


use App\Http\Controllers\DashboardItemSetupController;
use App\Http\Controllers\DashboardItemDataQueryController;
use App\Http\Controllers\AccountsIntegrationPaymoodController;
use App\Http\Controllers\AccountsIntegrationPayrollController;
use App\Http\Controllers\DashBoardV2Controller;
use App\Http\Controllers\ChartOfAccountAutocomplete;
use App\Http\Controllers\DashboardPrevilegeController;
use App\Http\Controllers\UserWiseDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::post('dashboard-user-privilege',[DashboardPrevilegeController::class,'dashboardUserPrivilege'])->name('dashboard-user-privilege');


    Route::resource('dashboard-item-setup',DashboardItemSetupController::class);
    Route::resource('dashboard-item-query-setup',DashboardItemDataQueryController::class);
    Route::resource('accounts-integration-paymood',AccountsIntegrationPaymoodController::class);
    Route::resource('accounts-integration-payroll',AccountsIntegrationPayrollController::class);
    Route::resource('dashboard-previlege-setup',DashboardPrevilegeController::class);
    Route::get('dashboard-v2',DashBoardV2Controller::class)->name('dashboard-v2');
    Route::get('pathology/dashboard', [DashBoardV2Controller::class,'pathologyDashboard'])->name('pathology.dashboard');
    Route::get('radiology/dashboard', [DashBoardV2Controller::class,'radiologyDashboard'])->name('radiology.dashboard');

    Route::get('user-wise-dashboard',UserWiseDashboard::class)->name('user-wise-dashboard');
    Route::get('financial-dashboard',[DashBoardV2Controller::class,'getFinancialData'])->name('financial-dashboard');

    Route::post('chart-of-accounts-autocomplete',ChartOfAccountAutocomplete::class)->name('chart-of-accounts-autocomplete');

    Route::get('v1/management-dashboard',[DashBoardV2Controller::class,'managementDashboardV1'])->name('v1.management-dashboard');
    Route::get('v1/ipd-dashboard',[DashBoardV2Controller::class,'ipdDashboard'])->name('v1.ipd-dashboard');
    Route::get('v1/pathology-dashboard',[DashBoardV2Controller::class,'pathologyDashboardV1'])->name('v1.pathology-dashboard');
    Route::get('v1/radiology-dashboard',[DashBoardV2Controller::class,'radiologyDashboardV1'])->name('v1.radiology-dashboard');

    Route::get('dashboard',[DashBoardV2Controller::class,'dashboardV1'])->name('v1.dashboard');



    // v2 dashboard
    Route::get('v2/management-dashboard',[DashBoardV2Controller::class,'managementDashboardV2'])->name('v2.management-dashboard');



    Route::get('v3/management-dashboard',[DashBoardV2Controller::class,'managementDashboardV3'])->name('v3.management-dashboard');
    Route::post('v3/management-dashboard-search', [DashBoardV2Controller::class, 'managementDashboardV3Search'])->name('v3.management-dashboard-search');


});
