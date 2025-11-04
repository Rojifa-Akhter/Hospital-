<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTController;

Route::middleware(['auth'])->group(function () {

    Route::get('ot/ot-requisition', [OTController::class, 'otRequisition'])->name('ot.requisition');
    Route::post('ot/ot-requisition', [OTController::class, 'searchOTRequisition'])->name('ot.search-requisition');
    Route::post('ot/ot-requisition-print', [OTController::class, 'searchOTRequisitionPrint'])->name('ot.search-requisition-print');

    Route::get('ot/ot-confirmation-popUp/{ot_req_no_pk?}/{admission_id?}', [OTController::class, 'otConfirmationPopUp'])->name('ot-confirmation-popUp');
    Route::post('ot/ot-confirmation-popUp', [OTController::class, 'storeOTConfirmationPopUp'])->name('ot.store-ot-confirmation-popUp');

    Route::get('ot/ot-rejection-popUp/{ot_req_no_pk}', [OTController::class, 'otRejectionPopUp'])->name('ot.ot-rejection-popUp');
    Route::post('ot/ot-rejection-popUp', [OTController::class, 'storeOTRejectionPopUp'])->name('ot.store-ot-rejection-popUp');

    Route::get('ot/operation-status', [OTController::class, 'operationStatus'])->name('ot.operation-status');
    Route::post('ot/operation-status', [OTController::class, 'searchOperationStatus'])->name('ot.search-operation-status');

    Route::get('ot/ot-rejected', [OTController::class, 'otRejected'])->name('ot.ot-rejected');
    Route::post('ot/ot-rejected', [OTController::class, 'searchOTRejected'])->name('ot.ot-rejected-search');

    Route::get('ot/ot-execution', [OTController::class, 'otExecution'])->name('ot.ot-execution');
    Route::post('ot/ot-execution', [OTController::class, 'searchOTExecution'])->name('ot.ot-execution-search');
    Route::post('ot/ot-execution/print', [OTController::class, 'OTExecutionPrint'])->name('ot.ot-execution-print');

    Route::get('ot/ot-note/{ot_req_no_pk}', [OTController::class, 'otNote'])->name('ot.ot-note');
    Route::post('ot/ot-note', [OTController::class, 'storeOtNote'])->name('ot.store-ot-note');

    Route::get('ot/annest-note/{ot_req_no_pk}', [OTController::class, 'annestNote'])->name('ot.annest-note');
    Route::post('ot/annest-note', [OTController::class, 'storeAnnestNote'])->name('ot.store-annest-note');

    // Ot Report
    Route::get('ot/ot-report', [OTController::class, 'otReport'])->name('ot.ot-report');
    Route::get('procedure/procedure-report', [OTController::class, 'procedureReport'])->name('procedure.procedure-report');
    Route::post('ot/ot-report-search', [OTController::class, 'otReportSearch'])->name('ot.ot-report-search');
    Route::post('ot/ot-report-excel', [OTController::class, 'otReportExcel'])->name('ot.ot-report-excel');
    Route::post('ot/ot-report-pdf', [OTController::class, 'otReportPdf'])->name('ot.ot-report-pdf');

    //ot Medicine Setup
    Route::get('ot/medicine-setup', [OTController::class, 'otMedicineSetup'])->name('ot.medicine-setup');
    Route::post('ot/get-all-pakages', [OTController::class, 'getAllPakagesListOT'])->name('ot.get-all-pakages');
    Route::get('ot/create-medicine-setup', [OTController::class, 'otCreateMedicineSetup'])->name('ot.create-medicine-setup');
    Route::post('ot/store-pakage', [OTController::class, 'otCreateMedicineStore'])->name('ot.store-pakage');
    Route::get('ot/edit-pakage/{id?}', [OTController::class, 'otCreateMedicineEdit'])->name('ot.edit-pakage');

    Route::get('ot/indent-add-medicine/{id?}', [OTController::class, 'otAddMedicine'])->name('ot.indent-add-medicine');
    Route::post('ot/indent-add-medicine-details', [OTController::class, 'otAddMedicineDetails'])->name('ot.indent-add-medicine-details');


    // 10/06/2024
    Route::get('ot/operation-requisition-pdf', [OTController::class, 'operationRequisition'])->name('ot.operation-requisition-pdf');
    Route::get('post-anaesthetia-records-pdf', [OTController::class, 'postAnaesthetiaRecordsPdf'])->name('post-anaesthetia-records-pdf');
    Route::get('preoperative-check-list-pdf', [OTController::class, 'preoperativeCheckListPdf'])->name('preoperative-check-list-pdf');
    Route::get('recovery-note-pdf', [OTController::class, 'recoveryNote'])->name('recovery-note-pdf');
    Route::get('aneastethic-referral-pdf/{patient_id?}/{reff_no?}', [OTController::class, 'aneastethicReferralPdf'])->name('aneastethic-referral-pdf');
    Route::get('intraoperative-monitoring-chart-pdf', [OTController::class, 'IntraoperativeMonitoringChart'])->name('intraoperative-monitoring-chart-pdf');
    Route::get('recovery-room-note-pdf', [OTController::class, 'recoveryNotePdf'])->name('recovery-room-note-pdf');

    // ot schedule
    Route::get('/ot-schedule', [OTController::class, 'otSchedule'])->name('ot-schedule');
    Route::post('store-ot-schedule', [OTController::class, 'storeOtSchedule'])->name('store-ot-schedule');
    Route::post('get-ot-schedule', [OTController::class, 'getOtSchedule'])->name('get-ot-schedule');
    Route::post('delete-ot-schedule-all', [OTController::class, 'deleteOtScheduleAll'])->name('delete-ot-schedule-all');
    Route::get('get-ot-slot/{id?}', [OTController::class, 'getOtSlot'])->name('get-ot-slot');

    Route::get('ot/ot-requisition-status', [OTController::class, 'otRequisitionStatus'])->name('ot.requisition-status');
    Route::post('ot/ot-requisition-status-search', [OTController::class, 'searchOTRequisitionStatusSearch'])->name('ot.ot-requisition-status-search');
    Route::post('ot/update-status', [OtController::class, 'updateStatus'])->name('ot.ot-requisition-status-update');
    Route::post('ot/update-status-v2', [OtController::class, 'updateStatusV2'])->name('ot.ot-requisition-status-update-v2');
    Route::post('ot/update-admission-v2', [OtController::class, 'updateAdmissionStatusV2'])->name('ot.ot-admission-status-update-v2');
    Route::post('ot/status-running-v2', [OtController::class, 'updateRunningStatusV2'])->name('ot.ot-running-status-status-v2');
    Route::post('get-ot-schedule-for-status', [OTController::class, 'getOtScheduleForStatus'])->name('get-ot-schedule-for-status');
    Route::get('get-ot-slot-for-status/{id?}', [OTController::class, 'getOtSlotForStatus'])->name('get-ot-slot-for-status');



    Route::get('ot/ot-appointment-status/{req_id?}', [OTController::class, 'otManagerRequisition'])->name('ot.appointment-status');
    Route::post('ot/ot-appointment-details-info', [OTController::class, 'getRoomDataByDoctorDate'])->name('ot.ot-appointment-details-info');
    Route::post('uhl/ot-appointment-list', [OTController::class, 'getOtAppointmentList'])->name('uhl.ot-appointment-list');
    Route::get('uhl/requisition_details_form/{appoint_no_fk}', [OTController::class, 'requisitionDetailsForm'])->name('uhl.requisition_details_form');

    Route::get('ot/ot-booking-form/{reqId?}', [OTController::class, 'otBookingForm'])->name('ot.ot-booking-form');
    Route::post('/ot-booking/save', [OTController::class, 'otBook'])->name('ot.booking.save');
    Route::get('/ot-booking/{id}/pdf', [OTController::class, 'downloadPdfOtForm'])->name('ot.booking.pdf');
    Route::get('/get-room-details', [OTController::class, 'getRoomDetails'])->name('ot.get-room-details');

    Route::get('ot/pac-list', [OTController::class, 'pacList'])->name('ot.pac-list');
    Route::post('ot/pac-list-data', [OTController::class, 'pacListData'])->name('ot.pac-list-data');
    Route::get('ot/pac-accept/{pacId?}', [OTController::class, 'pacAcceptPopup'])->name('ot.pac-accept');
    Route::get('ot/pac-deferred/{pacId?}', [OTController::class, 'pacdeferredPopup'])->name('ot.pac-deferred');
    Route::post('ot/reply-submit', [OTController::class, 'otReplyForm'])->name('ot.reply-submit');

    Route::get('ipd/anaesthetic-refferral-form-pdf/{pacId?}', [OTController::class, 'anaestheticRefferalReplyFormPdf'])->name('ipd.anaesthetic-refferral-form-pdf');
    Route::get('ipd/anaesthetic-refferral-form-doc-pdf/{pacId?}', [OTController::class, 'anaestheticRefferalReplyFormDocPdf'])->name('ipd.anaesthetic-refferral-form-doc-pdf');

    Route::get('ot/pac-list-doc', [OTController::class, 'pacListDoc'])->name('ot.pac-list-doc');
    Route::get('ot.requisition-from-doc/{reqId?}', [OTController::class, 'otRequisitionForDoc'])->name('ot.requisition-from-doc');
    Route::post('ot/pac-list--doc-data', [OTController::class, 'pacListDataDoc'])->name('ot.pac-list-doc-data');
    Route::post('/ipd/admission-request-update', [OTController::class, 'admissionRequestUpdate'])->name('ipd.admission-request-update');

    Route::get('ot/requisition-form-list', [OTController::class, 'otRequilistFormList'])->name('ot.requisition-form-list');
    Route::get('ot/requisition-form-list-doc', [OTController::class, 'otRequilistFormListDoc'])->name('ot.requisition-form-list-doc');
    Route::post('ot/requisition-form-list-data', [OTController::class, 'otRequilistFormListData'])->name('ot.requisition-form-list-data');
    Route::get('ot.requisition.export-pdf', [OTController::class, 'otRequisitionPdfExport'])->name('ot.requisition.export-pdf');
    Route::get('ot.book-pdf/{pac_id?}', [OTController::class, 'otBookedPdf'])->name('ot.book-pdf');
    Route::post('/ipd/requisition-send', [OTController::class, 'sendRequisition'])->name('ipd.requisition-send');

    Route::get('ot/recommend-investigation', [OTController::class, 'recommendInvestigation'])->name('ot.recommend-investigation');
    Route::get('ot/slot-book/{id?}', [OTController::class, 'otSlotBook'])->name('ot.slot-book');
    Route::post('slot/book-by-doc', [OTController::class, 'slotBookByDoc'])->name('slot.book-by-doc');
    Route::get('/patients/today', [OTController::class, 'todaysPatient'])->name('todays-patient');
    Route::get('/patient/{reqid}', [OTController::class, 'show'])->name('ot.show-patient-details');
    Route::post('/patient/book', [OTController::class, 'book'])->name('ot.slot-book-store');

    Route::get('ot/today-patient-list', [OTController::class, 'otTodayPatientList'])->name('ot/today-patient-list');
    Route::post('ot/todays-patient-list-data', [OTController::class, 'otTodayPatientListData'])->name('ot.todays-patient-list-data');

    Route::get('anesthetia-reffered-list', [OTController::class, 'anesthetiaDocList'])->name('anesthetia-reffered-list');
    Route::post('anesthetia-reffered-list-data', [OTController::class, 'anesthetiaDocListData'])->name('anesthetia-reffered-list-data');
    Route::post('/ipd/submit-referral', [OTController::class, 'submitDatajson'])->name('ipd.submit-referral');
    Route::get('ot/cancel-booking/{reff_no?}', [OTController::class, 'cancelBooking'])->name('ot.cancel-booking');
    Route::post('ot/cancel-ot', [OTController::class, 'otCancel'])->name('ot.cancel-ot');

    Route::get('ot/ot-requisiton-list', [OTController::class, 'otRequisitionList'])->name('ot/ot-requisiton-list');
    Route::post('ot/ot-requisiton-list-data', [OTController::class, 'otRequisitionListData'])->name('ot/ot-requisiton-list-data');

    Route::get('doctor-wise-surgery-list', [OTController::class, 'doctorWiseSurgery'])->name('doctor-wise-surgery-list');
    Route::post('doctor-wise-surgery-list-data', [OTController::class, 'doctorWiseSurgeryData'])->name('doctor-wise-surgery-list-data');
    Route::post('/doctor-wise-surgery-export', [OTController::class, 'exportDoctorSurReport'])->name('doctor-wise-surgery-export');

    Route::get('ot/investigation-anesthealization/{invid?}/{itemid?}', [OTController::class, 'investigationAneasthelization'])->name('ot.investigation-anesthealization');
    Route::get('ot/investigation-anesthealization-ipd/{admId?}/{itemid?}', [OTController::class, 'investigationAneasthelizationIpd'])->name('ot.investigation-anesthealization-ipd');
    Route::post('ot/investigation-anesthealization-store', [OTController::class, 'invAnesStore'])->name('ot/investigation-anesthealization-store');

});
