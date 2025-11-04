<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComparativeStatement;
use App\Http\Controllers\InvPurchaseRequisition;
use App\Http\Controllers\InvPurchaseRequisitionApproval;
use App\Http\Controllers\InvFinancialRequisitionApproval;
use App\Http\Controllers\ComparativeStatementApprovalController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockReportController;



Route::middleware(['auth'])->group(function () {
    Route::post('inv-requsition-search',[ InvPurchaseRequisition::class,'invRequisitionSearch'])->name('inv-requsition-search');
    Route::post('inv-comparative-statement-search',[ ComparativeStatement::class,'invComparativeStatementSearch'])->name('inv-comparative-statement-search');
    Route::get('inv-purchase-requestion-print/{req_id?}',[ InvPurchaseRequisition::class,'invPurchaseRequstionPrint'])->name('inv-purchase-requestion-print');

    Route::post('comparative-statement-approval-search',[ ComparativeStatementApprovalController::class,'searchComparativeStatement'])->name('comparative-statement-approval-search');

    Route::post('comparative-statement-approval-print',[ ComparativeStatementApprovalController::class,'printComparativeStatement'])->name('comparative-statement-approval-print');
    Route::post('comparative-statement-passed-print',[ ComparativeStatementApprovalController::class,'printPassedComparativeStatement'])->name('comparative-statement-passed-print');


    Route::resource('inventory-purchase-requisition', InvPurchaseRequisition::class);
    Route::resource('inv-requisition-approval', InvPurchaseRequisitionApproval::class);
    Route::resource('inv-requisition-finan-approval', InvFinancialRequisitionApproval::class);
    Route::resource('comparative-statement', ComparativeStatement::class);
    Route::post('requisition_details',[ComparativeStatement::class, 'requisition_details'])->name('requisition_details');
    Route::get('cs-policy',[ComparativeStatement::class, 'cs_policy'])->name('cs-policy');
    Route::get('single-comparative-statement/{req_no?}/{supplier?}',[ComparativeStatement::class, 'cs_approval_toggle'])->name('single-comparative-statement');
    Route::get('print-comparative-statement/{req_no?}',[ComparativeStatement::class, 'print_comparative_statement'])->name('print-comparative-statement');
    Route::resource('comparative-statement-approval', ComparativeStatementApprovalController::class);


    // supplier payment Process
    Route::get('supplier-payment-request-procurement', [SupplierController::class, 'SuppliPaymentRequestProcurement'])->name('supplier-payment-request-procurement');
    Route::post('supplier-payment-request-procurement-search', [SupplierController::class, 'SuppliPaymentRequestProcurementSearch'])->name('supplier-payment-request-procurement-search');
    Route::post('supplier-payment-request-save', [SupplierController::class, 'SuppliPaymentRequestSave'])->name('supplier-payment-request-save');
    Route::get('supplier-payment-request-worklist', [SupplierController::class, 'SuppliPaymentRequestWorklist'])->name('supplier-payment-request-worklist');
    Route::get('supplier-payment-request-pdf/{id}', [SupplierController::class, 'SuppliPaymentRequestPdf'])->name('supplier-payment-request-pdf');
    Route::post('supplier-payment-request-search', [SupplierController::class, 'SuppliPaymentRequestSearch'])->name('supplier-payment-request-search');
    Route::get('supplier-payment-procurment-approval-worklist', [SupplierController::class, 'SuppliPaymentProcurmentWorklist'])->name('supplier-payment-procurment-approval-worklist');
    Route::post('supplier-payment-procurment-approval-search', [SupplierController::class, 'SuppliPaymentProcurmentSearch'])->name('supplier-payment-procurment-approval-search');
    Route::post('supplier-payment-procurment-approval-save', [SupplierController::class, 'SuppliPaymentApprovalSave'])->name('supplier-payment-procurment-approval-save');
    Route::get('supplier-payment-sent-to-accounts-worklist', [SupplierController::class, 'SuppliPaymentSendToAccountsWorklist'])->name('supplier-payment-sent-to-accounts-worklist');
    Route::post('supplier-payment-sent-to-accounts-worklist-search', [SupplierController::class, 'SuppliPaymentSendToAccountsSearch'])->name('supplier-payment-sent-to-accounts-worklist-search');
    Route::post('supplier-payment-sent-to-accounts-save', [SupplierController::class, 'SuppliPaymentSendToAccountsSave'])->name('supplier-payment-sent-to-accounts-save');

    Route::get('supplier-payment-accounts-worklist', [SupplierController::class, 'SuppliPaymentAccountsWorklist'])->name('supplier-payment-accounts-worklist');
    Route::post('supplier-payment-accounts-worklist-search', [SupplierController::class, 'SuppliPaymentAccountsSearch'])->name('supplier-payment-accounts-worklist-search');
    Route::post('supplier-payment-accounts-save', [SupplierController::class, 'SuppliPaymentAccountsSave'])->name('supplier-payment-accounts-save');

    Route::get('supplier-payment-sent-to-accounts-list', [SupplierController::class, 'SuppliPaymentSendToAccountsList'])->name('supplier-payment-sent-to-accounts-list');
    Route::post('supplier-payment-sent-to-accounts-list-search', [SupplierController::class, 'suppliPaymentSendToAccountsListSearch'])->name('supplier-payment-sent-to-accounts-list-search');
    Route::get('supplier-payment-sent-to-accounts-pdf/{id}', [SupplierController::class, 'SuppliPaymentSendToAccountsPdf'])->name('supplier-payment-sent-to-accounts-pdf');
    Route::post('supplier-payment-sent-to-accounts-all-pdf', [SupplierController::class, 'SuppliPaymentSendToAccountsAllPdf'])->name('supplier-payment-sent-to-accounts-all-pdf');

    Route::get('v1/store-wise-opening-closing-repot', [StockReportController::class, 'storeWiseOpeningClosingReport'])->name('v1.store-wise-opening-closing-repot');
    Route::post('v1/store-wise-opening-closing-balance-print', [StockReportController::class, 'storeWiseOpeningClosingReportPrint'])->name('v1.store-wise-opening-closing-balance-print');


    // Supplier Payment worklist
    Route::get('supplier-payment-worklist-v1', [SupplierController::class, 'supplierPaymentWorklist'])->name('supplier-payment-worklist');
    Route::post('supplier-payment-worklist-search', [SupplierController::class, 'SuppliPaymentSearch'])->name('supplier-payment-worklist-search');
    Route::get('show-grn-bill-progress/{id}', [SupplierController::class, 'grnBillProgress'])->name('show-grn-bill-progress');
    
    Route::get('partial-supplier-payment/{id}', [SupplierController::class, 'partialSupplierPayment'])->name('partial-supplier-payment');
    Route::get('partial-supplier-payment-history/{id}', [SupplierController::class, 'partialSupplierPaymentHistory'])->name('partial-supplier-payment-history');
    Route::post('partial-supplier-payment-entry', [SupplierController::class, 'partialSupplierPaymentEntry'])->name('partial-supplier-payment-entry');
    Route::post('partial-supplier-payment-all', [SupplierController::class, 'partialSupplierPaymentEntryAll'])->name('partial-supplier-payment-all');

});
