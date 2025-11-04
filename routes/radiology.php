<?php

use App\Models\ServiceUnit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RadiologyController;
use App\Http\Controllers\PathologyController;
Route::middleware(['auth'])->group(function () {

    // Create Appointment
    Route::get('radiology/create-appointment-v2', [RadiologyController::class, 'radiologyCreateAppointmentv2'])->name('radiology.create-appointment-v2');
    Route::get('schedule-intervals-v2', [RadiologyController::class, 'generateIntervalsV2'])->name('schedule-intervals-v2');
    Route::post('radiology/search-appointment-investigation-v2', [RadiologyController::class, 'radiologySearchPatientInvestigationV2'])->name('radiology.search-appointment-investigation-v2');
    Route::get('date-wise-schedule-intervals-v2', [RadiologyController::class, 'dateWiseGenerateIntervalsV2'])->name('date-wise-schedule-intervals-v2');
    Route::get('radiology/appointment-card-print-V2/{radinvoicedtl_no_pk?}', [RadiologyController::class, 'get_appointment_card_print_V2'])->name('radiology-appointment-card-print-V2');
    Route::get('radiology/appointment-card-print-not-bill/{scheduleId?}', [RadiologyController::class, 'get_appointment_card_print_notbill'])->name('radiology/appointment-card-print-not-bill');


    // Image Capture list
    ServiceUnit::all()->each(function ($config) {
        Route::get('radiology/radiology-sample-' . strtolower($config->serviceunit_code), [RadiologyController::class, 'radiologyImageCaptureV2'])
            ->name('radiology/radiology-sample-' . $config->serviceunit_code)
            ->defaults('type', $config->serviceunit_code);
    });


    Route::get('radiology/radiology-sample-v2', [RadiologyController::class, 'radiologyImageCaptureV2'])->name('radiology.radiology-image-capture-v2');



    Route::get('radiology/radiology-sample-collected', [RadiologyController::class, 'radiologyImageCaptureCollected'])->name('radiology.radiology-image-capture-collected');
    Route::get('radiology/radiology-sample-pending', [RadiologyController::class, 'radiologyImageCapturePending'])->name('radiology.radiology-image-capture-pending');
    Route::get('radiology/radiology-sample-ipd-pending', [RadiologyController::class, 'radiologyImageCaptureIpdPending'])->name('radiology.radiology-image-capture-ipd-pending');
    Route::get('radiology/radiology-image-capture-ipd-collected', [RadiologyController::class, 'radiologyImageCaptureIpdCollected'])->name('radiology.radiology-image-capture-ipd-collected');
    Route::get('radiology/radiology-sample-collection', [RadiologyController::class, 'radiologyImageCaptureCollection'])->name('radiology.radiology-image-capture-collection');
    Route::get('radiology/radiology-sample-collection-v2', [RadiologyController::class, 'radiologyImageSampleCollectionV2'])->name('radiology.radiology-image-sample-collection-v2');
    Route::get('radiology-label-print-all/{report_id}', [RadiologyController::class, 'labelPrintUhl'])->name('radiology-label-print-all');


    // Resut Part
    ServiceUnit::all()->each(function ($config) {
        Route::get('radiology/result-entry-' . strtolower($config->serviceunit_code), [RadiologyController::class, 'radiologyResultEntryWorklistV2'])
            ->name('radiology/result-entry-' . $config->serviceunit_code)
            ->defaults('type', $config->serviceunit_code);
    });

    Route::get('radiology/result-entry-wl-v2/{type?}', [RadiologyController::class, 'radiologyResultEntryWorklistV2'])->name('radiology.result-entry-wl-v2');
    Route::get('radiology/result-entry-wl-v2-tab/{type?}', [RadiologyController::class, 'radiologyResultTabWorklistV2'])->name('radiology.result-entry-wl-v2-tab');
    Route::get('radiology/result-entry-v2/{radinvoicedtl_no_pk?}/{type?}', [RadiologyController::class, 'radiologyResultEntryV2'])->name('radiology.result-entry-v2');
   Route::get('radiology/result-entry-v3/{radinvoicedtl_no_pk?}/{type?}', [RadiologyController::class, 'radiologyResultEntryV3'])->name('radiology.result-entry-v3');

    Route::get('v2/radiology/rad-report-pdf/{report_id}', [RadiologyController::class, 'resultEntryPdfV2'])->name('v2.radiology.rad-report-pdf');
    Route::get('v3/radiology/rad-report-pdf/{report_id}', [RadiologyController::class, 'resultEntryPdfV3'])->name('v3.radiology.rad-report-pdf');
    Route::get('radiology/result-finalize-wl-v2/{type?}', [RadiologyController::class, 'radiologyResultFinalizeWorklistV2'])->name('radiology.result-finalize-wl-v2');

    ServiceUnit::all()->each(function ($config) {
        Route::get('radiology/result-finalize-' . strtolower($config->serviceunit_code), [RadiologyController::class, 'radiologyResultFinalizedWorklistV2'])
            ->name('radiology/result-finalize-' . $config->serviceunit_code)
            ->defaults('type', $config->serviceunit_code);
    });



    Route::get('radiology/result-finalized-wl-v2/{type?}', [RadiologyController::class, 'radiologyResultFinalizedWorklistV2'])->name('radiology.result-finalized-wl-v2');
    Route::post('radiology/search-result-entry-list-v2', [RadiologyController::class, 'searchResultEntryListV2'])->name('radiology.search-result-entry-list-v2');


    ServiceUnit::all()->each(function ($config) {
        Route::get('radt/result-finalized-print-' . strtolower($config->serviceunit_code), [RadiologyController::class, 'resultFinalizedPrint'])
            ->name('radt/result-finalized-print-' . $config->serviceunit_code)
            ->defaults('type', $config->serviceunit_code);
    });


    Route::get('radt/result-finalized-print', [RadiologyController::class, 'resultFinalizedPrint'])->name('radt.result-finalized-print');

    // setup
    Route::get('/radiology-item-wise-room', [RadiologyController::class, 'radiologyItemWiseRoom'])->name('radiology-item-wise-room');
    Route::post('/radiology-user-wise-room-save', [RadiologyController::class, 'storeRadiologyItemWiseRoom'])->name('radiology-item-wise-room.storeRadiologyitemWiseRoom');
    Route::post('radiology/item_data_checked', [RadiologyController::class, 'itemChecked'])->name('radiology.item_data_checked');
    Route::get('/radiology-item-wise-room-schedule', [RadiologyController::class, 'radiologyItemWiseRoomSchedule'])->name('radiology-item-wise-room-schedule');
    Route::get('/radiology-item-wise-room-schedule-form', [RadiologyController::class, 'radiologyitemrWiseRoomScheduleForm'])->name('radiology-item-wise-room-schedule-form');
    Route::post('/radiology-item-wise-room-schedule-list', [RadiologyController::class, 'radiologyItemWiseRoomScheduleList'])->name('radiology-Item-wise-room-schedule-list');


 # Laboratory Life Cycle
    Route::get('radiology-life-cycle', [RadiologyController::class, 'radiologyLifeCycle'])->name('radiologyLifeCycle.index');
    Route::post('radiology-life-cycle/get-data', [RadiologyController::class, 'radiologyLifeCyclegetData'])->name('radiologyLifeCycle.getData');
    Route::post('radiology-life-cycle/filter', [RadiologyController::class, 'radiologyLifeCyclefilter'])->name('radiologyLifeCycle.filter');


    Route::get('reports/radiology-report-list-menu', [RadiologyController::class, 'reportListMenu'])->name('reports.radiology-report-list-menu');
    Route::get('reports/radiology-report-list-menu-data', [RadiologyController::class, 'reportListMenuData'])->name('reports.radiology-report-list-menu-data');
    Route::post('radiology-feature-wise-route-save', [RadiologyController::class, 'saveMenuRoute'])->name('radiology-feature-wise-route-save');
    Route::get('reports/get-radiology-menu-list', [RadiologyController::class, 'getRadiologyMenuList'])->name('reports/get-radiology-menu-list');

    // Menu Setup
    Route::get('reports/radiology-report-entry', [RadiologyController::class, 'reportEntryPage'])->name('reports.radiology-report-entry');
    Route::get('reports/get-radiology-report', [RadiologyController::class, 'getRadiologyReport'])->name('reports.get-radiology-report');
    Route::post('reports/radiology-report-generate', [RadiologyController::class, 'storeEntryReport'])->name('reports.radiology-report-generate');
    Route::post('reports/radiology-report-update', [RadiologyController::class, 'updateReport'])->name('reports.radiology-report-update');
    Route::get('reports/edit-radiology-report/{id}', [RadiologyController::class, 'reportEntryEdit'])->name('reports.edit-radiology-report');
    Route::get('report/radiology-report-details/{id}', [RadiologyController::class, 'reportDetatils'])->name('report.radiology-report-details');


    Route::get('radiology-appointment-status-list', [RadiologyController::class, 'radiologyAppointmentStatusList'])->name('radiology-appointment-status-list');
    Route::get('radiology-appointment-status-data', [RadiologyController::class, 'radiologyAppointmentStatusData'])->name('radiology-appointment-status-data');
    Route::get('radiology-appointment-advance-apointment', [RadiologyController::class, 'radiologyAdvanceApointment'])->name('radiology-appointment-advance-apointment');
    Route::post('/radiology/search-by-invoice-wise-item', [RadiologyController::class, 'searchByInvoiceWiseItem'])->name('radiology-search-by-invoice-wise-item');
    Route::post('/radiology/find-item-by-name', [RadiologyController::class, 'findItemByName'])->name('radiology-find-item-by-name');
    Route::post('/radiology/appointment-book-slot', [RadiologyController::class, 'bookSlot'])->name('radiology-appointment-book-slot');
    Route::post('get-rooms-schedule-by-item', [RadiologyController::class, 'getRoomScheduleByItem'])->name('get-rooms-schedule-by-item');
    Route::post('/radiology/appointment/save', [RadiologyController::class, 'saveAppointment'])->name('radiology-save-appointment');
    Route::post('/radiology/fetch-room-wise-slots', [RadiologyController::class, 'fetchRoomWiseSlots'])->name('radiology-fetch-room-wise-slots');
    // route/web.php
    Route::get('/fetch-booked-slots', [RadiologyController::class, 'fetchBookedSlots'])->name('radiology-appointment-fetch-booked-slots');
    Route::post('get-pre-requisition', [RadiologyController::class, 'getPrerequisition'])->name('get-pre-requisition');
    Route::post('get-room-schedule', [RadiologyController::class, 'getRoomSchedule'])->name('get-room-schedule');

    Route::get('reports/label-print', [RadiologyController::class, 'labelPrintPage'])->name('reports.label-print');
    Route::post('/radiology/fetch-label-print-data', [RadiologyController::class, 'fetchLabelPrintData'])->name('search-reports.label-print');

    // Route::get('radiology/appointment-card-print-V2/{radinvoicedtl_no_pk?}' , [RadiologyController::class, 'get_appointment_card_print_V2'])->name('radiology-appointment-card-print-V2');


      Route::get("report-delivery-v3", [RadiologyController::class,'ReportDeliveryv3'])->name("report-delivery-v3");

    Route::post('/report-delivery/pathology', [RadiologyController::class, 'pathologyDeliveryV3'])->name('report-delivery.pathology');
    Route::post('/report-delivery/radiology', [RadiologyController::class, 'radiologyDeliveryV3'])->name('report-delivery.radiology');
    Route::get('radiology/reports/print-multiple', [RadiologyController::class, 'resultEntryMultiplePdf'])->name('radiology.reports.printMultiple');
    Route::post('radiology/reports/email-multiple', [RadiologyController::class, 'resultEntryMultipleEmail'])->name('radiology.reports.emailMultiple');
    Route::post('pathology/reports/email-multiple', [RadiologyController::class, 'resultEntryMultipleEmailPath'])->name('pathology.reports.emailMultiple');
    Route::get('/pathology/batch-print', [PathologyController::class, 'mergeReports'])->name('pathology.batch-print');



    Route::fallback(function () {
        return redirect()->route('home');
    });
});
