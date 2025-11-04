<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
Route::get('/team-setup', [TeamController::class, 'teamSetup'])->name('team.setup');
Route::delete('team/delete/{id}', [TeamController::class, 'teamDelete'])->name('team.delete');
Route::delete('team/member/active/{id}', [TeamController::class, 'activeMember'])->name('team.member-active');
Route::get('/create-marketing-setup', [TeamController::class, 'createMarketingSetup'])->name('create-marketing-setup');
Route::get('/add-new-member-setup/{id?}', [TeamController::class, 'addNewMemberSetup'])->name('add-new-member-setup');
Route::post('/add-new-member-store', [TeamController::class, 'addNewMemberStore'])->name('add-new-member-store');
Route::post('marketing-setup-store', [TeamController::class, 'marketingSetupStore'])->name('marketing-setup-store');
Route::get('/get-team-members/{teamId}', [TeamController::class, 'getTeamMembers'])->name('get-team-members');

Route::get('/team-setup-commission', [TeamController::class, 'teamSetupCommission'])->name('team.setup-commission');
Route::get('/create-marketing-target-setup', [TeamController::class, 'createMarketingTargetSetup'])->name('create-marketing-target-setup');
Route::post('marketing-setup-target-store', [TeamController::class, 'marketingSetupTargetStore'])->name('marketing-setup-target-store');
Route::get('/sales-team-target/edit/{id?}', [TeamController::class, 'salesTeamedit'])->name('edit-marketing-target-setup');




// Marketing Report
Route::get('marketing/marketing-report', [TeamController::class, 'marketingReportMonthWise'])->name('marketing.marketing-report');
Route::post('marketing/marketing-report-search', [TeamController::class, 'marketingReportMonthWiseSearch'])->name('marketing.marketing-report-search');
Route::post('marketing/marketing-report-summaryPdf', [TeamController::class, 'marketingReportMonthWisePrintSummary'])->name('marketing/marketing-report-summaryPdf');


// Marketing Report
Route::get('marketing/marketing-report-income', [TeamController::class, 'marketingReportMonthWiseIncome'])->name('marketing.marketing-report-income');
Route::post('marketing/marketing-report-search-income', [TeamController::class, 'marketingReportMonthWiseSearchIncome'])->name('marketing.marketing-report-search-income');
Route::post('marketing/marketing-report-summaryPdf-income', [TeamController::class, 'marketingReportMonthWisePrintSummaryIncome'])->name('marketing/marketing-report-summaryPdf-income');

// MPO Report
Route::get('marketing/mpo-report', [TeamController::class, 'marketingMpoReportMonthWise'])->name('marketing.mpo-report');
Route::post('marketing/mpo-report-search', [TeamController::class, 'marketingMpoReportMonthWiseSearch'])->name('marketing.mpo-report-search');
Route::post('marketing/mpo-report-summaryPdf', [TeamController::class, 'marketingMpoReportMonthWisePrintSummary'])->name('marketing.mpo-report-summaryPdf');


Route::get('marketing/referral-doctor', [TeamController::class, 'referralDoctor'])->name('marketing.referral-doctor');
Route::get('marketing/get-agents', [TeamController::class, 'getOptions'])->name('marketing.get-agents');
Route::post('marketing/referral-doctor-list', [TeamController::class, 'referralDoctorList'])->name('marketing.referral-doctor-list');
Route::post('marketing/update-checkbox-status', [TeamController::class, 'referralDoctorUpdateCheckboxStatus'])->name('marketing.update-checkbox-status');
Route::post('marketing/update-referral-agent', [TeamController::class, 'referralDoctorUpdateAgent'])->name('marketing.update-referral-agent');
Route::post('marketing/update-referral-type', [TeamController::class, 'referralDoctorUpdateType'])->name('marketing.update-referral-type');
Route::get('/marketing/referral-types', [TeamController::class, 'getReferralTypes'])->name('marketing.get-referral-types');

Route::get('marketing/referral-ledger', [TeamController::class, 'referralLedger'])->name('marketing.referral-ledger');
Route::post('marketing-referral-report-print-search', [TeamController::class, 'referralReportSearch'])->name('marketing.referral-report-print-search');
Route::post('marketing-referral-report-print-excel', [TeamController::class, 'referralReportExcel'])->name('marketing.referral-report-print-excel');
Route::post('marketing-referral-report-print-pdf', [TeamController::class, 'referralReportPdf'])->name('marketing.referral-report-print-pdf');
Route::get('referral-doctor-details/{id?}/{from?}/{to?}', [TeamController::class, 'referralDoctorDetails'])->name('marketing.referral-doctor-details');
Route::get('investigation-wise-details/{id?}/{from?}/{to?}/{mkt_id?}', [TeamController::class, 'investigationWiseDetails'])->name('marketing.investigation-wise-details');
Route::post('/update/referral/checkbox', [TeamController::class, 'updateReferralCheckbox'])->name('update.referral.checkbox');
Route::get('/ledger/print', [TeamController::class, 'printLedger'])->name('ledger.print');

// Marketing Report
Route::get('marketing/referral-report', [TeamController::class, 'referralReport'])->name('marketing.referral-report');
Route::post('marketing-report-print-search', [TeamController::class, 'marketingReportSearch'])->name('marketing.report-print-search');
Route::post('marketing-report-print-excel', [TeamController::class, 'marketingReportExcel'])->name('marketing.-report-print-excel');
Route::post('marketing-report-print-pdf', [TeamController::class, 'marketingReportPdf'])->name('marketing.-report-print-pdf');

// Top Sales Report
Route::get('marketing/top-sales-report', [TeamController::class, 'topSalesReport'])->name('marketing.top-sales-report');
Route::post('marketing-top-sales-report-print-search', [TeamController::class, 'marketingTopSalesReportSearch'])->name('marketing.top-sales-report-print-search');
Route::post('marketing-top-sales-report-print-excel', [TeamController::class, 'marketingTopSalesReportExcel'])->name('marketing.top-sales-report-print-excel');
Route::post('marketing-top-sales-report-print-pdf', [TeamController::class, 'marketingTopSalesReportPdf'])->name('marketing.top-sales-report-print-pdf');

});
