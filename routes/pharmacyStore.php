<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StockReportController;

Route::middleware(['auth'])->group(function () {

    // Added By Asif
    Route::get('inventory/item-received', [StoreController::class, 'item_received'])->name('inventory.item_receive');

    // search data form item receive list
    Route::post('item_receive/search', [StoreController::class, 'search_receive'])->name('inventory.serach_receive');

    //Route::get('inventory/item-return-by_chalan', [StoreController::class, 'item_return_by_chalan'])->name('inventory.item_return');

    Route::get('inventory/new-item-receive-by-chalan', [StoreController::class, 'new_receive_by_chalan'])->name('inventory.new_item_receive_by_chalan');
    Route::get('inventory/new-item-receive-by-chalan-vat', [StoreController::class, 'new_receive_by_chalan_vat'])->name('inventory.new_item_receive_by_chalan_vat');

    Route::post('item_receive/autocomplete', [StoreController::class, 'autocomplete_iteminfo'])->name('item-info-autocomplete');

    Route::post('item_receive/new-item-receive', [StoreController::class, 'storeReceive'])->name('inventory.new-item-receive');

    //Route::get('inventory/item-received-worklist', [StoreController::class, 'item_received_worklist'])->name('inventory.item_received_worklist');

    // start pharmacy stock ledger
   // Route::get('inventory/stock-ledger', [StoreController::class, 'pharmacy_stock_ledger'])->name('inventory.stock-ledger');

    Route::post('inventory/search_stock_ledger', [StoreController::class, 'search_stock'])->name('inventory.search_stock_ledger');

    Route::get('inventory/store_stock_ledger', 'StoreController@store_stock_ledger')->name('inventory.store_stock_ledger');

    Route::post('inventory/stock_details', [StoreController::class, 'stock_details'])->name('inventory.stock_details');
    Route::post('inventory/search_stock_details', [StoreController::class, 'search_stock_details'])->name('inventory.search_stock_details');

    Route::post('inventory/print_stock_details', [StoreController::class, 'print_stock_details'])->name('inventory.print_stock_details');

    Route::post('inventory/print_inv_main_store_stock', [StoreController::class, 'print_inv_store_stock'])->name('inventory.print_inv_main_store_stock');
    Route::post('inventory/print_inv_main_store_stock_grn_report', [StoreController::class, 'print_inv_store_stock_grm_report'])->name('inventory.print_inv_main_store_stock_grn_report');
    Route::post('inventory/print_store_stock_ledger', [StoreController::class, 'print_inv_store_stock_ledger'])->name('inventory.print_store_stock_ledger');
    Route::post('inventory/print_store_stock_ledger/v1', [StoreController::class, 'print_inv_store_stock_ledger_v1'])->name('inventory.print_store_stock_ledger_v1');
    Route::post('pharmacy/print_store_stock_ledger', [StoreController::class, 'print_store_stock_ledger'])->name('pharmacy.print_store_stock_ledger');

    Route::get('inventory/store_stock_ledger', 'StoreController@store_stock_ledger')->name('inventory.store_stock_ledger');

    // Item return Form
    //Route::get('inventory/item-return-by_chalan', [StoreController::class, 'item_return_by_chalan'])->name('inventory.item_return');

    //Store item return form data
    Route::post('inventory/store-purchase-order', [StoreController::class, 'storePurchaseOrder'])->name('inventory.store_purchase_order');

    //Route::get('inventory/item_return_worklist', [StoreController::class, 'item_return_worklist'])->name('inventory.item_return_worklist');

    Route::post('inventory/default-supplier-items', [StoreController::class, 'defaultSupplierItems'])->name('inventory.default_supplier_items');

    Route::post('inventory/last-supplier-purchase-order-items', [StoreController::class, 'lastSupplierPurchaseOrderItems'])->name('inventory.last_supplier_purchase_order_items');

    Route::get('inventory/purchase-order-worklist', [StoreController::class, 'purchaseOrderWorklist'])->name('inventory.purchase_order_worklist');


    Route::get('inventory/stock-in-out', [StoreController::class, 'stockInOut'])->name('inventory.stock_in_out');

    Route::get('inventory/create-stock-in-out', [StoreController::class, 'createStockInOut'])->name('inventory.create_stock_in_out');

    Route::post('inventory/store-stock-in-out', [StoreController::class, 'storeStockInOut'])->name('inventory.store_stock_in_out');

    Route::get('inventory/stock-out-worklist', [StoreController::class, 'stockOutWorklist'])->name('inventory.stock_out_worklist');

    // Added By Nazmul
    Route::get('grn-report-print/{id?}/{type?}', [StoreController::class, 'grnReport'])->name('grn-report-print');
    Route::get('grn-report-print-inv-vat/{id?}/{type?}', [StoreController::class, 'grnReportInvVat'])->name('grn-report-print-inv-vat');
    Route::get('pharmacy/grn-report-print/{id?}/{type?}', [StoreController::class, 'phrGrnReport'])->name('pharmacy.grn-report-print');
    Route::get('grn-report-print-vat/{id?}/{type?}', [StoreController::class, 'grnReportVat'])->name('grn-report-print-vat');

    Route::get("store/report/pharmacy-store-stock",[StockReportController::class, "store_stock_report"])->name('store.report.pharmacy-store-stock');
    Route::get("store/report/pharmacy-store-stock-print",[StockReportController::class, "store_stock_report_print"])->name('store.report.pharmacy-store-stock-print');
});
