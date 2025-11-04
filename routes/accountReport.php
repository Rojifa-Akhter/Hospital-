<?php

use App\Http\Controllers\AccountsReportController;
use App\Http\Controllers\PathologyController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
  Route::get('account/report', [AccountsReportController::class, 'accountReport'])->name('account.report');
  Route::get('account/payment-voucher-report', [AccountsReportController::class, 'accountVoucherReport'])->name('account.payment-voucher-report');
  Route::post('account/payment-voucher-report-search', [AccountsReportController::class, 'accountVoucherReportSearch'])->name('account.payment-voucher-report-search');
  Route::get('account/payment-voucher-report-print/{voucher_id?}', [AccountsReportController::class, 'accountVoucherReportPrint'])->name('account.payment-voucher-report-print');
  Route::get('account/payment-voucher-report-show/{voucher_id?}', [AccountsReportController::class, 'accountVoucherReportShow'])->name('account.payment-voucher-report-show');

  Route::post('account/general-payment-report-search', [AccountsReportController::class, 'accountGeneralPaymentReportSearch'])->name('account.general-payment-report-search');
  Route::post('account/general-payment-report-print', [AccountsReportController::class, 'accountGeneralPaymentReportPrint'])->name('account.general-payment-report-print');
  Route::post('account/profit-loss-report-search', [AccountsReportController::class, 'accountprofitLossReportSearch'])->name('account.profit-loss-report-search');
  Route::post('account/profit-loss-report-print', [AccountsReportController::class, 'accountprofitLossReportPrint'])->name('account.profit-loss-report-print');
  Route::post('accounts/show-profit-loss-data', [AccountsReportController::class, 'generate_profit_loss_data'])->name('accounts.show-profit-loss-data');


  Route::post('financial-statement-search-v1', [AccountsReportController::class, 'financialStatementSearch'])->name('financial-statement-searchv1');
  Route::post('financial-statement-print', [AccountsReportController::class, 'financialStatementPrint'])->name('financial-statement-print');
});