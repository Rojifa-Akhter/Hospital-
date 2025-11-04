<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmacyReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockReportController;

Route::middleware(['auth'])->group(function () {
    Route::get('pharmacy/cashier-wise-report', [PharmacyReportController::class, 'pharmacyCashierWiseSummary'])->name('pharmacy.cashier-wise-report');
    Route::post('pharmacy/cashier-wise-report-search', [PharmacyReportController::class, 'cashierWiseReportSearch'])->name('pharmacy.cashier-wise-report-search');
    Route::post('pharmacy/cashier-wise-report-print', [PharmacyReportController::class, 'cashierWiseReportPrint'])->name('pharmacy.cashier-wise-report-print');
    Route::get('pharmacy/stock-adjustment-report', [PharmacyReportController::class, 'stockAdjustmentReport'])->name('pharmacy.stock-adjustment-report');
    Route::post('pharmacy/stock-adjustment-report-search', [PharmacyReportController::class, 'stockAdjustmentReportSearch'])->name('pharmacy.stock-adjustment-report-search');
    Route::post('pharmacy/stock-adjustment-report-pdf', [PharmacyReportController::class, 'stockAdjustmentReportPdf'])->name('pharmacy.stock-adjustment-report-pdf');

    Route::get('pharmacy/stock-adjustment-investigation-report', [PharmacyReportController::class, 'stockAdjustmentInvestgationReport'])->name('pharmacy.stock-adjustment-investigation-report');
    Route::post('pharmacy/stock-adjustment-investigation-report-search', [PharmacyReportController::class, 'stockAdjustmentReportInvestgationSearch'])->name('pharmacy.stock-adjustment-investigation-report-search');
    Route::post('pharmacy/stock-adjustment-investigation-report-pdf', [PharmacyReportController::class, 'stockAdjustmentReporInvestgationtPdf'])->name('pharmacy.stock-adjustment-investigation-report-pdf');



    Route::get('pharmacy/cashier-wise-summary-report', [ReportController::class, 'pharmacyCashierSummaryReport'])->name('pharmacy.cashier-wise-summary-report');
    Route::post('pharmacy/cashier-wise-summary-report-search', [ReportController::class, 'pharmacyCashierSummaryReportSearch'])->name('pharmacy.cashier-wise-report-summary-search');
    Route::post('pharmacy/cashier-wise-summary-report-print', [ReportController::class, 'pharmacyCashierSummaryReportPrint'])->name('pharmacy.cashier-wise-report-summary-print');

    //Supplier Purchase Summary
    Route::get('supplier-wise-purchase-summary-report', [PharmacyReportController::class, 'supplierWisePurchaseSummaryReport'])->name('supplier-wise-purchase-summary-report');
    Route::post('search-supplier-wise-summary-report', [PharmacyReportController::class, 'searchSupplierWisePurchaseSummaryReport'])->name('search-supplier-wise-purchase-summary-report');
    Route::post('supplier-wise-summary-report-pdf', [PharmacyReportController::class, 'supplierWisePurchaseSummaryReportPDF'])->name('supplier-wise-purchase-summary-report-pdf');
     //Supplier sales Summary report
     Route::get('supplier-wise-sales-report', [PharmacyReportController::class, 'supplierWiseSalesReport'])->name('supplier-wise-sales-report');
     Route::post('search-supplier-wise-sales-report', [PharmacyReportController::class, 'searchSupplierWiseSalesReport'])->name('search-supplier-wise-sales-report');
     Route::post('supplier-wise-sales-report-pdf', [PharmacyReportController::class, 'supplierWiseSalesReportPDF'])->name('supplier-wise-sales-report-pdf');

     Route::get('supplier-wise-sales-summary-report', [PharmacyReportController::class, 'supplierWiseSalesSummaryReport'])->name('supplier-wise-sales-summary-report');
     Route::post('search-supplier-wise-sales-summary-report', [PharmacyReportController::class, 'searchSupplierWiseSalesSummaryReport'])->name('search-supplier-wise-sales-summary-report');
     Route::post('search-supplier-wise-sales-summary-report-pdf', [PharmacyReportController::class, 'supplierWiseSalesSummaryReportPDF'])->name('search-supplier-wise-sales-summary-report-pdf');
    // sales return report 
    Route::get('sales-return-report', [PharmacyReportController::class, 'salesReturnReport'])->name('sales-return-report');
    Route::post('search-sales-return-report', [PharmacyReportController::class, 'searchSalesReturnReport'])->name('search-sales-return-report');
    Route::post('sales-return-report-pdf', [PharmacyReportController::class, 'salesReturnReportPDF'])->name('sales-return-report-pdf');


    //Supplier ITem wise Purchase Report
    Route::get('supplier-wise-purchase-item-report', [PharmacyReportController::class, 'supplierWisePurchaseItemReport'])->name('supplier-wise-purchase-item-report');
    Route::post('search-supplier-wise-purchase-item-report', [PharmacyReportController::class, 'searchSupplierWisePurchaseItemSummaryReport'])->name('search-supplier-wise-purchase-item-report');
    Route::post('supplier-wise-purchase-item-report-pdf', [PharmacyReportController::class, 'supplierWisePurchaseItemSummaryReportPDF'])->name('supplier-wise-purchase-item-report-pdf');
    Route::post('supplier-wise-purchase-item-report-summary-pdf', [PharmacyReportController::class, 'supplierWisePurchaseItemSummaryReport'])->name('supplier-wise-purchase-item-report-summary-pdf');

    Route::get('invoice-wise-profit-loss-report', [PharmacyReportController::class, 'invoiceWiseProfitLossReport'])->name('invoice-wise-profil-loss-report');
    Route::post('search-invoice-wise-profit-loss-report', [PharmacyReportController::class, 'searchInvoiceWiseProfitLossReport'])->name('search-invoice-wise-profil-loss-report');
    Route::post('invoice-wise-profit-loss-report-pdf', [PharmacyReportController::class, 'searchInvoiceWiseProfitLossReport'])->name('invoice-wise-profil-loss-report-pdf');
    //   Route::post('search-supplier-wise-summary-report', [PharmacyReportController::class, 'searchSupplierWisePurchaseSummaryReport'])->name('search-supplier-wise-purchase-summary-report');
    // Route::post('supplier-wise-summary-report-pdf', [PharmacyReportController::class, 'supplierWisePurchaseSummaryReportPDF'])->name('supplier-wise-purchase-summary-report-pdf');







    Route::get('v1/pharmacy-profit-report-transaction-wise', [StockReportController::class, 'pharmacyProfitReportTransactionWise'])->name('v1.pharmacy-profit-report-transaction-wise');
    Route::post('v1/search-pharmacy-profit-report-transaction-wise', [StockReportController::class, 'searchPharmacyProfitReportTransactionWise'])->name('v1.search-pharmacy-profit-report-transaction-wise');

    Route::get('v1/pharmacy-profit-report-month-wise-item', [StockReportController::class, 'pharmacyProfitReportMonthWiseItem'])->name('v1.pharmacy-profit-report-month-wise-item');
    Route::post('v1/search-pharmacy-profit-report-month-wise-item', [StockReportController::class, 'searchPharmacyProfitReportMonthWiseItem'])->name('v1.search-pharmacy-profit-report-month-wise-item');

    Route::get('v1/pharmacy-profit-summery-report', [StockReportController::class, 'pharmacyProfitSummeryReport'])->name('v1.pharmacy-profit-summery-report');
    Route::post('v1/search-pharmacy-profit-summery-report', [StockReportController::class, 'searchPharmacyProfitSummeryReport'])->name('v1.search-pharmacy-profit-summery-report');
    Route::get('v1/pharmacy-profit-report-invoice-wise', [StockReportController::class, 'pharmacyProfitReportInvoiceWise'])->name('v1.pharmacy-profit-report-invoice-wise');
    Route::post('v1/search-pharmacy-profit-report-invoice-wise', [StockReportController::class, 'searchPharmacyProfitReportInvoiceWise'])->name('v1.search-pharmacy-profit-report-invoice-wise');
    Route::post('v1/search-pharmacy-profit-report-date-wise', [StockReportController::class, 'searchPharmacyProfitReportDateWise'])->name('v1.search-pharmacy-profit-report-date-wise');
    Route::post('v1/search-pharmacy-profit-report-invoice-excel', [StockReportController::class, 'excelPharmacyProfitReportInvoiceWise'])->name('v1.search-pharmacy-profit-report-invoice-excel');

    /*
    | Stock Report
    */
    //Route::get('v1/pharmacy-stock-report', [StockReportController::class, 'pharmacyStockReport'])->name('v1.pharmacy-stock-report');
    Route::get('v1/pharmacy-stock-report', [StockReportController::class, 'store_stock_report'])->name('v1.pharmacy-stock-report');
    Route::post('v1/search-pharmacy-stock-report', [StockReportController::class, 'store_stock_report_print'])->name('v1.search-pharmacy-stock-report');
    Route::post('v1/search-pharmacy-stock-report_excel', [StockReportController::class, 'store_stock_report_excel'])->name('v1.search-pharmacy-stock-report-excel');

    Route::get('v1/pharmacy-stock-detail-report', [StockReportController::class, 'store_stock_detail_report'])->name('v1.pharmacy-stock-detail-report');
    Route::post('v1/search-pharmacy-stock-detail-report', [StockReportController::class, 'store_stock_report_detail_print'])->name('v1.search-pharmacy-stock-detail-report');
    Route::post('v1/search-pharmacy-stock-report_detail_excel', [StockReportController::class, 'store_stock_report_excel'])->name('v1.search-pharmacy-stock-report-detail-excel');


    Route::get('test/phone', [StockReportController::class, 'test'])->name('test.phone');


    Route::get('pharmacy/inter-department-report', [PharmacyReportController::class, 'interDepartmentReport'])->name('pharmacy.inter-department-report');
    Route::post('pharmacy/inter-department-report-search', [PharmacyReportController::class, 'interDepartmentSearch'])->name('pharmacy.inter-department-report-search');
    Route::post('pharmacy/inter-department-report-pdf', [PharmacyReportController::class, 'interDepartmentPdf'])->name('pharmacy.inter-department-report-pdf');



    // pharmacy report
    Route::get('pharmacy/purchase-order-thirty-days', [PharmacyReportController::class, 'pharmacyReportThirtyDays'])->name('pharmacy.purchase-order-thirty-days');
    Route::get('pharmacy/summary-report', [PharmacyReportController::class, 'pharmacySummaryReport'])->name('pharmacy.summary-report');
    Route::get('pharmacy/product-shortage-report', [PharmacyReportController::class, 'pharmacyProductShortageReport'])->name('pharmacy.product-shortage-report');
    Route::get('pharmacy/drug-department-wise-report', [PharmacyReportController::class, 'pharmacyDrugDepartmentWiseReport'])->name('pharmacy.drug-department-wise-report');
    Route::get('pharmacy/drug-department-wise-ledger', [PharmacyReportController::class, 'pharmacyDrugDepartmentWiseLedger'])->name('pharmacy.drug-department-wise-ledger');
    Route::get('pharmacy/periodical-purchase-supplier-and-item', [PharmacyReportController::class, 'pharmacyPeriodicalPurchaseSupplierWise'])->name('pharmacy.periodical-purchase-supplier-and-item');
    Route::get('pharmacy/top-selling-item', [PharmacyReportController::class, 'topSellingItem'])->name('pharmacy.top-selling-item');
    Route::post('pharmacy/top-selling-search', [PharmacyReportController::class, 'topSellingSearch'])->name('pharmacy.top-selling-search');
    Route::post('pharmacy/top-selling-pdf', [PharmacyReportController::class, 'topSellingPdf'])->name('pharmacy.top-selling-pdf');

});
