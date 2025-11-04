<?php

use App\Library\Template;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\getDepositAmt;
use App\Http\Controllers\IPDController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\HOSGrnController;
use App\Http\Controllers\HOSPurchaseOrder;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\HOSItemController;
use App\Http\Controllers\ComparativeStatement;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HOSBillingController;
use App\Http\Controllers\HOSgetPassController;
use App\Http\Controllers\HOSUtilityController;
use App\Http\Controllers\FixedAssetsController;
use App\Http\Controllers\HOSItemIssueController;
use App\Http\Controllers\HOSUomLookupController;
use App\Http\Controllers\HOSUtilitiesController;
use App\Http\Controllers\HOSDepartmentConsumption;
use App\Http\Controllers\HOSItemReceiveController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\HOSApprovalMatrixController;
use App\Http\Controllers\HOSSupplierReturnController;
use App\Http\Controllers\HOSTermsconditionController;
use App\Http\Controllers\FixedAssetsDiscardController;
use App\Http\Controllers\HOSDepartmentIndentController;
use App\Http\Controllers\HOSPatientAppointmentController;
use App\Http\Controllers\HOSPatientRegistrationController;
use App\Http\Controllers\PurchaseAccountBookController;
use App\Http\Controllers\HRM\EmployeePortalController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CarparkingController;
use App\Models\PurchaseOrderMaster;


Route::middleware(['auth'])->group(function () {
    // Patient List
    Route::get('uhl/patient-list', [HOSPatientRegistrationController::class, 'index'])->name('uhl.patient-details');
    Route::get('uhl/patient-registration', [HOSPatientRegistrationController::class, 'create'])->name('uhl.patient-registration');
    Route::post('get-employee-info-from-registraion', [HOSPatientRegistrationController::class, 'getEmpInfoFromPatReg'])->name('get-employee-info-from-registraion');
    Route::get('uhl/patient-registration-edit/{id}', [HOSPatientRegistrationController::class, 'edit'])->name('uhl.patient-registration-edit');
    Route::post('uhl/patient-registration', [HOSPatientRegistrationController::class, 'store'])->name('uhl.patient-registration-store');
    Route::get('uhl/wristband-self-print/{id}', [HOSPatientRegistrationController::class, 'wristBandSelfAttendent'])->name('uhl.wristband-self-print');
    Route::get('uhl/wristband-ipd-print/{id}', [HOSPatientRegistrationController::class, 'wristBandIpd'])->name('uhl.wristband-ipd-print');
    Route::get('dmhl/level-ipd-print/{id}', [HOSPatientRegistrationController::class, 'ipdLevelPrint'])->name('dmhl.level-ipd-print');
    // End

    //Quick Registration
    Route::get('uhl/patient-quick-registration', [HOSPatientRegistrationController::class, 'quickRegistration'])->name('uhl.patient-quick-registration');
    Route::post('uhl/patient-registration-v2', [HOSPatientRegistrationController::class, 'store_v2'])->name('uhl.patient-registration-store-v2');
    Route::get('uhl/patient-service-type/{patient_id?}', [HOSPatientRegistrationController::class, 'patientServiceType'])->name('uhl.patient-service-type');
    Route::post('uhl/patient-service-type-store', [HOSPatientRegistrationController::class, 'patientServiceTypeStore'])->name('uhl.patient-service-type-store');
    Route::get('uhl/patient-service-type-worklist', [HOSPatientRegistrationController::class, 'patientServiceTypeList'])->name('uhl.patient-service-type-worklist');

    //Appointment
    Route::get('uhl/appointment', [HOSPatientAppointmentController::class, 'create'])->name('uhl.appointment');
    Route::get('uhl/appointment-edit/{appoint_no_fk}', [HOSPatientAppointmentController::class, 'edit'])->name('uhl.appointment-edit');
    Route::post('uhl/appointment-update', [HOSPatientAppointmentController::class, 'update'])->name('uhl.appointment-update');
    Route::post('uhl/get-appointment-details-info', [HOSPatientAppointmentController::class, 'getDoctorsListBySpeclDate'])->name('uhl.get-appointment-details-info');
    Route::post('uhl/get-doctor-details-info', [HOSPatientAppointmentController::class, 'getDoctorsListByDate'])->name('uhl.get-doctor-details-info');
    Route::get('uhl/appointment-details/{schedule_no_fk?}', [HOSPatientAppointmentController::class, 'appointmentDetails'])->name('uhl.appointment-details');
    Route::get('uhl/chat-appointment', [HOSPatientAppointmentController::class, 'chatAppointment'])->name('uhl.chat-appointment');
    Route::post('uhl/store-appointment', [HOSPatientAppointmentController::class, 'store'])->name('uhl.store-appointment');
    Route::post('uhl/store-chat-appointment', [HOSPatientAppointmentController::class, 'chat'])->name('uhl.store-chat-appointment');
    Route::get('uhl-appointment-card/{appoint_no_fk}', [HOSPatientAppointmentController::class, 'appointmentCard'])->name('uhl.appointment-card');
    Route::get('uhl-appointment-form/{appoint_no_fk}', [HOSPatientAppointmentController::class, 'appointmentForm'])->name('uhl.appointment-form');
    Route::post('uhl/app-status-change', [HOSPatientAppointmentController::class, 'appStatusChange'])->name('uhl.app-status-change');
    Route::get('uhl/cancel-appointment/{appoint_no_fk}', [HOSPatientAppointmentController::class, 'cancelAppointment'])->name('uhl.cancel-appointment');
    Route::post('uhl/update-cancel-appointment', [HOSPatientAppointmentController::class, 'updateCancelAppointment'])->name('uhl.update-cancel-appointment');
    Route::get('uhl/slot-block/{slot_no_fk}', [HOSPatientAppointmentController::class, 'slotBlock'])->name('uhl.slot-block');
    Route::post('uhl/update-slot-block', [HOSPatientAppointmentController::class, 'updateSlotBlock'])->name('uhl.update-slot-block');
    Route::post('uhl/array-slot-block', [HOSPatientAppointmentController::class, 'arraySlotBlock'])->name('uhl.array-slot-block');
    Route::post('uhl/get-appointment-list', [HOSPatientAppointmentController::class, 'getAppointmentList'])->name('uhl.get-appointment-list');
    Route::get('uhl/calling-note/{appoint_no_pk}', [HOSPatientAppointmentController::class, 'callingNote'])->name('uhl.calling-note');
    Route::post('uhl/update-calling-note', [HOSPatientAppointmentController::class, 'updatecallingNote'])->name('uhl.update-calling-note');
    Route::get('uhl/slot-block-release/{slot_no_fk}', [HOSPatientAppointmentController::class, 'slotBlockRelease'])->name('uhl.slot-block-release');
    Route::get('uhl/appointment-update/{app_id}', [HOSPatientAppointmentController::class, 'appointmentUpdate'])->name('uhl.appointment-update');
    Route::post('uhl/update-pat-id', [HOSPatientAppointmentController::class, 'updatePatId'])->name('uhl.update-pat-id');
    Route::post('uhl/add-slot', [HOSPatientAppointmentController::class, 'addSlot'])->name('uhl.add-slot');
    //  End



    Route::get('uhl/billing-invoice-form/{id?}', [HOSBillingController::class, 'hos_service_billing'])->name('uhl.billing-invoice-form');
    Route::get('uhl/billing-invoice-form-v4/{id?}', [HOSBillingController::class, 'hos_service_billing_v4'])->name('uhl.billing-invoice-form-v4');
    Route::post('billing/store-uhl', [BillingController::class, 'storeUhl'])->name('billing.store-uhl');
    Route::post('billing/store-uhl-v4', [BillingController::class, 'storeUhlV4'])->name('billing.store-uhl-v4');
    Route::post('get_deposit_amt', [HOSBillingController::class, 'getDepositAmt'])->name('get_deposit_amt');

    Route::get('uhl/requisition-status', function () {
        return Template::loadView("admin.uhl.inventory.requisition-status");
    })->name('uhl.requisition-status');
    Route::get('v1/department-consumption/{id?}', [HOSDepartmentConsumption::class, 'create'])->name('uhl.department-consumption');
    // Route::get('uhl/department-consumption', function () {
    //     return Template::loadView("admin.uhl.inventory.department-consumption");
    // })->name('uhl.department-consumption');

    Route::get('uhl/receipt-from-store', function () { return Template::loadView("admin.uhl.inventory.receipt-from-store");})->name('uhl.receipt-from-store');

    Route::get('v1/item-receive-grn/{po_id?}', [HOSGrnController::class, 'index'])->name('v1.item-receive-grn');
    Route::get('v1/item-receive-grn-fromGrnList/{grn_id?}', [HOSGrnController::class, 'grnFromList'])->name('v1.item-receive-grn-fromGrnList');
    Route::post('v1/item-store-receive', [HOSGrnController::class, 'storeReceive'])->name('v1.item-store-receive');
    Route::post('v1/po-info-for-grn-html', [HOSGrnController::class, 'po_info_html'])->name('v1.po-info-for-grn-html');
    Route::post('v1/po-info-for-grn', [HOSGrnController::class, 'po_info'])->name('v1.po-info-for-grn');
    Route::post('v1/pr-info-for-grn', [HOSGrnController::class, 'pr_info'])->name('v1.pr-info-for-grn');
    Route::post('v1/pr-info-for-grn-html', [HOSGrnController::class, 'pr_info_html'])->name('v1.pr-info-for-grn-html');
    Route::post('v1/saved-grn-info', [HOSGrnController::class, 'saved_grn_info'])->name('v1.saved-grn-info');
    Route::post('v1/saved-grn-info-html', [HOSGrnController::class, 'saved_grn_info_html'])->name('v1.saved-grn-info-html');

    Route::get('v1/pr-list-popup', [HOSGrnController::class, 'prListPopup'])->name('v1.pr-list-popup');
    Route::post('v1/search-pr-list-for-popup', [HOSGrnController::class, 'searchPRListforPopup'])->name('v1.search-pr-list-for-popup');


    Route::get('v1/supplier-return', [HOSSupplierReturnController::class, 'index'])->name('v1.supplier-return');
    Route::post('v1/search-supplier-return', [HOSSupplierReturnController::class, 'srch_supplier_return_WorkList'])->name('v1.search-supplier-return');
    Route::post('v1/supplier-return-grn-item', [HOSSupplierReturnController::class, 'get_grn_item_list'])->name('v1.supplier-return-grn-item');
    Route::post('v1/save-supplier-return', [HOSSupplierReturnController::class, 'save_supplier_return'])->name('v1.save-supplier-return');
    Route::get('v1/supplier-return-worklist', [HOSSupplierReturnController::class, 'supplier_return_WorkList'])->name('v1.supplier-return-worklist');
    Route::get('v1/supplier-return/{rtn_id}', [HOSSupplierReturnController::class, 'edit_supplier_return'])->name('v1.edit-supplier-return');
    Route::get('v1/supplier-return-print/{id}', [HOSSupplierReturnController::class, 'supplier_return_prnt'])->name('v1.supplier-return-print');

    // Route::get('uhl/supplier-return', function () {
    //     return Template::loadView("admin.uhl.inventory.supplier-return");
    // })->name('uhl.supplier-return');

    // grn receive report for main store
    Route::get('inventory/grn-receive-report-main-store', [StoreController::class, 'grn_receive_report_main_store'])->name('inventory.grn-receive-report-main-store');
    Route::post('inventory/search-grn-receive-report-main-store', [StoreController::class, 'search_grn_receive_report_main_store'])->name('inventory.search-grn-receive-report-main-store');
    Route::post('inventory/print_grn_receive_report_main_store', [StoreController::class, 'print_grn_receive_report_main_store'])->name('inventory.print_grn_receive_report_main_store');

    // issue report
    Route::get('inventory/item-issue-report-main-store', [StoreController::class, 'item_issue_report_main_store'])->name('inventory.item-issue-report-main-store');
    Route::post('inventory/search-item-issue-report-main-store', [StoreController::class, 'search_item_issue_report_main_store'])->name('inventory.search-item-issue-report-main-store');
    Route::post('inventory/print_item_issue_report_main_store', [StoreController::class, 'print_item_issue_report_main_store'])->name('inventory.print_item_issue_report_main_store');


    //end report

    Route::get('uhl/create-purchase-order', function () {
        return Template::loadView("admin.uhl.inventory.create-purchase-order");
    })->name('uhl.create-purchase-order');

    // pharmacy item setup
    Route::get('v1/uhl-pharmacy-item-list', [HOSItemController::class, 'pharmacyItemList'])->name('v1.uhl-pharmacy-item-list');
    Route::post('uhl/uhl-pharmacy-search-item-list', [HOSItemController::class, 'pharmacySearchItemListV1'])->name('uhl.uhl-pharmacy-search-item-list');
    Route::post('uhl/pharmacy-item-list-print', [HOSItemController::class, 'pharmacyItemListPrint'])->name('uhl.pharmacy-item-list-print');

    // end pharmacy item setup

    Route::get('v1/uhl-item-list', [HOSItemController::class, 'index'])->name('v1.uhl-item-list');

    Route::get('v1/uhl-inventory-item-list/{type?}', [HOSItemController::class, 'inventoryItemList'])->name('v1.uhl-inventory-item-list')->defaults('type', 'INV');
    Route::get('v1/uhl-service-item-list/{type?}', [HOSItemController::class, 'inventoryItemList'])->name('v1.uhl-service-item-list')->defaults('type', 'SERVICE');
    Route::get('v1/uhl-med-item-list/{type?}', [HOSItemController::class, 'inventoryItemList'])->name('v1.uhl-med-item-list')->defaults('type', 'PHR');
    Route::get('v1/uhl-others-item-list/{type?}', [HOSItemController::class, 'inventoryItemList'])->name('v1.uhl-others-item-list');

    // item rate list
    Route::get('v1/uhl-item-rate-list/{type?}', [HOSItemController::class, 'itemRateList'])->name('v1.uhl-item-rate-list')->defaults('type', 'SERVICE');
    Route::get("v1/item-rate-list-details/{id}/{ind?}", [HOSItemController::class, 'showItemRate'])->name('v1.item-rate-list-details');



    Route::get('v1/uhl-cafe-item-list/{type?}', [HOSItemController::class, 'inventoryItemListCafe'])->name('v1.uhl-cafe-item-list')->defaults('type', 'CAFE');

    Route::post('uhl/uhl-search-item-list', [HOSItemController::class, 'searchItemListV1'])->name('uhl.uhl-search-item-list');
    Route::post('uhl/uhl-inv-search-item-list', [HOSItemController::class, 'invSearchItemListV1'])->name('uhl.uhl-inv-search-item-list');
    Route::post('uhl/search-item-list', [HOSItemController::class, 'searchItemList'])->name('uhl.search-item-list');
    Route::post('uhl/item-list-print', [HOSItemController::class, 'ItemListPrint'])->name('uhl.item-list-print');
    Route::post('uhl/inventory-item-list-print', [HOSItemController::class, 'InventoryItemListPrint'])->name('uhl.inventory-item-list-print');

    Route::get('v1/uhl-new-item', [HOSItemController::class, 'item_setup'])->name('v1.uhl-new-item');
    Route::get('v1/uhl-inventory-new-item', [HOSItemController::class, 'inventory_item_setup'])->name('v1.uhl-inventory-new-item');
    Route::get("uhl/item-edit/{id}/{ind?}", [HOSItemController::class, 'edit'])->name('uhl.item.edit');
    Route::get("uhl/inventory-item-edit/{id}/{ind?}/{rp_type?}", [HOSItemController::class, 'inventoryEdit'])->name('uhl.inventory.item.edit');
    Route::post("check-item-stock",[HOSItemController::class,'checkItemStock'])->name("check-item-stock");
    Route::post('uhl/item/store', [HOSItemController::class, 'store'])->name('uhl.item.store');
    Route::get('uhl/uom-lookup/create', [HOSUomLookupController::class, 'create'])->name('uhl.uom.lookup.create');
    Route::get('uhl/uom-lookup/create_form', [HOSUomLookupController::class, 'create_form'])->name('uhl.uom.lookup.create_form');
    Route::get('uhl/uom-lookup/edit/{id}', [HOSUomLookupController::class, 'edit'])->name('uhl.uom.lookup.edit');
    Route::post('uhl/uom-lookup/store', [HOSUomLookupController::class, 'store'])->name('uhl.uom.lookup.store');
    Route::get('uhl/uom-lookup/', [HOSUomLookupController::class, 'index'])->name('uhl.uom.lookup.index');
    Route::post('uhl/uom-lookup/lookup-list', [HOSUomLookupController::class, 'getAllLookupitems'])->name('uhl.lookup.uom.lookup_list');
    Route::get('uhl/uom-lookup/get-uom-list/{uom_pk_no}', [HOSUtilitiesController::class, 'getUOMData'])->name('uhl.get-uom-val');

    Route::get('uhl/uhl-new-item', [HOSItemController::class, 'item_setup'])->name('uhl.uhl-new-item');
    Route::get('uhl/uhl-new-inventory-item', [HOSItemController::class, 'inventory_item_setup'])->name('uhl.uhl-new-inventory-item');
    Route::get('uhl/uhl-new-inventory-item/minor-group/{major_id?}', [HOSItemController::class, 'getInventoryMinorGroup'])->name('uhl.uhl-new-inventory-item.getInventoryMinorGroup');

    //For quick save item
    Route::get('uhl/quick-new-inventory', [HOSItemController::class, 'quick_inventory_item_setup'])->name('uhl.quick-new-inventory');

    // Purchase Order
    Route::post('v1/last-supplier-purchase-order-items', [HOSPurchaseOrder::class, 'pharmacylastSupplierPurchaseOrderItems'])->name('v1.last_supplier_purchase_order_items');
    Route::post('v1/populate-default-items-from-last-purchase', [HOSPurchaseOrder::class, 'populateDefaultItemsFromLastPurchase'])->name('v1.populate-default-items-from-last-purchase');
    Route::post('v1/default-supplier-items',  [HOSPurchaseOrder::class, 'pharmacydefaultSupplierItems'])->name('v1.default_supplier_items');
    Route::post('v1/indent-supplier-items',  [HOSPurchaseOrder::class, 'indentItems'])->name('v1.indent_supplier_items');
    Route::post('v1/search_pr_item',  [HOSPurchaseOrder::class, 'searchPrItem'])->name('v1.search_pr_item');
    Route::post('v1/populate-default-items', [HOSPurchaseOrder::class, 'populateDefaultItems'])->name('v1.populate-default-items');
    Route::post('v1/item-autocomplete-store-wise', [HOSUtilitiesController::class, 'itemAutocomplete'])->name('v1.item-autocomplete-store-wise');
    Route::post('v1/item-autocomplete-store-wise-gatepass', [HOSUtilitiesController::class, 'itemAutocompleteGatepass'])->name('v1.item-autocomplete-store-wise-gatepass');
    Route::post('v1/item-autocomplete-store-wise-stock', [HOSUtilitiesController::class, 'itemAutocompleteStockWise'])->name('v1.item-autocomplete-store-wise-stock');
    Route::post('v1/item-autocomplete-store-supplier-wise', [HOSUtilitiesController::class, 'itemAutocompleteStoreSupplier'])->name('v1.item-autocomplete-store-supplier-wise');
    Route::post('v1/item-autocomplete-store-supplier-wise-cafe', [HOSUtilitiesController::class, 'itemAutocompleteStoreSupplierCafe'])->name('v1.item-autocomplete-store-supplier-wise-cafe');
    Route::post('v1/item-autocomplete-store-add-out', [HOSUtilitiesController::class, 'itemAutocompleteStoreAddOut'])->name('v1.item-autocomplete-store-add-out');
    Route::post('v1/item-autocomplete-store-store-to-store', [HOSUtilitiesController::class, 'itemAutocompleteStoreToStore'])->name('v1.item-autocomplete-store-store-to-store');
    Route::post('v1/item-autocomplete-sub-store-supplier-wise', [HOSUtilitiesController::class, 'itemAutocompleteSubStoreSupplier'])->name('v1.item-autocomplete-sub-store-supplier-wise');
    Route::post('v1/all-item-autocomplete-store-supplier-wise', [HOSUtilitiesController::class, 'swhowAllitemAutocomplete'])->name('v1.all-item-autocomplete-store-supplier-wise');
    Route::post('v1/generic-wise-item-list', [HOSUtilitiesController::class, 'genericWiseItemList'])->name('v1.generic-wise-item-list');
    Route::get('v1-purchase-order-finalize', [HOSPurchaseOrder::class, 'item_finalize_po_worklist'])->name('v1.purchase-order-finalize');
    Route::get('v1-purchase-order-issue', [HOSPurchaseOrder::class, 'item_issue_po_worklist'])->name('v1.purchase-order-issue');
    Route::post("v1/search_po_worklist", [HOSPurchaseOrder::class, 'searchPOWorklist'])->name('v1.search_po_worklist');
    Route::get('v1/purchase-order-print/{purchase_order_id}',  [HOSPurchaseOrder::class, 'purchaseOrderPrint'])->name('v1.purchase-order-print');
    Route::get('v1/purchase-order-print-with-md/{purchase_order_id}',  [HOSPurchaseOrder::class, 'purchaseOrderPrintWithMD'])->name('v1.purchase-order-print-with-md');
    Route::get('v2/purchase-order-print-with-md/{purchase_order_id}',  [HOSPurchaseOrder::class, 'purchaseOrderPrintWithMDV2'])->name('v2.purchase-order-print-with-md');
    Route::post('v1/po-issue-finalize', [HOSPurchaseOrder::class, 'poIssueFinalize'])->name('v1.po-issue-finalize');
    Route::post("v1/po-delete",  [HOSPurchaseOrder::class, "deletePO"])->name('v1.po-delete');
    Route::resource('v1-purchase-order', HOSPurchaseOrder::class);
    Route::get('v1/pr-po-post-items',  [HOSPurchaseOrder::class, 'prPoPostItem'])->name('v1.pr-po-post-items');
    Route::get('v1/pr-before-po-post-items',  [HOSPurchaseOrder::class, 'prBeforePoPostItem'])->name('v1.pr-before-po-post-items');
    Route::post('v1/search-pr-po-post-items',  [HOSPurchaseOrder::class, 'searchPrPoPostItem'])->name('v1.search-pr-po-post-items');
    Route::post('v1/search-pr-before-po-post-items',  [HOSPurchaseOrder::class, 'searchPrBeforePoPostItem'])->name('v1.search-pr-before-po-post-items');

    Route::post('v1/po-worklist-print', [HOSPurchaseOrder::class, 'POWorklistPrint'])->name('v1.po-worklist-print');
    Route::post('v1/po-worklist-excel', [HOSPurchaseOrder::class, 'POWorklistExcel'])->name('v1.po-worklist-excel');

    // Purchase Order v2

    Route::get('v2/inventory/create-purchase-order', [HOSPurchaseOrder::class,'purchaseOrderV2'])->name('v2.inventory.create-purchase-order');
    Route::get('v2/inventory/get-terms-conditions', [HOSPurchaseOrder::class,'getTermsConditions'])->name('v1.inventory.get-terms-conditions');
    Route::post('v2/inventory/save-purchase-order', [HOSPurchaseOrder::class,'savePurchaseOrderv2'])->name('v2.inventory.save-purchase-order');
    Route::post('v2/inventory/edit-purchase-order', [HOSPurchaseOrder::class,'editPurchaseOrderv2'])->name('v2.inventory.edit-purchase-order');
    Route::post('v2/inventory/get-pr-list', [HOSPurchaseOrder::class,'getPRv2'])->name('v2.inventory.get-pr-list');
    Route::post('v2/inventory/get-default-po-list', [HOSPurchaseOrder::class,'getDefaultPOv2'])->name('v2.inventory.get-default-po-list');

    Route::get('v2/inventory/create-purchase-order-v2', [HOSPurchaseOrder::class,'purchaseOrderNewV2'])->name('v2.inventory.create-purchase-order-v2');


    Route::post('v2/inventory/get-last-po-list', [HOSPurchaseOrder::class,'getLastPOV2'])->name('v2.inventory.get-last-po-list');
    Route::post('v2/inventory/get-last-po-item', [HOSPurchaseOrder::class,'getLastPOItemV2'])->name('v2.inventory.get-last-po-item');

    Route::get('v2/inventory/get-po-list', [HOSPurchaseOrder::class,'getPOListV2'])->name('v2.inventory.get-po-list');
    Route::post('v2/inventory/search-po-worklist', [HOSPurchaseOrder::class,'searchPOWorklistV2'])->name('v2.inventory.search-po-work-list');
    Route::get('v2/purchase-order-edit/{id}', [HOSPurchaseOrder::class,'editPOV2'])->name('v2.purchase-order-edit');
    Route::get('v2/purchase-order-review-edit/{id}', [HOSPurchaseOrder::class,'editPOV2'])->name('v2.purchase-order-review-edit');

    Route::post('v2/inventory/search-review-po-worklist', [HOSPurchaseOrder::class,'searchReviewPOWorklistV2'])->name('v2.inventory.search-review-po-work-list');


    Route::get('v2/inventory/get-review-po-list', [HOSPurchaseOrder::class,'getReviewPOListV2'])->name('v2.inventory.get-review-po-list');

    Route::get('v2/inventory/get-supplier-information/{id}',  [HOSPurchaseOrder::class, 'getSupplierInfoV2'])->name('v2.inventory.get-supplier-information');
    Route::get('v2/inventory/ready-to-post/{id}',  [HOSPurchaseOrder::class, 'poReadyPOST'])->name('v2.inventory.ready-to-post');
    Route::get('v2/purchase-order-print/{purchase_order_id}/{showWithHeader?}',  [HOSPurchaseOrder::class, 'purchaseOrderPrintV2'])->name('v2.purchase-order-print');
    Route::post('v2/purchase-order-send-with-header',  [HOSPurchaseOrder::class, 'purchaseOrderPrintV2WithHeader'])->name('v2.purchase-order-send-with-header');
    // Route::get('v1/purchase-order-print-with-md/{purchase_order_id}',  [HOSPurchaseOrder::class, 'purchaseOrderPrintWithMD'])->name('v1.purchase-order-print-with-md');

    // GRN V2
    Route::get('v2/item-receive-grn', [HOSGrnController::class, 'indexV2'])->name('v2.item-receive-grn');
    Route::post('v2/inventory/save-grn', [HOSGrnController::class,'saveGRNOrderv2'])->name('v2.inventory.save-grn');
    Route::post('v2/search-pr-list-for-popup', [HOSGrnController::class, 'searchPRListforPopupV2'])->name('v2.search-pr-list-for-popup');
    Route::post('v2/pr-info-for-grn', [HOSGrnController::class, 'pr_infoV2'])->name('v2.pr-info-for-grn');
    Route::post('v2/inventory/search-po-worklist-grn', [HOSGrnController::class,'searchPOWorklistGRNV3'])->name('v2.inventory.search-po-work-list-grn');
    Route::post('v2/inventory/search-po-worklist-pending', [HOSGrnController::class,'searchPOWorklistPending'])->name('v2.inventory.search-po-work-list-pending');
    Route::post('v2/po-info-for-grn', [HOSGrnController::class, 'po_infoV2'])->name('v2.po-info-for-grn');
    Route::post("v2/grn-work-list-search", [HOSGrnController::class, 'getSearchGRNWorkListV2'])->name('v2.search-grn-worklist');
    Route::post("grn-work-list-pdf", [HOSGrnController::class, 'getGRNWorkListPDF'])->name('getGRNWorkListPDF');
    Route::get('v2/inventory-grn-worklist', [HOSGrnController::class, 'grnWorklistV1'])->name('v2.inventory-grn-worklist');
    Route::post('v2/delete-grn-before-post', [HOSGrnController::class, 'deleteGrn'])->name('v2.delete-grn-before-post');
    Route::post('v2/delete-indent-before-approval', [HOSGrnController::class, 'deleteIndnet'])->name('v2.delete-indent-before-approval');
    Route::post('v2/inventory/update-grn', [HOSGrnController::class,'updateGRNOrderv2'])->name('v2.inventory.update-grn');

    Route::get('v2/pending-po-list', [HOSGrnController::class, 'pendingPoList'])->name('v2.pending-po-list');

    Route::get('v2/grn-report-print/{id?}', [HOSGrnController::class, 'grnReportPrintV2'])->name('v2.grn-report-print');
    Route::get('v2/item-receive-grn-fromGrnList/{grn_id?}', [HOSGrnController::class, 'grnPOSTV2'])->name('v2.item-receive-grn-fromGrnList');
    Route::post('v2/item-last-batch', [HOSGrnController::class, 'getLastBatch'])->name('v2.ipd.item-last-batch');
    Route::get('v2/inventory/get-bill-tracking-information', [HOSPurchaseOrder::class,'getBillTracking'])->name('v2.inventory.get-bill-tracking-information');


    //End

    //Approval matrix start
    Route::get('v1/approval-matrix-list', [HOSApprovalMatrixController::class, 'index'])->name('v1.approval.matrix.list');
    Route::get('v1/create-approval-matrix', [HOSApprovalMatrixController::class, 'create'])->name('v1.approval.matrix.create');
    Route::post('v1/store-approval-matrix', [HOSApprovalMatrixController::class, 'store'])->name('v1.approval.matrix.store');
    Route::post('v1/update-approval-matrix', [HOSApprovalMatrixController::class, 'update'])->name('v1.approval.matrix.update');
    Route::get('v1/edit-approval-matrix/{id}',  [HOSApprovalMatrixController::class, 'edit'])->name('v1.approval.matrix.edit');
    Route::post('v1/change-approval-matrix',  [HOSApprovalMatrixController::class, 'changeApproval'])->name('v1.change-approval-matrix');
    Route::get('v1/my-approval', [HOSApprovalMatrixController::class, 'myApproval'])->name('v1.my-approval');
    Route::get('v1/edit-my-approval-status/{id}/{status?}', [HOSApprovalMatrixController::class, 'myApprovalStatus'])->name('v1.edit.my.approval.status');
    Route::get('v1/reject-my-approval-status/{id?}/{code?}/{status?}/', [HOSApprovalMatrixController::class, 'myApprovalStatusReject'])->name('v1.reject.my.approval.status');
    Route::get('v1/hold-my-approval-status/{id}/{status?}', [HOSApprovalMatrixController::class, 'myApprovalStatusHold'])->name('v1.hold.my.approval.status');
    Route::get('v1/unhold-my-approval-status/{id}', [HOSApprovalMatrixController::class, 'myApprovalStatusUnhold'])->name('v1.unHold.my.approval.status');


    Route::get('v1/hr-edit-my-approval-status/{id}/{status?}', [HOSApprovalMatrixController::class, 'hrMyApprovalStatus'])->name('v1.hr.edit.my.approval.status');
    Route::get('v1/hr-reject-my-approval-status/{id?}/{code?}/{status?}/', [HOSApprovalMatrixController::class, 'hrMyApprovalStatusReject'])->name('v1.hr.reject.my.approval.status');
    Route::get('v1/hr-hold-my-approval-status/{id}/{status?}', [HOSApprovalMatrixController::class, 'hrMyApprovalStatusHold'])->name('v1.hr.hold.my.approval.status');
    Route::get('v1/hr-unhold-my-approval-status/{id}', [HOSApprovalMatrixController::class, 'hrMyApprovalStatusUnhold'])->name('v1.hr.unHold.my.approval.status');



    Route::post('v1/update-my-approval-status', [HOSApprovalMatrixController::class, 'updateStatus'])->name('v1.update.my.approval.status');
    Route::post('v1/update-my-approval-status/unhold', [HOSApprovalMatrixController::class, 'updateStatusUnHold'])->name('v1.update.my.approval.status.unhold');
    Route::get('v1/my-approval-level-detail/{id}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetail'])->name('v1.my.approval.level.detail');
    Route::get('v1/my-approval-level-detail-hr/{id}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetailHr'])->name('v1.my.approval.level.detail.hr');
    Route::get('v1/my-approval-level-detail-pr-list/{id}/{type?}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetailPrList'])->name('v1.my.approval.level.detail-pr-list');
    Route::post('v1/my-approval-search', [HOSApprovalMatrixController::class, 'myApprovalsearch'])->name('v1.my.approval.search');

    //Approval matrix department start
    Route::get('v1/approval-matrix-list-department', [HOSApprovalMatrixController::class, 'index_department'])->name('v1.approval-matrix-list-department');
    Route::get('v1/create-approval-matrix-department', [HOSApprovalMatrixController::class, 'createDepartment'])->name('v1.create-approval-matrix-department');
    Route::post('v1/store-approval-matrix-department', [HOSApprovalMatrixController::class, 'store_department'])->name('v1.store-approval-matrix-department');
    Route::post('v1/update-approval-matrix-department', [HOSApprovalMatrixController::class, 'update_department'])->name('v1.update-approval-matrix-department');
    Route::get('v1/edit-approval-matrix-department/{id}',  [HOSApprovalMatrixController::class, 'edit_department'])->name('v1.edit-approval-matrix-department');

    // Route::get('uhl/appointment-edit/{appoint_no_fk}', [HOSPatientAppointmentController::class, 'edit'])->name('uhl.appointment-edit');
    // Route::post('uhl/appointment-update', [HOSPatientAppointmentController::class, 'update'])->name('uhl.appointment-update');
    // Route::post('uhl/get-appointment-details-info', [HOSPatientAppointmentController::class, 'getDoctorsListBySpeclDate'])->name('uhl.get-appointment-details-info');
    // Route::get('uhl/appointment-details/{schedule_no_fk?}', [HOSPatientAppointmentController::class, 'appointmentDetails'])->name('uhl.appointment-details');
    // Route::post('uhl/store-appointment', [HOSPatientAppointmentController::class, 'store'])->name('uhl.store-appointment');

    //Approval matrix end

    //Department Indent v1.get-event-list
    Route::post('v1/get-event-list', [HOSUtilitiesController::class, 'getEventList'])->name('v1.get-event-list');
    Route::get('v1/department-indent-print/{id}', [HOSDepartmentIndentController::class, 'departmentIndentPrint'])->name('v1.department-indent-print');
    Route::get('v1/department-received-print/{id}', [HOSDepartmentIndentController::class, 'departmentReceivedPrint'])->name('v1.department-received-print');
    Route::get('v1/department-issue-indent-print/{id}', [HOSDepartmentIndentController::class, 'departmentIssueIndentPrint'])->name('v1.department-issue-indent-print');
    Route::get('v1/department-partial-issued-indent-print/{id}', [HOSDepartmentIndentController::class, 'departmentPartialIssuedPrint'])->name('v1.department-partial-issued-indent-print');
    Route::get('v1/department-issued-indent-print/{id}', [HOSDepartmentIndentController::class, 'departmentIssuedPrint'])->name('v1.department-issued-indent-print');
    Route::post('v1/search-department-indent', [HOSDepartmentIndentController::class, 'searchDepartmentIndent'])->name('v1.search-department-indent');
    Route::post('v1/search-uniform-issue-list', [HOSDepartmentIndentController::class, 'searchUniformIssueList'])->name('v1.search-uniform-issue-list');
    Route::get('v1/post-department-indent', [HOSDepartmentIndentController::class, 'postDepartmentIndent'])->name('v1.post-department-indent');
    Route::resource('v1-department-indent', HOSDepartmentIndentController::class);
    Route::post('v1.minor-group-list', [HOSDepartmentIndentController::class, 'minorGroupList'])->name('v1.minor-group-list');
    Route::get('create-indent-v2', [HOSDepartmentIndentController::class, 'create_indent_v2'])->name('create-indent-v2');
    Route::get('v1-department-indent-edit/{id}', [HOSDepartmentIndentController::class, 'editFromApproval'])->name('v1.department-indent-edit');
    Route::get('v1/indent-pr-list', [HOSItemIssueController::class, 'indent_pr_list'])->name('v1.indent-pr-list');

    Route::get('v1/department-indent-list-view/{id}', [HOSDepartmentIndentController::class, 'departmentIndentListView'])->name('v1.department-indent-list-view');
    //end

    //Item Issue
    Route::post('v1/get-item-wise-batch', [HOSUtilitiesController::class, 'getItemWiseBatch'])->name('v1.get-item-wise-batch');
    Route::post('v1/get-expire-date', [HOSItemIssueController::class, 'getExpireDate'])->name('v1.get-expire-date');
    Route::resource('v1-item-issue', HOSItemIssueController::class);
    Route::post('v1/indent-save-for-pr', [HOSItemIssueController::class, 'save_for_pr'])->name('v1.indent-save-for-pr');
    Route::get('v1/requested-pr-item', [HOSItemIssueController::class, 'pr_requested_indent_item'])->name('v1.requested-pr-item');
    Route::post('v1/search-requested-pr-item', [HOSItemIssueController::class, 'search_pr_requested_indent_item'])->name('v1.search-requested-pr-item');
    Route::post('v1/save-pr', [HOSItemIssueController::class, 'store_requested_pr_item_to_pr'])->name('v1.save-pr');
    //end
    //Item Receive

    Route::resource('v1-item-receive', HOSItemReceiveController::class);
    Route::get('v1/indent-item-status', [HOSItemReceiveController::class, 'indnetItemStatus'])->name('v1.indent-item-status');
    Route::post('v1/indent-item-status-search', [HOSItemReceiveController::class, 'indnetItemStatusSearch'])->name('v1.indent-item-status-search');
    Route::post('v1/indent-to-grn-report-download', [HOSItemReceiveController::class, 'indentToGrnDownload'])->name('v1.indent-to-grn-report-download');

    //end

    //Item Receive

    Route::resource('v1-department-consumption', HOSDepartmentConsumption::class);
    Route::get('v1-consumption_batch_no/{batch?}', [HOSDepartmentConsumption::class, 'consumption_batch_no'])->name('v1.consumption_batch_no');
    Route::get('v1/consumption_batch_no_issue/{batch?}', [HOSDepartmentConsumption::class, 'consumption_batch_no_issue'])->name('v1.consumption_batch_no_issue');
    Route::post('v1/get-sub-main-store', [HOSDepartmentConsumption::class, 'getSubMainStore'])->name('v1.get-sub-main-store');
    //end

    Route::get('v1/department-indent-worklist', function () {
        return Template::loadView("admin.uhl.inventory.department-indent-worklist");
    })->name('v1.department-indent-worklist');

    Route::get('v1/item-issues-worklist', [HOSItemIssueController::class, 'index'])->name('v1.item-issues-worklist');
    Route::get('v1/pr-worklist', [HOSItemIssueController::class, 'prWorkList'])->name('v1.pr-worklist');
    Route::get('v1/pr-worklist-phr', [HOSItemIssueController::class, 'prWorkListPhr'])->name('v1.pr-worklist-phr');

    Route::get('v1/pending-pr-item-worklist', [HOSItemIssueController::class, 'pendingPRItemWorkList'])->name('v1.pending-pr-item-worklist');
    Route::post('v1/search-pending-pr-item-list', [HOSItemIssueController::class, 'searchPendingPRItemWorkList'])->name('v1.search-pending-pr-item-list');

    Route::get('v1/pr-assign-worklist', [HOSItemIssueController::class, 'prAssignWorkList'])->name('v1.pr-assign-worklist');
    Route::get('v1/pr-assign-department-worklist', [HOSItemIssueController::class, 'prAssignDepartmentWorkList'])->name('v1.pr-assign-department-worklist');
    Route::get('v1/only-item-issues-worklist', [HOSItemIssueController::class, 'only_issue_work_list'])->name('v1.only_item_issues_worklist');
    Route::post('v1/only-item-partial-issued', [HOSItemIssueController::class, 'only_partial_issued_work_list'])->name('v1.only_partial_item_issued_worklist');
    Route::post('v1/search-indent-issue-list', [HOSItemIssueController::class, 'search_issue_indent_list'])->name('v1.search-indent-issue-list');
    Route::post('v1/search-pr-list', [HOSItemIssueController::class, 'search_pr_list'])->name('v1.search-pr-list');
    Route::post('v1/pr-worklist-print', [HOSItemIssueController::class, 'PRWorklistPrint'])->name('v1.pr-worklist-print');

    Route::post('v1/pending-pr-item-worklist-print', [HOSItemIssueController::class, 'pendingPRItemWorklistPrint'])->name('v1.pending-pr-item-worklist-print');
    Route::post('v1/pending-pr-item-worklist-excel', [HOSItemIssueController::class, 'pendingPRItemWorklistExcel'])->name('v1.pending-pr-item-worklist-excel');

    Route::post('v1/pr-worklist-excel', [HOSItemIssueController::class, 'PRWorklistExcel'])->name('v1.pr-worklist-excel');
    Route::post('v1/search-assign-pr-list', [HOSItemIssueController::class, 'search_assign_pr_list'])->name('v1.search-assign-pr-list');
    Route::post('v1/search-assign-department-pr-list', [HOSItemIssueController::class, 'search_assign_department_pr_list'])->name('v1.search-assign-department-pr-list');
    Route::post('v1/assign-pr-list-pdf', [HOSItemIssueController::class, 'assign_pr_list_pdf'])->name('v1.assign-pr-list-pdf');
    Route::post('v1/clear-assign', [HOSItemIssueController::class, 'assign_assign'])->name('v1.clear-assign');
    Route::get('v1/pr-print/{id?}', [HOSItemIssueController::class, 'prPrint'])->name('v1.pr-print');
    Route::get('v1/pr-print-imperial/{id?}', [HOSItemIssueController::class, 'prPrintImperial'])->name('v1.pr-print-imperial');
    Route::get('v1/pr-excel/{id?}', [HOSItemIssueController::class, 'prExcel'])->name('v1.pr-excel');
    Route::get('v1/pr_view_popup/{id?}', [HOSItemIssueController::class, 'prViewPopup'])->name('v1.pr_view_popup');
    Route::get('v1/pr_currency_change/{id?}', [HOSItemIssueController::class, 'prCurrencyChange'])->name('v1.pr_currency_change');
    Route::post('update-pr-currency', [HOSItemIssueController::class, 'updatePrCurrency'])->name('update-pr-currency');
    Route::get('v1/item-issued-worklist', [HOSItemIssueController::class, 'indent_issued_worklist'])->name('v1.item-issued-worklist');
    Route::get('v1/item-pending-issue-worklist', [HOSItemIssueController::class, 'pending_issue_worklist'])->name('v1.item-pending-issue-worklist');
    Route::get('v1/item-issue-pending-list', [HOSItemIssueController::class, 'issue_pending_list'])->name('v1.item-issue-pending-list');
    Route::get('v1/indent-receive-worklist', [HOSItemIssueController::class, 'indent_receive_worklist'])->name('v1.indent-receive-worklist');
    Route::get('v1/indent-receive-worklist-all-dept', [HOSItemIssueController::class, 'indent_receive_worklistAll'])->name('v1.indent-receive-worklist-all-dept');
    Route::get('v1/receive-pending-worklist', [HOSItemIssueController::class, 'receive_pending_worklist'])->name('v1.receive-pending-worklist');
    Route::get('v1/indent-received-worklist', [HOSItemIssueController::class, 'indent_received_worklist'])->name('v1.indent-received-worklist');
    Route::get('v1/search-indent-receive-worklist', [HOSItemIssueController::class, 'search_indent_receive_worklist'])->name('v1.search-indent-receive-worklist');
    Route::get('v1/only-item-issued-worklist', [HOSItemIssueController::class, 'only_indent_issued_worklist'])->name('v1.only-item-issued-worklist');
    Route::get('v1/only-item-partial-issued-worklist', [HOSItemIssueController::class, 'only_indent_partial_issued_worklist'])->name('v1.only-item-partial-issued-worklist');
    Route::post('v1/search-indent-issued-list', [HOSItemIssueController::class, 'search_issued_indent_list'])->name('v1.search-indent-issued-list');
    Route::post('v1/search-indent-issued-list-all-dept', [HOSItemIssueController::class, 'search_issued_indent_list_all_dept'])->name('v1.search-indent-issued-list-all-dept');
    Route::post('v1/print-indent-issued-list-all-dept', [HOSItemIssueController::class, 'print_issued_indent_list_all_dept'])->name('v1.print-indent-issued-list-all-dept');
    Route::post('v1/search-pending-issued-list', [HOSItemIssueController::class, 'search_pending_issue_indent_list'])->name('v1.search-pending-issued-list');
    Route::post('v1/search-issued-pending-list', [HOSItemIssueController::class, 'search_issue_pending_indent_list'])->name('v1.search-issued-pending-list');
    Route::post('pending-issue-item-pdf', [HOSItemIssueController::class, 'pending_issue_item_pdf'])->name('pending-issue-item-pdf');
    Route::post('pending-issue-item-excel', [HOSItemIssueController::class, 'pending_issue_item_excel'])->name('pending-issue-item-excel');
    // Department wise indent receive
    Route::get('v1/department-wise-indent-receive-worklist', [HOSItemIssueController::class, 'department_wise_indent_receive_worklist'])->name('v1.department-wise-indent-receive-worklist');
    Route::post('v1/department-wise-indent', [HOSItemIssueController::class, 'department_wise_indent'])->name('v1.department-wise-indent');




    // receive indent all
    Route::get('v1/indent-receive-worklist-all', [HOSItemIssueController::class, 'indent_receive_worklist_all'])->name('v1.indent-receive-worklist-all');
    Route::get('v1/search-indent-receive-worklist-all', [HOSItemIssueController::class, 'search_indent_receive_worklist_all'])->name('v1.search-indent-receive-worklist-all');
    Route::get('v1/indent-received-worklist-all', [HOSItemIssueController::class, 'indent_received_worklist_all'])->name('v1.indent-received-worklist-all');
    //cosumption
    Route::get('v1/consumption-worklist', [HOSItemIssueController::class, 'consumptionWorkList'])->name('v1.consumption-worklist');
    Route::post('v1/search-consumption-list', [HOSItemIssueController::class, 'search_consumption_list'])->name('v1.search-consumption-list');
    Route::get('v1/consumption-print/{id}', [HOSItemIssueController::class, 'consumptionPrint'])->name('v1.consumption-print');

    //cosumption report item wise
    Route::get('v1/consumption-worklist-item-wise', [HOSItemIssueController::class, 'consumptionWorkListItemWise'])->name('v1.consumption-worklist-item-wise');
    Route::post('v1/search-consumption-list-item-wise', [HOSItemIssueController::class, 'search_consumption_list_item_wise'])->name('v1.search-consumption-list-item-wise');
    Route::post('v1/consumption-print-item-wise', [HOSItemIssueController::class, 'consumptionPrintItemWise'])->name('v1.consumption-print-item-wise');

    //GRN WORKLIST and Print
    Route::get('v1/inventory-grn-worklist', [HOSGrnController::class, 'grnWorklist'])->name('v1.inventory-grn-worklist');
    Route::post("v1/grn-work-list-search", [HOSGrnController::class, 'search_grn_worklist'])->name('v1.search-grn-worklist');

    Route::get('v1/grn-report-print/{id}', [HOSGrnController::class, 'grnReportPrint'])->name('v1.grn-report-print');
    //end
    Route::post("v1/provider-autocomplete", [HOSBillingController::class, 'provider_autocomplete'])->name('v1.provider-autocomplete');
    Route::post("v1/get-store-terms-condition", [HOSPurchaseOrder::class, 'getTermsCondition'])->name('v1.get-store-terms-condition');
    Route::get("v1/all-po-terms-condition", [HOSPurchaseOrder::class, 'get_all_terms_condition'])->name('v1.all-po-terms-condition');
    Route::post("v1/default-po-terms-condition", [HOSPurchaseOrder::class, 'get_default_terms_condition'])->name('v1.default-po-terms-condition');

    Route::get('v1/item-issue', function () {
        return Template::loadView("admin.uhl.inventory.item-issue");
    })->name('v1.item-issue');

    Route::get('v1/item-received', function () {
        return Template::loadView("admin.uhl.inventory.item-received");
    })->name('v1.item-received');

    Route::get('v1/rate-managment', function () {
        return Template::loadView("admin.uhl.rate-managment");
    })->name('v1.rate-managment');

    Route::get('v1/pou-up', function () {
        return Template::loadView("admin.uhl.pou-up");
    })->name('v1.pou-up');

    Route::get('v1/pou-up', function () {
        return Template::loadView("admin.uhl.pou-up");
    })->name('v1.pou-up');

    Route::get('v1/house-keeping-schedule', function () {
        return Template::loadView("admin.uhl.house_keeping.house-keeping-schedule");
    })->name('v1.house-keeping-schedule');

    Route::get('v1/house-keeping-schedule-exectued', function () {
        return Template::loadView("admin.uhl.house_keeping.house-keeping-schedule-exectued");
    })->name('v1.house-keeping-schedule-exectued');

    Route::get('v1/bed-maintance', function () {
        return Template::loadView("admin.uhl.house_keeping.bed-maintance");
    })->name('v1.bed-maintance');

    // Route::get('v1/asset-register', function () {
    //     return Template::loadView("admin.uhl.fixed_assets.asset-register");
    // })->name('v1.asset-register');

    // Route::get('v1/asset-transfer', function () {
    //     return Template::loadView("admin.uhl.fixed_assets.asset-transfer");
    // })->name('v1.asset-transfer');


    // PR Assign Version 2
    Route::get('v2/pr-assign', [HOSItemIssueController::class, 'prAssign'])->name('v2.pr-assign');
    Route::post('v2/search-pr-list', [HOSItemIssueController::class, 'searchPRList'])->name('v2.search-pr-list');
    Route::post('v2/assign-pr-employee', [HOSItemIssueController::class, 'assignPR'])->name('v2.assign-pr-employee');
    Route::get('v2/assigned-pr-pdf/{id}', [HOSItemIssueController::class, 'assignedPRPDF'])->name('v2.assigned-pr-pdf');

    Route::post('v2/show-pr-assign-status', [HOSItemIssueController::class, 'showPRStatus'])->name('v2.show-pr-assign-status');
    Route::get('v2/partial-pr-status/{id}', [HOSItemIssueController::class, 'partialPRStatus'])->name('v2.partial-pr-status');

    Route::post('v2/pr-status-excel', [HOSItemIssueController::class, 'downloadPRStatusExcelV2'])->name('v2.pr-status-excel');
    Route::post('v2/pr-status-pdf', [HOSItemIssueController::class, 'downloadPRStatusPdfV2'])->name('v2.pr-status-pdf');




    // Partial PR Assign
    Route::get('v2/partial-pr-assign/{id?}', [HOSItemIssueController::class, 'partialAssignPR'])->name('v2.partial-pr-assign');
    Route::post('v2/assign-partial-pr-employee', [HOSItemIssueController::class, 'assignPartialPR'])->name('v2.assign-partial-pr-employee');
    // Revoked PR
    Route::get('v2/revoke-pr-assign/{id?}', [HOSItemIssueController::class, 'revokeAssignPR'])->name('v2.revoke-pr-assign');
    Route::post('v2/revoked-partial-pr-employee', [HOSItemIssueController::class, 'revokedPartialPR'])->name('v2.revoked-partial-pr-employee');



    // Assigned PR List
    Route::get('v2/pr-assigned-list', [HOSItemIssueController::class, 'prAssignedList'])->name('v2.pr-assigned-list');
    Route::post('v2/search-assigned-pr-list', [HOSItemIssueController::class, 'searchAssignedPRList'])->name('v2.search-assigned-pr-list');
    // asset receive
    Route::get('v1/asset-received', [FixedAssetsController::class, 'assetsReceive'])->name('v1.asset-received');
    Route::post('v1/asset-received-search', [FixedAssetsController::class, 'assetsReceiveSearch'])->name('v1.asset-received-search');
    Route::get('v1/create_tag_popup/{id}', [FixedAssetsController::class, 'createTagPopup'])->name('v1.create_tag_popup');
    Route::post('v1/generate-tag', [FixedAssetsController::class, 'generateTag'])->name('v1.generate-tag');
    Route::post('v1/save-generate-tag', [FixedAssetsController::class, 'SaveGenerateTag'])->name('v1.save-generate-tag');
    Route::get('v1/print-generate-tag/{id}', [FixedAssetsController::class, 'printGenerateTag'])->name('v1.print-generate-tag');

    // Asset Register
    Route::get('v1/asset-register', [FixedAssetsController::class, 'assetsRegister'])->name('v1.asset-register');
    Route::post('v1/asset-register-search', [FixedAssetsController::class, 'assetsRegisterSearch'])->name('v1.asset-register-search');
    Route::get('v1/create_transfer_popup/{id}/{receivedtl_id?}', [FixedAssetsController::class, 'transferRequest'])->name('v1.create_transfer_popup');
    Route::get('v1/create_asset_details_popup/{id?}', [FixedAssetsController::class, 'assetDetails'])->name('v1.create_asset_details_popup');
    Route::post('v1/save_details', [FixedAssetsController::class, 'saveDetails'])->name('v1.save_details');
    Route::post('v1/save_transfer', [FixedAssetsController::class, 'saveTransfer'])->name('v1.save_transfer');
    Route::get('v1/asset_register_update_popup/{id?}', [FixedAssetsController::class, 'updatePopup'])->name('v1.asset_register_update_popup');
    Route::post('v1/asset_register_update', [FixedAssetsController::class, 'updateAssetRegister'])->name('v1.asset_register_update');
    Route::post('v1/building-floor-list', [FixedAssetsController::class, 'buildingFloorList'])->name('v1.building-floor-list');
    Route::post('v1/building-floor-list-edit', [FixedAssetsController::class, 'buildingFloorListEdit'])->name('v1.building-floor-list-edit');
    Route::post('v1/building-location-list', [FixedAssetsController::class, 'buildingLoctionList'])->name('v1.building-location-list');
    Route::post('v1/building-location-list-edit', [FixedAssetsController::class, 'buildingLoctionListEdit'])->name('v1.building-location-list-edit');
    Route::get('v1/print-equipment-detail/{id}', [FixedAssetsController::class, 'printEquipmentDetail'])->name('v1.print-equipment-detail');


    // asset transfer confermation
    Route::get('v1/asset-transfer', [FixedAssetsController::class, 'assetsTransferConform'])->name('v1.asset-transfer');
    Route::post('v1/asset-transfer-conform-search', [FixedAssetsController::class, 'assetsTransferConformSearch'])->name('v1.asset-transfer-conform-search');
    Route::post('v1/asset-transfer-conform-search-form', [FixedAssetsController::class, 'assetsTransferConformSearchform'])->name('v1/asset-transfer-conform-search-form');
    Route::post('v1/asset-transfer-conform-save', [FixedAssetsController::class, 'assetsTransferConformSave'])->name('v1.asset-transfer-conform-save');

    // asset class , category tax code setup
    Route::get('v1/asset-setup', [FixedAssetsController::class, 'assetsClass'])->name('v1.asset-setup');
    Route::post('v1/asset-class-save', [FixedAssetsController::class, 'assetsClassSave'])->name('v1.asset-class-save');
    Route::post('v1/asset-category-save', [FixedAssetsController::class, 'assetsCategorySave'])->name('v1.asset-category-save');
    Route::post('v1/asset-tax-save', [FixedAssetsController::class, 'assetsTaxSave'])->name('v1.asset-tax-save');
    Route::post('v1/asset-tab-change', [FixedAssetsController::class, 'assetsTabChange'])->name('v1.asset-tab-change');
    Route::get('v1/depreciation-calculation', [FixedAssetsController::class, 'depreciation'])->name('v1.depreciation-calculation');
    Route::post('v1/depreciation-calculation-search', [FixedAssetsController::class, 'depreciationSearch'])->name('v1.depreciation-calculation-search');
    Route::post('v1/depreciation-calculation-store', [FixedAssetsController::class, 'depreciationStore'])->name('v1.depreciation-calculation-store');


    //depreciation work list
    Route::get('v1/depreciation-work-list', [FixedAssetsController::class, 'depreciationWorkList'])->name('v1.depreciation-work-list');
    Route::post('v1/depreciation-work-list-search', [FixedAssetsController::class, 'depreciationWorkListSearch'])->name('v1.depreciation-work-list-search');

    Route::get('v1/depreciation-calculation-details/{code?}/{year_month?}', [FixedAssetsController::class, 'depreciationCalculationDetails'])->name('v1.depreciation-calculation-details');
    Route::post('v1/depreciation-pdf-excel', [FixedAssetsController::class, 'depreciationCalculationPdfExcel'])->name('v1.depreciation-pdf-excel');

    // Fixed Asset Depreciation
    Route::get('v2/depreciation-calculation', [FixedAssetsController::class, 'depreciationV2'])->name('v2.depreciation-calculation');
    Route::get('v2/depreciation-calculation-item', [FixedAssetsController::class, 'getDepreciationV2'])->name('v2.depreciation-calculation-item');
    Route::post('v2/depreciation-generate', [FixedAssetsController::class, 'generateDepreciationV2'])->name('v2.depreciation-generate');

    Route::get('v2/depreciation-worklist', [FixedAssetsController::class, 'depreciationWorklistV2'])->name('v2.depreciation-worklist');
    Route::get('v2/depreciation-calculation-worklist', [FixedAssetsController::class, 'getDepreciationWorklistV2'])->name('v2.depreciation-calculation-worklist');

    // Asset discard
    Route::get('v1/fix-asset-discard', [FixedAssetsDiscardController::class, 'FixedAssetsDiscard'])->name('v1.fix-asset-discard');
    Route::post('v1/fix-asset-discard-store', [FixedAssetsDiscardController::class, 'fixedAssetsDiscardStore'])->name('v1.fix-asset-discard-store');
    Route::get('v1/fix-asset-discard-worklist', [FixedAssetsDiscardController::class, 'fixedAssetsDiscardWorklist'])->name('v1.fix-asset-discard-worklist');
    Route::get('v1/fix-asset-discard-print/{discard_no_pk}', [FixedAssetsDiscardController::class, 'fixedAssetsDiscardItemPrint'])->name('v1.fix-asset-discard-print');

    Route::post('v1/discard-fixed-asset-search', [FixedAssetsDiscardController::class, 'searchDiscardFixedAsset'])->name('v1.discard-fixed-asset-search');

    Route::get('v1/search-tag-info', [FixedAssetsDiscardController::class, 'searchTagInfo'])->name('v1.search-tag-info');

    Route::get('v1/fixed-asset-register', [FixedAssetsController::class, 'fixedAssetRegFinc'])->name('v1.fixed-asset-register');
    Route::post('v1/fixed-asset-register-search', [FixedAssetsController::class, 'fixedAssetRegFincSearch'])->name('v1.fixed-asset-register-search');
    Route::post('v1/fixed-asset-register-print', [FixedAssetsController::class, 'fixedAssetRegFincPrint'])->name('v1.fixed-asset-register-print');
    //   Route::get('v1/fixed-asset-register', function () {
    //     return Template::loadView("admin.uhl.fixed_assets.fixed-asset-register");
    // })->name('v1.fixed-asset-register');
    Route::get('v1/fixed-asset-discard', function () {
        return Template::loadView("admin.uhl.fixed_assets.fixed-asset-discard");
    })->name('v1.fixed-asset-discard');

    // Route::get('v1/asset-setup', function () {
    //     return Template::loadView("admin.uhl.fixed_assets.asset-setup");
    // })->name('v1.asset-setup');

    Route::get('v1/ipd-patient-list/ipd', [IPDController::class, 'ipd_patient_list'])->name('v1.ipd-patient-list');
    Route::get('v1/ipd-patient-list/emergency', [IPDController::class, 'ipd_patient_list_emergency'])->name('v1.ipd-patient-list-emergency');
    Route::get('v1/ipd-patient-list/dailysis', [IPDController::class, 'ipd_patient_list_dailysis'])->name('v1.ipd-patient-list-dailysis');
    Route::get('v1/ipd-patient-list-2', [IPDController::class, 'ipd_patient_list_2'])->name('v1.ipd-patient-list-2');
    Route::get('v1/ipd-patient-list-emergency-2', [IPDController::class, 'ipd_patient_list_emergency_2'])->name('v1.ipd-patient-list-emergency-2');
    Route::get('v1/ipd-patient-list-dailysis-2', [IPDController::class, 'ipd_patient_list_dailysis_2'])->name('v1.ipd-patient-list-dailysis-2');
    Route::get('v1/ipd-patient-list-2', [IPDController::class, 'ipd_patient_list_2'])->name('v1.ipd-patient-list-2');
    Route::get('v1/ipd-dis-req-patient-list', [IPDController::class, 'ipd_dis_req_patient_list'])->name('v1.ipd-dis-req-patient-list');
    Route::get('v1/ipd-dis-patient-list', [IPDController::class, 'ipd_dis_patient_list'])->name('v1.ipd-dis-patient-list');


    // Route::get('v1/opening-balance-adjustment-entry', function () {
    //     return Template::loadView("admin.uhl.inventory.opening-balance-adjustment-entry");
    // })->name('v1.opening-balance-adjustment-entry');

    Route::get('v1/stock-in-out', [StoreController::class, 'cafeteriaStoreAdjustmentV1'])->name('v1.stock-in-out');
    Route::get('v1/stock-in-out-cafe', [StoreController::class, 'cafeteriaStoreAdjustmentV1'])->name('v1.stock-in-out-cafe')->defaults('type', 'CAFE');
    Route::get('ipd-meal-provide', [StoreController::class, 'ipdMealProvide'])->name('ipd-meal-provide');
    Route::get('v1/opening-balance-adjustment-entry', [StoreController::class, 'storeAdjustmentV1'])->name('v1.opening-balance-adjustment-entry');
    Route::post('v1/opening-balance-adjustment-entry-store', [StoreController::class, 'storeAdjustmentSaveV1'])->name('v1.opening-balance-adjustment-entry-store');
    Route::get('v1/opening-balance-adjustment-entry-list', [StoreController::class, 'storeAdjustmentListV1'])->name('v1.opening-balance-adjustment-entry-list');
    Route::post('v1/opening-balance-adjustment-entry-search', [StoreController::class, 'storeAdjustmentSearchV1'])->name('v1.opening-balance-adjustment-entry-search');
    Route::post('v1/opening-balance-adjustment-entry-pdf', [StoreController::class, 'storeAdjustmentPdfhV1'])->name('v1.opening-balance-adjustment-entry-pdf');

    //purchase return
    Route::get('v1/purchase-return', [StoreController::class, 'purchaseReturn'])->name('v1.purchase-return');
    Route::get('v1/purchase-return-report', [StoreController::class, 'purchaseReturnReport'])->name('v1.purchase-return-report');
    Route::post('v1/purchase-return-report-pdf', [StoreController::class, 'purchaseReturnReportPdf'])->name('v1.purchase-return-report-pdf');
    Route::post('v1/purchase-return-store', [StoreController::class, 'purchaseReturnStore'])->name('v1.purchase-return-store');

    //purchase return   Receive
    Route::get('v1/purchase-return-receive', [StoreController::class, 'purchaseReturnReceive'])->name('v1.purchase-return-receive');
    Route::post('v1/get-supplier-return-amount', [StoreController::class, 'getSupplierReturnAmt'])->name('v1.get-supplier-return-amount');
    // Route::get('v1/purchase-return-receive-report', [StoreController::class, 'purchaseReturnReportReceive'])->name('v1.purchase-return-receive-report');
    // Route::post('v1/purchase-return-report-pdf', [StoreController::class, 'purchaseReturnReportPdf'])->name('v1.purchase-return-report-pdf');
    Route::post('v1/purchase-return-receive-store', [StoreController::class, 'purchaseReturnReceiveStore'])->name('v1.purchase-return-receive-store');

    Route::get('v2/store-adjustment-main-sub', [StoreController::class, 'storeAdjustmentMainSubV2'])->name('v2.store-adjustment-main-sub');
    Route::post('v1/opening-balance-adjustment-entry-store-v2', [StoreController::class, 'storeAdjustmentSaveV2'])->name('v1.opening-balance-adjustment-entry-store-v2');    // return to main store
    Route::get('v1/return-to-main-store', [StoreController::class, 'returnToMainStore'])->name('v1.return-to-main-store');
    Route::post('v1/return-to-mainStore-store', [StoreController::class, 'returnToMainStoreSave'])->name('v1.return-to-mainStore-store');
    Route::get('v1/return-to-mainStore-list', [StoreController::class, 'returnToMainStoreListV1'])->name('v1.return-to-mainStore-list');
    Route::post('v1/return-to-mainStore-list-search', [StoreController::class, 'returnToMainStoreSearchV1'])->name('v1.return-to-mainStore-list-search');
    // Route::post('v1/opening-balance-adjustment-entry-pdf', [StoreController::class,'storeAdjustmentPdfhV1'])->name('v1.opening-balance-adjustment-entry-pdf');

    // expire date management
    Route::get('v1/expired-item', [StoreController::class, 'expiredItem'])->name('v1.expired-item');
    Route::post('v1/expired-item-search', [StoreController::class, 'expiredItemSearch'])->name('v1.expired-item-search');
    Route::get('v1/expired-date-popup/{id}', [StoreController::class, 'expiredDatePopup'])->name('v1.expired-date-popup');
    Route::get('v1/expired-item-out-popup/{id}/{qty?}/{batch?}/{exp_date?}/{p_price?}/{uom_no?}', [StoreController::class, 'expireItemOutPopup'])->name('v1.expired-item-out-popup');
    Route::post('v1/expired-item-out-update', [StoreController::class, 'expireItemOutUpdate'])->name('v1.expired-item-out-update');
    Route::post('v1/expired-date-update', [StoreController::class, 'expiredDateUpdate'])->name('v1.expired-date-update');
    Route::post('v1/expired-item-pdf', [StoreController::class, 'expiredItemPdf'])->name('v1.expired-item-pdf');

    // grn report
    Route::get('v1/grn-report-new', [StoreController::class, 'grnReportNew'])->name('v1.grn-report-new');
    Route::post('v1/grn-item-search', [StoreController::class, 'grnItemSearch'])->name('v1.grn-item-search');
    Route::post('v1/grn-item-pdf', [StoreController::class, 'grnItemPdf'])->name('v1.grn-item-pdf');

    // Item Issue report from main store

    Route::get('v1/item-issue-report-fms', [StoreController::class, 'itemIssueReportFMS'])->name('v1.item-issue-report-fms');
    Route::post('v1/search-item-issue-report-fms', [StoreController::class, 'searchItemIssueReportFMS'])->name('v1.search-item-issue-report-fms');
    Route::post('v1/item-issue-report-fms-pdf', [StoreController::class, 'searchItemIssueReportFMSPDF'])->name('v1.item-issue-report-fms-pdf');

    Route::get('v1/item-issue-report-fms-new', [StoreController::class, 'itemIssueReportFMSNew'])->name('v1.item-issue-report-fms-new');
    Route::post('v1/search-item-issue-report-fms-new', [StoreController::class, 'searchItemIssueReportFMSNew'])->name('v1.search-item-issue-report-fms-new');
    Route::post('v1/item-issue-report-fms-new-pdf', [StoreController::class, 'ItemIssueReportFMSPDFNew'])->name('v1.item-issue-report-fms-new-pdf');

    Route::get('v1/item-issue-print/{id}', [StoreController::class, 'itemIssuePrint'])->name('v1.issue-print-pdf');


    // Rqgular Item Stock Low
    Route::get('v1/regular-item-stock-low', [StoreController::class, 'regularItemStockLow'])->name('v1.regular-item-stock-low');
    Route::post('v1/regular-item-stock-low-search', [StoreController::class, 'regularItemStockLowSearch'])->name('v1.regular-item-stock-low-search');
    Route::post('v1/regular-item-stock-low-pdf', [StoreController::class, 'regularItemStockLowPdf'])->name('v1.regular-item-stock-low-pdf');


    //approval return substore to receive
    Route::get('v1/return-to-mainStore-approve-list', [StoreController::class, 'returnToMainStoreApproveListV1'])->name('v1.return-to-mainStore-approve-list');
    Route::post('v1/return-to-mainStore-approve-list-search', [StoreController::class, 'returnToMainStoreApproveSearchV1'])->name('v1.return-to-mainStore-approve-list-search');
    Route::post('v1/return-to-mainStore-approve-store', [StoreController::class, 'returnToMainStoreApproveSave'])->name('v1.return-to-mainStore-approve-store');

    Route::get('v1/gatepass-entry/{id?}', [HOSgetPassController::class, 'index'])->name('v1.gatepass-entry');
    Route::post('v1/gatepass-entry-store', [HOSgetPassController::class, 'store'])->name('v1.gatepass-entry-store');
    Route::get('v1/gatepass-worklist', [HOSgetPassController::class, 'gatePassWorkList'])->name('v1.gatepass-worklist');
    Route::get('v1/gatepass-worklist-security-incharge', [HOSgetPassController::class, 'gatePassWorkListSecurityIncharge'])->name('v1.gatepass-worklist-security-incharge');
    Route::post('v1/gatepass-draft-list-security-incharge', [HOSgetPassController::class, 'SearchGatePassWorkListDraftSIncharge'])->name('v1.gatepass-draft-list-security-incharge');
    Route::get('v1/gatepass-worklist-print-security-incharge/{id}', [HOSgetPassController::class, 'gatePassWorkListPrintSecurityIncharge'])->name('v1.gatepass-worklist-print-security-incharge');
    Route::post('v1/gatepass-draft-list', [HOSgetPassController::class, 'SearchGatePassWorkListDraft'])->name('v1.gatepass-draft-list');
    Route::post('v1/gatepass-post-list', [HOSgetPassController::class, 'SearchGatePassWorkListPost'])->name('v1.gatepass-post-list');
    Route::get('v1/gatepass-worklist-print/{id}', [HOSgetPassController::class, 'gatePassWorkListPrint'])->name('v1.gatepass-worklist-print');

    // Returnable
    Route::get('v1/returnable-gate-pass-worklist', [HOSgetPassController::class, 'returnablegatePassWorkList'])->name('v1.returnable-gate-pass-worklist');
    Route::post('v1/returnable-gate-pass-list', [HOSgetPassController::class, 'SearchGatePassWorkListReturnable'])->name('v1.returnable-gate-pass-list');
    Route::get('v1/returnable-gate-pass-edit/{id}', [HOSgetPassController::class, 'SearchGatePassWorkListReturnableEdit'])->name('v1.returnable-gate-pass-edit');
    Route::post('v1/returnable-gate-pass-receive', [HOSgetPassController::class, 'SearchGatePassWorkListReturnableReceive'])->name('v1.returnable-gate-pass-receive');
    Route::post('v1/download-return-receive-gate-pass', [HOSgetPassController::class, 'returnReceiveGatePassPdf'])->name('v1.accounts.download-return-receive-gate-pass');
    // Close Returnable

    Route::get('v1/all-gatepasses', [HOSgetPassController::class, 'allGatePasses'])->name('v1.all-gatepasses');
    Route::post('v1/search-gatepasses-list', [HOSgetPassController::class, 'SearchAllGatePasses'])->name('v1.search-gatepasses-list');
    Route::post('v1/update-isprinted/{id?}', [HOSgetPassController::class, 'updateGatepassPrintInd'])->name('v1.update-isprinted');


    Route::get('v1/direct-purchase-requisition', [HOSItemIssueController::class, 'direct_pr'])->name('v1.direct-purchase-requisition');
    Route::post('v1/get-reorder-lavel-item', [HOSItemIssueController::class, 'getReorderLavelItem'])->name('v1.get-reorder-lavel-item');
    Route::get('v1/direct-pr-edit/{id}/{app_status?}', [HOSItemIssueController::class, 'edit_direct_pr'])->name('v1.direct-pr-edit');

    //direct pr for pharmacy

    Route::get('v1/direct-purchase-requisition-phr', [HOSItemIssueController::class, 'direct_pr_phr'])->name('v1.direct-purchase-requisition-phr');
    // Route::post('v1/get-reorder-lavel-item-phr', [HOSItemIssueController::class, 'getReorderLavelItem'])->name('v1.get-reorder-lavel-item-phr');
    Route::post('v1/get-supplier-wise-item-phr', [HOSItemIssueController::class, 'getSupplierWiseItem'])->name('v1.get-supplier-wise-item-phr');
    Route::post('v1/get-minor-group-item-phr', [HOSItemIssueController::class, 'getMinorGroupItem'])->name('v1.get-minor-group-item-phr');
    //getSupplierWiseItem
    // Route::get('v1/direct-pr-edit-phr/{id}/{app_status?}', [HOSItemIssueController::class, 'edit_direct_pr'])->name('v1.direct-pr-edit-phr');

    Route::get('expense_memo', [ExpenseController::class, 'index'])->name('expense_memo');
    Route::post('expense_memo_save', [ExpenseController::class, 'store'])->name('expense_memo_save');
    Route::get('expense_memo_worklist', [ExpenseController::class, 'ExpenseMemoWorklist'])->name('expense_memo_worklist');
    Route::post('search_expense_memo', [ExpenseController::class, 'ExpenseMemoWorklistSearch'])->name('search_expense_memo');
    Route::get('expense_memo_update/{id?}', [ExpenseController::class, 'ExpenseMemoUpdate'])->name('expense_memo_update');
    Route::get('expense_memo_report/{id?}', [ExpenseController::class, 'ExpenseMemoReport'])->name('expense_memo_report');
    Route::get('approval-level-tracking-expense/{id?}', [ExpenseController::class, 'ApprovalTrackingforExpense'])->name('approval-level-tracking-expense');
    Route::get('expense_memo_worklist_finance', [ExpenseController::class, 'ExpenseMemoWorklistFinance'])->name('expense_memo_worklist_finance');
    Route::post('expense_memo_payment_update', [ExpenseController::class, 'PaymentUpdate'])->name('expense_memo_payment_update');
    Route::post('search_expense_memo_worklist', [ExpenseController::class, 'searchExpenseWorklist'])->name('search_expense_memo_worklist');
    Route::post('expense_memo_worklist_print', [ExpenseController::class, 'ExpenseWorklistFinancePrint'])->name('expense_memo_worklist_print');
    Route::post('expense_memo_worklist_excel', [ExpenseController::class, 'ExpenseWorklistFinanceExcel'])->name('expense_memo_worklist_excel');

    Route::get('v1/item-previlize', function () {
        return Template::loadView("admin.settings.item.user_wise_item_setup");
    })->name('v1.item-previlege');



    Route::get('v1/major-head-wise-report', function () {
        return Template::loadView("admin.uhl.major-head-wise-report");
    })->name('v1.major-head-wise-report');

    Route::get('v1/daily-income-statement', function () {
        return Template::loadView("admin.uhl.daily-income-statement");
    })->name('v1.daily-income-statement');

    Route::get('v1/doctor-wise-outdoor-summary', function () {
        return Template::loadView("admin.uhl.doctor-wise-outdoor-summary");
    })->name('v1.doctor-wise-outdoor-summary');

    Route::get('v1/store-stock-report', function () {
        return Template::loadView("admin.uhl.store-stock-report");
    })->name('v1.store-stock-report');

    Route::get('v1/store-stock-report-value', function () {
        return Template::loadView("admin.uhl.store-stock-report-value");
    })->name('v1.store-stock-report-value');

    Route::get('v1/item-ledger', function () {
        return Template::loadView("admin.uhl.item-ledger");
    })->name('v1.item-ledger');

    //  Route::get('v1/radiology-dashboard', function () {
    //     return Template::loadView("admin.uhl.radiology-dashboard");
    // })->name('v1.radiology-dashboard');

    //  Route::get('v1/pathology-dashboard', function () {
    //     return Template::loadView("admin.uhl.pathology-dashboard");
    // })->name('v1.pathology-dashboard');



    //    Route::get('v1/ipd-dashboard', function () {
    //       return Template::loadView("admin.uhl.ipd-dashboard");
    //   })->name('v1.ipd-dashboard');


    Route::get('v1/loan-request', function () {
    })->name('v1.loan-request');

    Route::get('v1/loan-installment-payment-and-closing', function () {
        //   return Template::loadView("admin.uhl.loan-installment-payment-and-closing");
    })->name('v1.loan-installment-payment-and-closing');

    Route::get('v1/loan-settlement', function () {
        return Template::loadView("admin.uhl.loan-settlement");
    })->name('v1.loan-settlement');

    Route::get('v1/loan-request-list', function () {
    })->name('v1.loan-request-list');


    Route::get('v1/monthly-loan-status', function () {
        return Template::loadView("admin.uhl.monthly-loan-status");
    })->name('v1.monthly-loan-status');


    Route::get('v1/employee-phonebook', function () {
        return Template::loadView("admin.uhl.employee-phonebook");
    })->name('v1.employee-phonebook');


    Route::get('v1/provident-fund-policy', function () {
        return Template::loadView("admin.uhl.provident-fund-policy");
    })->name('v1.provident-fund-policy');


    Route::get('v1/provident-fund-final-settlement', function () {
        return Template::loadView("admin.uhl.provident-fund-final-settlement");
    })->name('v1.provident-fund-final-settlement');

    Route::get('v1/monthly-office-wise-contribution-posting', function () {
        return Template::loadView("admin.uhl.monthly-office-wise-contribution-posting");
    })->name('v1.monthly-office-wise-contribution-posting');


    Route::get('v1/applicant-cv-entry', function () {
    })->name('v1.applicant-cv-entry');

    Route::get('v1/cv-list', function () {
        return Template::loadView("admin.uhl.cv-list");
    })->name('v1.cv-list');

    Route::get('v1/job-circulation', function () {
        return Template::loadView("admin.uhl.job-circulation");
    })->name('v1.job-circulation');


    Route::get('v1/job-circulation-work-list', function () {
        return Template::loadView("admin.uhl.job-circulation-work-list");
    })->name('v1.job-circulation-work-list');

    Route::get('v1/marking-criteria', function () {
        return Template::loadView("admin.uhl.marking-criteria");
    })->name('v1.marking-criteria');

    Route::get('v1/applicant-work-list', function () {
        return Template::loadView("admin.uhl.applicant-work-list");
    })->name('v1.applicant-work-list');

    Route::get('v1/comparative-statement', [ComparativeStatement::class, 'comparative_statement_v1'])->name('v1.comparative-statement');
    Route::get('v1/create-comparative-statement', [ComparativeStatement::class, 'comparative_statement_v1'])->name('v1.comparative-statement');

    Route::get('v1/manpower-requisition', function () {
        return Template::loadView("admin.uhl.manpower-requisition");
    })->name('v1.manpower-requisition');
    Route::get('v1/manpower-requisition-work-list', function () {
        return Template::loadView("admin.uhl.manpower-requisition-work-list");
    })->name('v1.manpower-requisition-work-list');

    Route::get('v1/hr-dashboard', function () {
        return Template::loadView("admin.uhl.hr-dashboard");
    })->name('v1.hr-dashboard');
    Route::get('v1/hr-planning-board', function () {
        return Template::loadView("admin.uhl.hr-planning-board");
    })->name('v1.hr-planning-board');
    Route::get('v1/skill-matrix', function () {
        return Template::loadView("admin.uhl.skill-matrix");
    })->name('v1.skill-matrix');

    Route::get('v1/my-duty', function () {
        return Template::loadView("admin.uhl.my-duty");
    })->name('v1.my-duty');
    Route::get('v1/location-wise-item-list', function () {
        return Template::loadView("admin.uhl.location-wise-item-list");
    })->name('v1.location-wise-item-list');
    Route::get('v1/duty-history', function () {
        return Template::loadView("admin.uhl.duty-history");
    })->name('v1.duty-history');
    Route::get('v1/attendence-history', function () {
        return Template::loadView("admin.uhl.attendence-history");
    })->name('v1.attendence-history');

    Route::get('v1/increment-policy', function () {
        return Template::loadView("admin.uhl.increment-policy");
    })->name('v1.increment-policy');
    Route::get('v1/due-increment-work-list', function () {
        return Template::loadView("admin.uhl.due-increment-work-list");
    })->name('v1.due-increment-work-list');
    Route::get('v1/increment-processing-work-list', function () {
        return Template::loadView("admin.uhl.increment-processing-work-list");
    })->name('v1.increment-processing-work-list');

    Route::get('v1/organogram', function () {
        return Template::loadView("admin.uhl.organogram");
    })->name('v1.organogram');

    Route::get('v1/promotion-by-duration', function () {
        return Template::loadView("admin.uhl.promotion-by-duration");
    })->name('v1.promotion-by-duration');
    Route::get('v1/due-promotion-work-list', function () {
        return Template::loadView("admin.uhl.due-promotion-work-list");
    })->name('v1.due-promotion-work-list');

    Route::get('v1/application-for-seperation', function () {
        return Template::loadView("admin.uhl.application-for-seperation");
    })->name('v1.application-for-seperation');
    Route::get('v1/employee-seperation', function () {
        return Template::loadView("admin.uhl.employee-seperation");
    })->name('v1.employee-seperation');

    Route::get('v1/hr-letter-templates', function () {
        return Template::loadView("admin.uhl.hr-letter-templates");
    })->name('v1.hr-letter-templates');
    Route::get('v1/prepare-letter', function () {
        return Template::loadView("admin.uhl.prepare-letter");
    })->name('v1.prepare-letter');
    Route::get('v1/employee-detail-information', function () {
        return Template::loadView("admin.uhl.employee-detail-information");
    })->name('v1.employee-detail-information');

    Route::get('v1/local-general-ledger', function () {
        return Template::loadView("admin.uhl.local-general-ledger");
    })->name('v1.local-general-ledger');

    Route::get('v1/sub-ledger-type', function () {
        return Template::loadView("admin.uhl.sub-ledger-type");
    })->name('v1.sub-ledger-type');
    Route::get('v1/sub-ledger-name', function () {
        return Template::loadView("admin.uhl.sub-ledger-name");
    })->name('v1.sub-ledger-name');
    Route::get('v1/edit-cost-center', function () {
        return Template::loadView("admin.uhl.edit-cost-center");
    })->name('v1.edit-cost-center');
    Route::get('v1/journal-posting', function () {
        return Template::loadView("admin.uhl.journal-posting");
    })->name('v1.journal-posting');
    Route::get('v1/inventory-tracker', function () {
        return Template::loadView("admin.uhl.inventory-tracker");
    })->name('v1.inventory-tracker');
    Route::get('v1/employee-job-info', function () {
        return Template::loadView("admin.uhl.employee-job-info");
    })->name('v1.employee-job-info');
    Route::get('v1/conveyance-bill', function () {
        return Template::loadView("admin.uhl.conveyance-bill");
    })->name('v1.conveyance-bill');

    Route::get('v1/employee-portal', function () {
        return Template::loadView("admin.uhl.employee-portal");
    })->name('v1.employee-portal');
    // carparking route
    Route::get('v1/car-parking-in', [CarparkingController::class, 'carPparkingIn'])->name('v1.car-parking-in');

    Route::get('v1/car-parking-out', [CarparkingController::class, 'carPparkingOut'])->name('v1.car-parking-out');
    // Route::get('v1/car-parking-out', function () {
    //     return Template::loadView("admin.uhl.carParking.car-parking-out");
    // })->name('v1.car-parking-out');

    Route::get('v1/car-parking-worklist', [CarparkingController::class, 'carParkingWorklist'])->name('v1.car-parking-worklist');
    Route::post('v1/car-parking-search', [CarparkingController::class, 'carParkingSearch'])->name('v1.car-parking-search');
    // Route::get('v1/car-parking-worklist', function () {
    //     return Template::loadView("admin.uhl.carParking.car-parking-worklist");
    // })->name('v1.car-parking-worklist');

    //   // amubulance
    //    Route::get('v1/ambulance-billing', function () {
    //     return Template::loadView("admin.uhl.ambulance.ambulance-billing");
    // })->name('v1.ambulance-billing');

    Route::get('v1/ambulance-work-list', function () {
        return Template::loadView("admin.uhl.ambulance.ambulance-work-list");
    })->name('v1.ambulance-work-list');

    // cafe gift shop

    Route::get('v1/cafeterria-billing', function () {
        return Template::loadView("admin.uhl.cafe_gift_shop.cafeterria-billing");
    })->name('v1.cafeterria-billing');

    Route::get('v1/cafeteria-billing-list', function () {
        return Template::loadView("admin.uhl.cafe_gift_shop.cafeteria-billing-list");
    })->name('v1.cafeteria-billing-list');

    Route::get('v1/purchase-register-report', function () {
        return Template::loadView("admin.uhl.purchase-register-report");
    })->name('v1.purchase-register-report');






    // Route::get('v1/approval-matrix', function () {
    //     return Template::loadView("admin.uhl.approval-matrix");
    // })->name('v1.approval-matrix');

    // Route::get('v1/my-approval', function () {
    //     return Template::loadView("admin.uhl.my-approval");
    // })->name('v1.my-approval');

    // Route::get('v1/matrix-worklist', function () {
    //     return Template::loadView("admin.uhl.matrix-worklist");
    // })->name('v1.matrix-worklist');


    Route::get('v1/po-terms-condition', [HOSTermsconditionController::class, 'create'])->name('v1.po-terms-condition');
    Route::get('v1/po-terms-conditions-worklist', [HOSTermsconditionController::class, 'po_terms_conditions_worklist'])->name('v1.po-terms-conditions-worklist');
    Route::get('v1/edit-po-terms-conditions/{id}',  [HOSTermsconditionController::class, 'edit'])->name('v1.edit-po-terms-conditions');
    Route::get('v1/delete-po-terms-conditions/{id}', [HOSTermsconditionController::class, 'trash'])->name('v1.delete-po-terms-conditions');
    Route::post('v1/po-terms-condition-save', [HOSTermsconditionController::class, 'store'])->name('v1.po-terms-condition-save');
    Route::post('v1/po-terms-condition-update', [HOSTermsconditionController::class, 'Update'])->name('v1.po-terms-condition-update');
    Route::post('v1/check-patReg-duplicate-info', [HOSPatientRegistrationController::class, 'checkDuplicate'])->name('v1.check-patReg-duplicate-info');
    Route::post('v1/po-terms-conditions-search', [HOSTermsconditionController::class, 'poTremsSearch'])->name('v1.po-terms-conditions-search');

    // financial report
    Route::get('v1/hospital-financial-reports', [FinancialReportController::class, 'financialReport'])->name('v1.hospital-financial-reports');
    //Purchase Accounts Book
    Route::get('v1/purchase-accounts-book', [PurchaseAccountBookController::class, 'purchaseAccountBook'])->name('v1.purchase-accounts-book');
    Route::post('v1/purchase-accounts-book-pdf', [PurchaseAccountBookController::class, 'purchaseAccountBookPDF'])->name('v1.purchase-accounts-book-pdf');

    Route::get('v1/lead-time-report', [PurchaseAccountBookController::class, 'leadTimeReport'])->name('v1.lead-time-report');

    Route::get('v1/daily-attendance-report', [EmployeePortalController::class, 'dailyAttendanceReportV1'])->name('v1.daily-attendance-report');

    // Monthly Inventory Report
    Route::get('v1/monthly-inventory-report', [InventoryReportController::class, 'MonthlyInventoryReport'])->name('v1.monthly_inventory_report');
    Route::post('v1/search-monthly-inventory-report', [InventoryReportController::class, 'SearchMonthlyInventoryReport'])->name('v1.search_monthly_inventory_report');
    Route::post('v1/monthly-inventory-report-print', [InventoryReportController::class, 'MonthlyInventoryReportPrint'])->name('v1.monthly-inventory-report-print');

     // PR Pending/Partial Report
    Route::get('v2/pr-pending-or-partial-report', [HOSGrnController::class, 'prPendingOrPartialReport'])->name('v2.pr-pending-or-partial-report');
    // Route::post("v2/grn-work-list-search", [HOSGrnController::class, 'getSearchGRNWorkListV2'])->name('v2.search-grn-worklist');
    Route::post("v2/search-pr-pending-or-partial-report", [HOSGrnController::class, 'getSearchprPendingOrPartialReport'])->name('v2.search-pr-pending-or-partial-report');
    Route::post("v2/pr-pending-or-partial-report-download", [HOSGrnController::class, 'prPendingOrPartialReportDownload'])->name('v2.pr-pending-or-partial-report-download');
    Route::post("v2/pr-asign-pdf", [HOSItemIssueController::class, 'prAssignPdf'])->name('v2.pr-asign-pdf');

    Route::get('v2/grn-register-item-wise', [HOSGrnController::class, 'grnRegisterItemWise'])->name('v2.grn-register-item-wise');


    //cosumption report item wise
    Route::get('v1/slow-moving-not-moving', [HOSItemIssueController::class, 'slowMovingNotMoving'])->name('v1.slow-moving-not-moving');
    Route::post('v1/search-slow-moving-not-moving', [HOSItemIssueController::class, 'searchslowMovingNotMoving'])->name('v1.search-slow-moving-not-moving');
    Route::post('v1/slow-moving-not-moving-print', [HOSItemIssueController::class, 'slowMovingNotMovingPrint'])->name('v1.slow-moving-not-moving-print');

    // Item Issued Report
    Route::get('/item-issued-summary-report', [ReportController::class, 'itemIssuedSummaryReport'])->name('item-issued-summary-report');
    Route::post('/item-issued-summary-report-search', [ReportController::class, 'itemIssuedSummaryReportSearch'] )->name('item-issued-summary-report-search');
    Route::post('/print-item-issued-summary-report', [ReportController::class, 'printItemIssuedSummaryReport'])->name('print-item-issued-summary-report');


});
