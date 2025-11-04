<?php

use App\Http\Controllers\AdmittedPatientSummary;
use App\Http\Controllers\IPDController;
use App\Http\Controllers\OTController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\NSDSController;
use App\Http\Controllers\NSDSCoverageController;
use App\Http\Controllers\CaseSheetController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\IPDBillingController;
use App\Http\Controllers\IPDReportController;
use App\Http\Controllers\PcrmController;
use App\Http\Controllers\IPDMedicationController;
use App\Http\Controllers\IPDIntakeOutputController;
use App\Http\Controllers\IPDDailyFollowupController;
use App\Http\Controllers\IPDDiabeticController;
use App\Http\Controllers\IPDDietController;
use App\Http\Controllers\IPDOxyGenInhalerController;
use App\Http\Controllers\TestIPDController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('ipd/ipd-request-referred-patient', [IPDController::class, 'ipdRequestReferredPatient'])->name('ipd.ipd-request-referred-patient');
    Route::post('ipd/search-admission-patient', [IPDController::class, 'searchAdmissionPatient'])->name('ipd.search-admission-patient');
    Route::post('ipd/search-referred-patient', [IPDController::class, 'searchReferredPatient'])->name('ipd.search-referred-patient');
    Route::get('ipd/ipd-request-referred-patient-admission/{service_no?}/{admission_req_uid?}', [IPDController::class, 'ipdRequestReferredPatientAdmission'])->name('ipd.ipd-request-referred-patient-admission');
    Route::get('ipd/admission-rejection/{service_no?}/{admission_req_uid?}', [IPDController::class, 'ipdRequestReferredAdmissionrejection'])->name('ipd.admission-rejection');
    Route::post('ipd/store-admission-rejection', [IPDController::class, 'store_ipdAdmissionRejection'])->name('ipd.store-admission-rejection');
    Route::get('ipd/admission-cancelled', [IPDController::class, 'ipdRequestReferredAdmissionCancelled'])->name('ipd.admission-cancelled');
    Route::post('ipd/admission-cancelled', [IPDController::class, 'searchReferredAdmissionCancelled'])->name('ipd.search-admission-cancelled');
    Route::get('ipd/admission-patient-tab', [IPDController::class, 'ipdRequestReferredAdmitedPatient'])->name('ipd.admission-patient-tab');
    // Route::post('ipd/admission-cancelled', [IPDController::class, 'searchReferredAdmissionCancelled'])->name('ipd.search-admission-cancelled');

    Route::get('ipd/ipd-request-referred-admitted-patient', [IPDController::class, 'ipdRequestReferredAdmittedPatient'])->name('ipd.ipd-request-referred-admitted-patient');
    Route::post('ipd/ipd-request-referred-admitted-patient', [IPDController::class, 'searchReferredAdmittedPatient'])->name('ipd.search-referred-admitted-patient');


    Route::get('ipd/nurse-station-received-patient', [IPDController::class, 'nurseStationReceivedPatient'])->name('ipd.nurse-station-received-patient');
    Route::post('ipd/nurse-station-receive-a-patient', [IPDController::class, 'receivePatientForNurseStation'])->name('ipd.nurse-station-receive-a-patient');

    Route::get('ipd/assign-bed/{adms_no?}/{wrd_name?}/{wrd_no?}/{bed_no?}', [IPDController::class, 'assignBed'])->name('ipd.assign-bed');
    Route::post('ipd/update-assign-bed', [IPDController::class, 'updateAssignBed'])->name('ipd.update-assign-bed');

    Route::get('ipd/discharge-req-list', [IPDController::class, 'dischargeReqList'])->name('ipd.discharge-req-list');
    Route::get('ipd/discharge-template', [IPDController::class, 'dischargeTemplate'])->name('ipd.discharge-template');
    Route::post('ipd/discharge-template-list', [IPDController::class, 'dischargeTemplateList'])->name('ipd.discharge-template-list');
    Route::post('ipd/discharge-template-list-search', [IPDController::class, 'dischargeTemplateListSearch'])->name('ipd.discharge-template-list-search');
    Route::get('ipd/discharge-template-edit/{id}', [IPDController::class, 'dischargeTemplateEdit'])->name('ipd.discharge-template-edit');

    //after discharge
    Route::get('ipd/discharge-req-list-v2', [IPDController::class, 'dischargeReqListV2'])->name('ipd.discharge-req-list-v2');
    Route::post('ipd/discharge-req-list-v2', [IPDController::class, 'searchDischargeListV2'])->name('ipd.discharge-req-list-search-v2');


    // discharge request list for Revenue Posting
    Route::get('ipd/discharge-req-list-revenue-posting', [IPDController::class, 'dischargeReqListRevenuePosting'])->name('ipd.discharge-req-list-revenue-posting');
    Route::post('ipd/discharge-req-list-revenue-posting-search', [IPDController::class, 'searchDischargeListRevenuePosting'])->name('ipd.discharge-req-list-revenue-posting-search');
    // For single-row GET posting
    Route::get('ipd/revenue-posting-single/{admissionID}', [IPDController::class, 'revenuePostingSingle'])->name('ipd.revenue-posting-single');
    // For bulk/multiple POST posting
    Route::post('ipd/revenue-posting', [IPDController::class, 'revenuePosting'])->name('ipd.revenue-posting');


    //ipd patient list
    Route::get('ipd/cafe-patient-list', [IPDController::class, 'cafePatientList'])->name('ipd.cafe-patient-list');
    Route::get('ipd/cafe-patient-list-v2', [IPDController::class, 'cafePatientListV2'])->name('ipd.cafe-patient-list-v2');
    Route::post('ipd/cafe-patient-save', [IPDController::class, 'saveCafePatient'])->name('ipd.cafe-patient-save');
    Route::get('ipd/cafe-print/{id}', [IPDController::class, 'reportCafePatient'])->name('ipd.cafe-print');



    //blood bank
    Route::get('ipd/blood-bank-requisition/{patient_id?}/{admission_uid?}', [IPDController::class, 'bloodBankRequisition'])->name('ipd.blood-bank-requisition');
    Route::get('ipd/edit-blood-bank-requisition/{id}', [IPDController::class, 'editBloodBankRequisition'])->name('ipd.edit-blood-bank-requisition');
    Route::get('ipd/pdf-blood-bank-requisition/{id}', [IPDController::class, 'pdfBloodBankRequisition'])->name('ipd.pdf-blood-bank-requisition');
    Route::post('ipd/search-blood-bank-requisition', [IPDController::class, 'searchBloodBankRequisition'])->name('ipd.search-blood-bank-requisition');
    Route::post('ipd/save-blood-bank-requisition', [IPDController::class, 'saveBloodBankRequisition'])->name('ipd.save-blood-bank-requisition');
    Route::post('ipd.save-blood-bank-donor-info', [IPDController::class, 'saveBloodBankDonor'])->name('ipd.save-blood-bank-donor-info');
    Route::post('ipd.save-blood-bank-donor-info-dmhl', [IPDController::class, 'saveBloodBankDonorDMHL'])->name('ipd.save-blood-bank-donor-info-dmhl');
    Route::post('ipd.save-blood-bank-patient-donor-info', [IPDController::class, 'saveBloodBankpatientDonorInfo'])->name('ipd.save-blood-bank-patient-donor-info');
    Route::get('ipd/blood-bank-requisition-worklist', [IPDController::class, 'bloodBankRequisitionWorklist'])->name('ipd.blood-bank-requisition-worklist');
    Route::post('ipd/blood-bank-requisition-search', [IPDController::class, 'bloodBankRequisitionSearch'])->name('ipd.blood-bank-requisition-search');
    Route::get('ipd/blood-bank-requisition-add-donor/{id}', [IPDController::class, 'bloodBankRequisitionAddDonor'])->name('ipd.blood-bank-requisition-add-donor');
    Route::get('ipd/add-donor-cross-match/{id?}', [IPDController::class, 'AddDonorCrossMatch'])->name('ipd.add-donor-cross-match');
    Route::get('ipd/blood-bank-requisition-edit-donor/{id}', [IPDController::class, 'bloodBankRequisitionEditDonor'])->name('ipd.blood-bank-requisition-edit-donor');
    Route::post('ipd/blood-bank-donor-search', [IPDController::class, 'bloodBankDonorSearch'])->name('ipd.blood-bank-donor-search');

    Route::get('ipd/donor-cross-match', [IPDController::class, 'bloodBankDonorCrossMatch'])->name('ipd.donor-cross-match');
    Route::post('ipd.search-donor-info-for-cross-match', [IPDController::class, 'donorInfoforCrossMatch'])->name('ipd.search-donor-info-for-cross-match');
    Route::post('ipd/save-blood-bank-cross-match-dmhl', [IPDController::class, 'bloodBankDonorCrossMatchSaveDMHL'])->name('ipd.save-blood-bank-cross-match-dmhl');
    Route::get('ipd/cross-match-list-dmhl', [IPDController::class, 'bloodBankCrossMatchListDMHL'])->name('ipd.cross-match-list-dmhl');
    Route::post('ipd/cross-match-list-search', [IPDController::class, 'bloodBankCrossMatchListSearchDMHL'])->name('ipd.cross-match-list-search');
    Route::get('ipd/bag-sticker-pdf/{id?}/{blood_bag_no?}', [IPDController::class, 'bloodBagStickerPDF'])->name('ipd.bag-sticker-pdf');
    Route::get('ipd/cross-match-match-report/{id?}/{blood_bag_no?}', [IPDController::class, 'bloodBagCrossMatchReportPDF'])->name('ipd.cross-match-match-report');
    Route::get('ipd/edit-donor-cross-match/{id?}', [IPDController::class, 'editCrossMatch'])->name('ipd.edit-donor-cross-match');
    Route::get('ipd/blood-bag-stock-worklist', [IPDController::class, 'bloodBagIssueWorklist'])->name('ipd.blood-bag-stock-worklist');
    Route::get('ipd/blood-bag-return-worklist', [IPDController::class, 'bloodBagReturnWorklist'])->name('ipd.blood-bag-return-worklist');
    Route::post('ipd/blood-bag-return-worklist-search', [IPDController::class, 'bloodBagReturnWorklistSearch'])->name('ipd.blood-bag-return-worklist-search');
    Route::post('ipd/blood-bag-issue-worklist-search', [IPDController::class, 'bloodBagIssueWorklistSearch'])->name('ipd.blood-bag-issue-worklist-search');
    Route::post('ipd/blood-issue-update', [IPDController::class, 'bloodBagIssueUpdate'])->name('ipd.blood-issue-update');
    Route::post('ipd/blood-bag-discard-update', [IPDController::class, 'bloodBagDiscardUpdate'])->name('ipd.blood-bag-discard-update');
    Route::post('ipd/blood-return-update', [IPDController::class, 'bloodBagReturnUpdate'])->name('ipd.blood-return-update');
    Route::post('ipd/blood-bag-received-update', [IPDController::class, 'bloodBagReceivedUpdate'])->name('ipd.blood-bag-received-update');
    Route::get('ipd/blood-bag-issue-report/{id}/{blood_bag_no?}', [IPDController::class, 'bloodBagIssueReport'])->name('ipd.blood-bag-issue-report');
    Route::get('ipd/blood-bank-requisition-edit-donor-dmhl/{id}/{status?}', [IPDController::class, 'bloodBankRequisitionEditDonorDMHL'])->name('ipd.blood-bank-requisition-edit-donor-dmhl');
    Route::get('ipd/blood-bank-requisition-donor-list/{id?}', [IPDController::class, 'bloodBankRequisitionDonorList'])->name('ipd.blood-bank-requisition-donor-list');
    Route::get('ipd/pdf-blood-bank-donor-details/{id}', [IPDController::class, 'pdfBloodBankDonorDetails'])->name('ipd.pdf-blood-bank-donor-details');
    Route::get('ipd/blood-collection-worklist', [IPDController::class, 'bloodCollectionWorklist'])->name('ipd.blood-collection-worklist');
    Route::post('ipd/blood-collection-search', [IPDController::class, 'bloodCollectionSearch'])->name('ipd.blood-collection-search');
    Route::get('ipd/blood-collection-from-donar/{requsition_no}/{donor_no}/{admission_no}/{admission_date?}/{blood_group?}/{collection_no?}', [IPDController::class, 'bloodCollectionFromDonor'])->name('ipd.blood-collection-from-donar');
    Route::post('ipd/save-blood-collection-form', [IPDController::class, 'saveBloodCollectionFromDonor'])->name('ipd.save-blood-collection-form');
    Route::get('ipd/donor-barcode-print/{id?}', [IPDController::class, 'donorBarcodePrint'])->name('ipd.donor-barcode-print');


    //ipd
    Route::get('ipd/ipd-admission', [IPDController::class, 'ipdAdmission'])->name('ipd.ipd-admission');
    Route::get('ipd/ipd-admission/emergency/{bed_id?}', [IPDController::class, 'quickAdmissionEmergency'])->name('ipd.ipd-admission-emergency');
    Route::post('ipd/get-bed-by-ward', [IPDController::class, 'getBedByWard'])->name('ipd.get-bed-by-ward');
    Route::post('ipd/get-bed-by-ward-count', [IPDController::class, 'getBedByWardCount'])->name('ipd.get-bed-by-ward-count');
    Route::post('ipd/get-bed-by-ward-search', [IPDController::class, 'getBedByWardSearch'])->name('ipd.get-bed-by-ward-search');
    Route::post('ipd/get-ward', [IPDController::class, 'getDeptByWard'])->name('ipd.get-ward');
    Route::post('ipd/get-ward-search', [IPDController::class, 'bedSeacrhByWard'])->name('ipd.get-ward-search');
    Route::get('ipd/ipd-get-all-bed', [IPDController::class, 'ipdGetAllBed'])->name('get_bed_data');
    Route::get('ipd/ipd-get-patient-bed-info', [IPDController::class, 'ipdGetBedInfo'])->name('ipd.get-patient-bed-info');
    Route::get('ipd/ipd-patient', [IPDController::class, 'ipdAllPatient'])->name('ipd.ipd-patient');
    Route::get('ipd/quick-admission/{patId?}/{ref_ind?}/{doctor_id?}/{doctor_name?}/{admReqId?}', [IPDController::class, 'quickAdmission'])->name('ipd.quick-admission');
    Route::post('ipd/ipd-non-register-admission', [IPDController::class, 'ipdNonRegisterPatientAdmission'])->name('ipd.ipd-non-register-admission');
    Route::post('ipd/store-quick-admission', [IPDController::class, 'storeQuickAdmission'])->name('ipd.store-quick-admission');
    Route::get('ipd/admission-print-pdf/{admission_id}', [IPDController::class, 'ipdAdmissionPdf'])->name('ipd.admission-print-pdf');
    Route::get('ipd/admission-print-pdf-v1/{admission_id}', [IPDController::class, 'ipdAdmissionPdfV1'])->name('ipd.admission-print-pdf-v1');
    Route::get('ipd/admission-print-pdf-emergency/{admission_id?}/{type?}', [IPDController::class, 'ipdAdmissionPdfEmergency'])->name('ipd.admission-print-pdf-emergency');
    Route::post('ipd/discharge-req-list', [IPDController::class, 'searchDischargeReqList'])->name('ipd.discharge-req-list-search');




    //emergency admission
    Route::get('ipd/emergency-admission/{patId?}/{ref_ind?}/{doctor_id?}/{doctor_name?}/{admReqId?}', [IPDController::class, 'emergencyAdmission'])->name('ipd.emergency-admission');
    Route::post('ipd/store-emergency-admission', [IPDController::class, 'storeEmergencyAdmission'])->name('ipd.store-emergency-admission');
    Route::get('ipd/emergency-admission-list', [IPDController::class, 'emergencyAdmissionList'])->name('ipd.emergency-admission-list');



    //patient list for advance payment
    Route::get('ipd/ipd-patient-list-new', [IPDController::class, 'ipdPatientListNew'])->name('ipd.ipd-patient-list-new');
    Route::post('ipd/search-ipd-patient-list-new', [IPDController::class, 'searchPatientListNew'])->name('ipd.search-ipd-patient-list-new');


    Route::post("ipd/ipd-business-office-search", [IPDController::class, 'ipdBusinessOfficeSearch'])->name('ipd.ipd-business-office-search');

    Route::get("ipd/ipd-business-office-search-admit", [IPDController::class, 'ipdBusinessOfficeSearchAdmit'])->name('ipd.ipd-business-office-search-admit');

    // Route::get("ipd/ipd-business-office-search", [IPDController::class, 'ipdBusinessOfficeSearch'])->name('ipd.ipd-business-office-search');

    Route::post("ipd/ipd-previous-details", [IPDController::class, 'ipdPreviousDetails'])->name("ipd.ipd-previous-details");

    Route::post("ipd/patient-payment/{patientID?}", [IPDController::class, 'ipdPatientPayment'])->name('ipd.patient.payment');

    //financial-clearance
    Route::get("ipd/financial-payment/{admissionID?}", [IPDController::class, 'ipdFinancialClearance'])->name('ipd.financial-clearance');
    Route::post("ipd/update-financial-clearence", [IPDController::class, 'updateFinancialClearance'])->name("ipd.update-financial-clearence");

    Route::get("ipd/ipd-draft-print/{admissionID?}", [IPDController::class, 'ipdDraftPrint'])->name("ipd.ipd-draft-print");
    Route::get("v1/ipd/ipd-draft-print/{admissionID?}", [IPDController::class, 'ipdNewDraftPrint'])->name("v1.ipd.ipd-draft-print");
    Route::get("v1/ipd/ipd-draft-print-new/{admissionID?}", [IPDController::class, 'ipdNewDraftPrintNew'])->name("v1.ipd.ipd-draft-print-new");
    Route::get("v2/ipd/ipd-draft-print-new/{admissionID?}", [IPDController::class, 'ipdNewDraftPrintNewV2'])->name("v2.ipd.ipd-draft-print-new");
    Route::get("v1/ipd/ipd-final-print/{admissionID?}", [IPDController::class, 'ipdNewFinalPrint'])->name("v1.ipd.ipd-final-print");
    Route::get("v2/ipd/ipd-final-print/{admissionID?}", [IPDController::class, 'ipdNewFinalPrintV2'])->name("v2.ipd.ipd-final-print");
    Route::get("v2/ipd/ipd-approximately-print/{admissionID?}", [IPDController::class, 'ipdNewApproPrintV2'])->name("v2.ipd.ipd-approximately-print");
    Route::get("v3/ipd/ipd-final-print/{admissionID?}", [IPDController::class, 'ipdNewFinalPrintV3'])->name("v3.ipd.ipd-final-print");



    Route::get("ipd/ipd-final-bill-print/{admissionID?}", [IPDController::class, 'ipdFinalBillPrint'])->name("ipd.ipd-final-bill-print");
    Route::get("ipd/ipd-summary-bill-print/{admissionID?}", [IPDController::class, 'ipdSummaryBillPrint'])->name("ipd.ipd-summary-bill-print");
    Route::get("ipd/ipd-draft-bill-print-v3/{admissionID?}", [IPDController::class, 'ipdSummaryBillPrintV2'])->name("ipd.ipd-summary-bill-print-v2");
    Route::get("v1/ipd/ipd-final-bill-print/{admissionID?}", [IPDController::class, 'ipdFinalBillPrintV1'])->name("v1.ipd.ipd-final-bill-print");
    Route::get("ipd/ipd-final-bill-print-draft/", [IPDController::class, 'ipdFinalBillPrintDraft'])->name("ipd.ipd-final-bill-print-draft");
    Route::get("ipd/ipd-final-bill-print/v2/{admissionID?}", [IPDController::class, 'ipdFinalBillPrintV2'])->name("ipd.ipd-final-bill-print-v2");

    Route::get("ipd/ipd-final-bill-print-phamacy/v2/{admissionID?}", [IPDController::class, 'ipdFinalBillPrintPharmacyV2'])->name("ipd.ipd-final-bill-print-pharmacy-v2");

    Route::get("ipd/discharge-request-by-doctor/{admissionID?}", [IPDController::class, 'dischargeRequestByDoctor'])->name("ipd.discharge-request-by-doctor");
    Route::get("ipd/bill-lock/{admissionID?}/{remarks?}/{lockIND?}", [IPDController::class, 'ipdBillLock'])->name("ipd.bill-lock");
    Route::post("ipd/update-ipd-bill-lock", [IPDController::class, 'saveIpdBillLock'])->name("ipd.update-ipd-bill-lock");
    Route::post("ipd/update-discharge-request", [IPDController::class, 'updateDischargeRequest'])->name("ipd.update-discharge-request");

    Route::post("ipd/store-discharge-summary", [IPDController::class, 'storeDischargeSummary'])->name("ipd.store-discharge-summary");
    Route::post("ipd/store-discharge-summary-template", [IPDController::class, 'storeDischargeSummaryTemplate'])->name("ipd.store-discharge-summary-template");
    Route::post("ipd/store-discharge-summary-temp", [IPDController::class, 'storeDischargeSummaryTemp'])->name("ipd.store-discharge-summary-temp");

    Route::get("ipd/ipd-update-discharge/{admissionID?}", [IPDController::class, 'updateIpdDischarge'])->name("ipd.ipd-update-discharge");
    Route::get("ipd/admission-list-edit/{admissionID?}", [IPDController::class, 'editIpdAdmission'])->name("ipd.admission-list-edit");
    Route::get('ipd/bed-transfer/{admissionId?}', [IPDController::class, 'bedTransfer'])->name('ipd.bed-transfer');
    Route::post('ipd/bed-transfer/process', [IPDController::class, 'bedTransferProcess'])->name('ipd.bed-transfer-process');


    //Ipd Bed Viewer Added By Nazmul Dt:August 2 2021
    Route::get('ipd/beds-viewer', [SiteController::class, 'ipdBedViewer'])->name('ipd/beds-viewer');
    Route::get('ipd/beds-viewer-v2', [SiteController::class, 'ipdBedViewerV2'])->name('ipd/beds-viewer-v2');
    Route::post('ipd/beds-viewer-search-v2', [SiteController::class, 'ipdBedViewerSearchV2'])->name('ipd.beds-viewer-search-v2');
    Route::get('ipd/bed-information/{id?}', [SiteController::class, 'ipdBedInfo'])->name('ipd.bed-information');
    Route::get('ipd/patient-information/{id?}', [SiteController::class, 'ipdPatientnfo'])->name('ipd.patient-information');
    Route::post('ipd/beds-viewer-list', [SiteController::class, 'ipdAllBedViewer'])->name('ipd/beds-viewer-list');


    //Ipd Bed Viewer Added By Nazmul Dt:August 2 2021
    Route::get('ipd/beds-viewer/emergency', [SiteController::class, 'ipdBedViewerEmergency'])->name('ipd.bed-viewer-emergency');
    // Route::get('ipd/bed-information/{id?}', [SiteController::class, 'ipdBedInfo'])->name('ipd.bed-information');
    Route::post('ipd/beds-viewer-list-emergency', [SiteController::class, 'ipdAllBedViewerEmergency'])->name('ipd.beds-viewer-list-emergency');

    //Ipd Nurse Station Added By Nazmul 08.09.2021
    Route::get('ipd/nurse-station-receive-request', [IPDController::class, 'nurseStationReceiveRequest'])->name('ipd.nurse-station-receive-request');
    Route::get('ipd/nurse-station-received-patient', [IPDController::class, 'nurseStationReceivedPatient'])->name('ipd.nurse-station-received-patient');
    Route::post('ipd/nurse-station-receive-a-patient', [IPDController::class, 'receivePatientForNurseStation'])->name('ipd.nurse-station-receive-a-patient');
    Route::get('ipd/nurse-station-patient-details/{patient_id?}/{admission_uid?}/{type?}', [IPDController::class, 'nurseStationPatientDetails'])->name('ipd.nurse-station-patient-details');

    Route::get('ipd/nurse-station-vital-details/{patient_id?}/{admission_uid?}/{type?}', [IPDController::class, 'nurseStationVitalDetails'])->name('ipd.nurse-station-vital-details');

    Route::post('ipd/nurse-station-patient-details', [IPDController::class, 'storeNurseStationPatientDetails'])->name('ipd.store-received-patient-clinical-info');
    Route::post('ipd/nurse-station-vital-store', [IPDController::class, 'nurseStationVitalStore'])->name('ipd.nurse-station-vital-store');
    Route::get('patient-treatment-print/{prescription?}/{admission?}/{patient?}', [IPDController::class, 'patientTreatmentPrint'])->name('ipd.patient-treatment-print');

    //IPD NICU
    Route::get('ipd/nicu-station-receive-request', [IPDController::class, 'nicuStationReceiveRequest'])->name('ipd.nicu-station-receive-request');
    Route::get('ipd/nicu-station-received-patient', [IPDController::class, 'nicuStationReceivedPatient'])->name('ipd.nicu-station-received-patient');
    Route::get('ipd/nicu-station-patient-notes/{patient_id?}/{admission_uid?}/{type?}', [IPDController::class, 'nurseStationPatientNotes'])->name('ipd.nicu-station-patient-notes');
    Route::post('ipd/nicu-notes-store', [IPDController::class, 'nicuNotesStore'])->name('ipd.nicu-notes-store');
    Route::get('ipd/nicu-notes-edit/{id}', [IPDController::class, 'nicuNotesEdit'])->name('ipd.nicu-notes-edit');
    Route::post('ipd/upadte-nicu', [IPDController::class, 'upadteNicu'])->name('ipd.upadte-nicu');
    Route::get('ipd/nicu-notes-print/{id}', [IPDController::class, 'nicuNotesPrint'])->name('ipd.nicu-notes-print');
    Route::post('ipd/delete-nicu', [IPDController::class, 'deleteNicu'])->name('ipd.delete-nicu');

    //IPD ICU
    Route::get('ipd/icu-station-receive-request', [IPDController::class, 'icuStationReceiveRequest'])->name('ipd.icu-station-receive-request');
    Route::get('ipd/icu-station-received-patient', [IPDController::class, 'icuStationReceivedPatient'])->name('ipd.icu-station-received-patient');
    Route::post('ipd/update-assign-bed', [IPDController::class, 'updateAssignBed'])->name('ipd.update-assign-bed');
    Route::post('ipd/remove-medicine', [OTController::class, 'removeMedicine'])->name('ipd.medicine-remove');
    Route::get('ipd/medicine-dose-edit/{med_id?}', [OTController::class, 'editMedicineDose'])->name('ipd.medicine-dose-edit');
    Route::post('ipd/medicine-dose-edit-save', [OTController::class, 'editMedicineDoseSave'])->name('ipd.medicine-dose-edit-save');
    Route::post('ipd/nurse-station-return-receive', [IPDController::class, 'nurseStationReturnReceive'])->name('ipd.nurse-station-return-receive');

    //IPD CCU
    Route::get('ipd/ccu-station-receive-request', [IPDController::class, 'ccuStationReceiveRequest'])->name('ipd.ccu-station-receive-request');
    Route::get('ipd/ccu-station-received-patient', [IPDController::class, 'ccuStationReceivedPatient'])->name('ipd.ccu-station-received-patient');


    // Patient History Form
    Route::get('ipd/patient-history-form/{id?}', [IPDController::class, 'patientHistoryForm'])->name('ipd.patient-history-form');
    Route::post('ipd/patient-history-store', [IPDController::class, 'patientHistoryStore'])->name('ipd.patient-history-store');
    Route::get('ipd/patient-history-print/{id?}', [IPDController::class, 'patientHistoryPrint'])->name('ipd.patient-history-print');

    //Doctor station
    Route::get('ipd/doctor-station-received-patient', [IPDController::class, 'doctorStationReceivedPatient'])->name('ipd.doctor-station-received-patient');
    Route::get('ipd/patient-death-declaration/{admission_id?}', [IPDController::class, 'declarePatientDeathFromDoctorStationPopUp'])->name('ipd.patient-death-declaration');
    Route::post('ipd/patient-death-declaration', [IPDController::class, 'storePatientDeathInfoFromDoctorStationPopUp'])->name('ipd.store-patitent-death-info');
    Route::post('ipd/doctor-station-discharge-a-patient', [IPDController::class, 'dischargePatientFromDoctorStation'])->name('ipd.doctor-station-discharge-a-patient');

    Route::get('ipd/discharge-req-list', [IPDController::class, 'dischargeReqList'])->name('ipd.discharge-req-list');
    Route::get('ipd/sil-dil', [IPDController::class, 'SilDil'])->name('ipd.sil-dil');
    Route::post('ipd/sil-dil', [IPDController::class, 'searchSilDil'])->name('ipd.search-sil-dil');
    Route::post('ipd/sil-dil-print', [IPDController::class, 'print_SilDil'])->name('ipd.print-sil-dil');
    Route::post('ipd/sil-dil/store', [IPDController::class, 'storeSilDil'])->name('ipd.store-sil-dil');
    Route::post('ipd/sil-dil/delete', [IPDController::class, 'deleteSilDil'])->name('ipd.delete-sil-dil');

    Route::get('ipd_case_sheet/{patient_id?}/{admission_id?}', [CaseSheetController::class, 'ipdCaseSheet'])->name('ipd_case_sheet');

    Route::get('ipd/emergency-discharge-req-list', [IPDController::class, 'emergencyDischargeReqList'])->name('emergency.discharge-req-list');
    Route::post('ipd/emergency-discharge-req-list', [IPDController::class, 'searchEmergencyDischargeReqList'])->name('ipd.emergency-discharge-req-list-search');



    // IPD Nurse Station v2
    Route::get('v2/ipd/nurse-station-receive-request', [IPDController::class, 'ipdNurseStation'])->name('v2.ipd.nurse-station-receive-request');
    Route::get('v2/ipd/house-keeping-pt-list', [IPDController::class, 'houseKeepingPtList'])->name('v2.ipd.house-keeping-pt-list');
    Route::post('v2/ipd/nurse-station-receive-patient-request', [IPDController::class, 'getReceivePatient'])->name('v2.ipd.nurse-station-receive-patient-request');
    Route::post('v2/ipd/nurse-station-received-patient', [IPDController::class, 'getReceivedPatient'])->name('v2.ipd.nurse-station-received-patient');
    Route::post('v2/ipd/nurse-station-received-patient-update', [IPDController::class, 'setReceivePatient'])->name('v2.ipd.nurse-station-received-patient-update');

    Route::get('v2/ipd/nurse-station-emergency', [IPDController::class, 'emergencyNurseStation'])->name('v2.ipd.nurse-station-emergency');


    Route::get('v2/ipd/nurse-note/{id}', [IPDController::class, 'ipdNursingNote'])->name('v2.ipd.nurse-note');
    Route::get('daily-medicine-investigation-popup/{patient_id?}/{admission_uid?}', [IPDController::class, 'dailyMedicineInvestigation'])->name('daily-medicine-investigation-popup');
    Route::get('daily-medicine-investigation-chart/{patient_no_pk?}/{admission_no_pk?}/{date?}', [IPDController::class, 'medicineInvestigationChart'])->name('daily-medicine-investigation-chart');
    Route::get('v2/ipd/patient-medicine/{patient_id?}/{admission_uid?}/{type?}', [IPDController::class, 'ipdPatientMedicine'])->name('ipd.patient-medicine');
    Route::get('v2/ipd/patient-nursing-requisition/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNursingRequistion'])->name('ipd.patient-nursing-requisition');
    Route::get('v2/ipd/patient-nursing-requisition-worklist', [IPDController::class, 'ipdNursingRequistionV2'])->name('ipd.patient-nursing-requisition-worklist');

    Route::get('v2/ipd/patient-investigation/{patient_id?}/{admission_uid?}/{type?}', [IPDController::class, 'ipdPatientInvestigation'])->name('ipd.patient-investigation');
    Route::get('v2/ipd-prescription-fresh-orders/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdPrescriptionFreshOrderV1'])->name('v1.ipd-prescription-fresh-orders');


    //for emergency nurse station
    Route::get('v2/ipd/emergency-nurse-note/{id}', [IPDController::class, 'ipdEmergencyNursingNote'])->name('v2.ipd.emergency-nurse-note');




    // IPD patient list for Front desk
    Route::get('v2/ipd/ipd-patient-list-v2', [IPDController::class, 'showIPDReceivedPatients'])->name('v2.ipd.ipd-patient-list-v2');
    Route::post('v2/ipd/get-ipd-patient-list-v2', [IPDController::class, 'getAllIPDReceivedPatients'])->name('v2.ipd.get-ipd-patient-list-v2');


    // Referal Pending
    Route::get('v2/ipd/nurse-station-referal-pending', [IPDController::class, 'pendingReferal'])->name('v2.ipd.nurse-station-referal-pending');
    Route::post('v2/ipd/get-pending-referal-patient', [IPDController::class, 'getPendingReferalPatient'])->name('get-pending-referal-patient');
    // Bed Occupancy Reports

    Route::get('ipd/bed-occupancy-history', [IPDController::class, 'bedOccupancyHistory'])->name('ipd.bed-occupancy-history');
    Route::post('ipd/bed-occupancy-history-data', [IPDController::class, 'bedOccupancyHistoryData'])->name('ipd.bed-occupancy-history-data');
    Route::post('ipd/bed-occupancy-history-print', [IPDController::class, 'bedOccupancyHistoryPrint'])->name('ipd.bed-occupancy-history-print');

    Route::get('ipd/bed-occupancy-ratio', [IPDController::class, 'bedOccupancyRatio'])->name('ipd.bed-occupancy-ratio');
    Route::post('ipd/bed-occupancy-ratio-data', [IPDController::class, 'bedOccupancyRatioData'])->name('ipd.bed-occupancy-ratio-data');
    Route::post('ipd/bed-occupancy-ratio-print', [IPDController::class, 'bedOccupancyRatioPrint'])->name('ipd.bed-occupancy-ratio-print');


    //Admitted Patient Summary
    Route::get('ipd/admitted/patient', [AdmittedPatientSummary::class, 'index'])->name('ipd.admitted.patient');

    Route::post('housekeeping-charge/{admission_no_pk?}/{patient_no_fk?}/{payable?}', [IPDController::class, 'applyingHouseKeepingCharge'])->name('ipd.housekeeping-charge');


    // All Report 19.7.2022
    Route::get('ipd-patient-report', [IPDController::class, 'ipdPatientReport'])->name('ipd.patient-report');
    Route::post('ipd-patient-report-search', [IPDController::class, 'ipdPatientReportList'])->name('ipd.patient-report-search');
    Route::post('ipd-patient-report-pdf', [IPDController::class, 'ipdPatientReportPdf'])->name('ipd.patient-report-pdf');
    Route::post('ipd-patient-payment-report-pdf', [IPDController::class, 'ipdPatientPaymentReportPdf'])->name('ipd.patient-payment-report-pdf');
    Route::post('ipd-patient-dept-wise-report-pdf', [IPDController::class, 'ipdPatientDeptWiseReportPdf'])->name('ipd-patient-dept-wise-report-pdf');


    Route::get('ipd-patient-refund-report', [IPDController::class, 'ipdPatientRefundReport'])->name('ipd.patient-refund-report');
    Route::get('ipd-patient-due-report', [IPDController::class, 'ipdPatientDueReport'])->name('ipd.patient-due-report');
    Route::post('ipd-patient-refund-due-report-search', [IPDController::class, 'ipdPatientRefundDueReportList'])->name('ipd.patient-refund-due-report-search');
    Route::post('ipd-patient-refund-due-report-pdf', [IPDController::class, 'ipdPatientRefundDueReportPdf'])->name('ipd.patient-refund-due-report-pdf');


    Route::get('ipd-patient-referral-wise-report', [IPDController::class, 'ipdPatientReferralReport'])->name('ipd.patient-referral-wise-report');
    Route::get('ipd-patient-consulatant-wise-report', [IPDController::class, 'ipdPatientConsultantReport'])->name('ipd.patient-consultant-wise-report');
    Route::post('ipd-patient-referral-consultant-wise-report-search', [IPDController::class, 'ipdPatientRefConReportList'])->name('ipd.patient-referral-consultant-report-search');
    Route::post('ipd-patient-referral-consultant-report-pdf', [IPDController::class, 'ipdPatientRefConReportPdf'])->name('ipd.patient-referral-consultant-report-pdf');


    Route::get('department-wise-patient-report', [PcrmController::class, 'deptWisePatientReport'])->name('dept-wise-patient-report');
    Route::get('ipd/patient-wise-invoice-print/{admission_id?}', [IPDController::class, 'patWiseAdmission'])->name('ipd.patient-wise-invoice-print');

    // Ipd Visit fee Doctor
    Route::get('ipd/indoor/patient/visit/report', [IPDController::class, 'ipdIndoorPatientReport'])->name('ipd.indoor-patient-report');
    Route::post('ipd/indoor/patient/visit/report-report-search', [IPDController::class, 'ipdIndoorPatientReportList'])->name('ipd.indoor-patient-report-report-search');
    Route::post('ipd/indoor-patient-report-pdf', [IPDController::class, 'ipdIndoorPatientReportPdf'])->name('ipd.indoor-patient-report-pdf');


    // Certificates
    Route::get('ipd/patient-birth-certificate-report/{admission_id?}', [CertificateController::class, 'patBirthCertificate'])->name('patient-birth-certificate-report');
    Route::post('ipd/patient-birth-certificate-report/store', [CertificateController::class, 'patBirthCertificatestore'])->name('birth-certificate-store');
    Route::get('ipd/patient-birth-certificate-report/print/{certificate_id?}/{admission_id?}', [CertificateController::class, 'patBirthCertificatePrint'])->name('patient-birth-certificate-report-print');

    Route::get('ipd/patient-death-certificate-report/{admission_id?}', [CertificateController::class, 'patDeathCertificate'])->name('patient-death-certificate-report');
    Route::post('ipd/patient-death-certificate-report/store', [CertificateController::class, 'patDeathCertificatestore'])->name('death-certificate-store');
    Route::get('ipd/patient-death-certificate-report/print/{certificate_id?}/{admission_id?}', [CertificateController::class, 'patDeathCertificatePrint'])->name('patient-death-certificate-report-print');

    Route::post('ipd/ipd-service-billing', [IPDBillingController::class, 'ipdServiceBilling'])->name('ipd.ipd-service-billing');

    Route::get('ipd/pat-vitals-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'patVitalsReport'])->name('ipd.pat-vitals-report');

    //new reports
    Route::get('ipd/nicu-vitals-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'nicuVitalsReport'])->name('ipd.nicu-vitals-report');
    //end reports

    Route::get('ipd/pat-consultant-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'patConsultantReport'])->name('ipd.pat-consultant-report');

    Route::get('ipd/medication-list/{patient_no_fk?}/{admission_id?}', [IPDMedicationController::class, 'medicationList'])->name('ipd.medication-list');

    Route::get('ipd/medication-pop-up/{admission_no?}/{med_no?}/{prescribed_med_adm_no_pk?}', [IPDMedicationController::class, 'medicationPopUp'])->name('ipd.medication-pop-up');

    Route::post('ipd/store-medication-pop-up', [IPDMedicationController::class, 'storeMedicationPopUp'])->name('ipd.store-medication-pop-up');
    Route::get('ipd/pat-medication-chart-report/{patient_no_fk?}/{admission_id?}', [IPDMedicationController::class, 'patMedicationChartReport'])->name('ipd.pat-medication-chart-report');

    Route::get('ipd/pat-temperature-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'patTemperatureReport'])->name('ipd.pat-temperature-report');

    Route::get('ipd/nurse-round-list-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'nurseRoundListReport'])->name('ipd.nurse-round-list-report');

    Route::get('ipd/patient-intake-output-chart/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'patietnIntakeOutputChart'])->name('ipd.patient-intake-output-chart');

    Route::get('ipd/supporting-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'supportingReport'])->name('ipd.supporting-report');

    Route::get('ipd/breast-feeding-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'breastFeedingReport'])->name('ipd.breast-feeding-report');

    Route::get('ipd/cbg-report/{patient_no_fk?}/{admission_id?}', [IPDReportController::class, 'cbgreport'])->name('ipd.cbg-report');

    Route::get('ipd-intake-output/{patient_id}/{admission_uid}', [IPDIntakeOutputController::class, 'index'])->name('ipd-intake-output.index');

    Route::post('ipd-intake-output-store', [IPDIntakeOutputController::class, 'store'])->name('ipd-intake-output.store');

    Route::get('ipd/ipd-supporting-form/{patient_id}/{admission_uid}', [IPDIntakeOutputController::class, 'ipdSupportingForm'])->name('ipd.ipd-supporting-form');

    Route::get('ipd/supporting-pop-up/{admission_no?}/{patient_no?}/{chart_no_pk?}', [IPDIntakeOutputController::class, 'ipdSupportingPopUp'])->name('ipd.supporting-pop-up');

    Route::post('ipd/ipd-supproting-store', [IPDIntakeOutputController::class, 'ipdSupprotingStore'])->name('ipd.ipd-supproting-store');

    Route::get('ipd/breast-feeding-form/{patient_id}/{admission_uid}', [IPDIntakeOutputController::class, 'breastFeedingForm'])->name('ipd.breast-feeding-form');

    Route::post('ipd/breast-feeding-store', [IPDIntakeOutputController::class, 'breastFeedingStore'])->name('ipd.breast-feeding-store');

    Route::get('ipd/cbg-form/{patient_id}/{admission_uid}', [IPDIntakeOutputController::class, 'cbgForm'])->name('ipd.cbg-form');

    Route::post('ipd/cbg-form-store', [IPDIntakeOutputController::class, 'cbgFormStore'])->name('ipd.cbg-form-store');

    Route::get('ipd/ipd-intake-output-pop-up/{admission_no?}/{patient_no?}/{inoutchart_no_pk?}', [IPDIntakeOutputController::class, 'ipdIntakeOutputPopUp'])->name('ipd.ipd-intake-output-pop-up');

    Route::get('ipd/patient-daily-followup-statement/{patient_no_fk?}/{admission_id?}/{date?}', [IPDReportController::class, 'patientDailyFollowupStatement'])->name('ipd.patient-daily-followup-statement');

    Route::get('ipd-daily-followup/{patient_no_fk?}/{admission_id?}', [IPDDailyFollowupController::class, 'index'])->name('ipd.daily-followup');
    Route::get('v1/ipd-daily-followup/{patient_no_fk?}/{admission_id?}', [IPDDailyFollowupController::class, 'indexV2'])->name('v1.ipd.daily-followup');



    Route::post('ipd-daily-followup-store', [IPDDailyFollowupController::class, 'store'])->name('ipd-daily-followup.store');

    Route::get('ipd-daily-followup-list', [IPDDailyFollowupController::class, 'followList'])->name('ipd-daily-followup-list');
    Route::post('ipd-daily-followup-list-search', [IPDDailyFollowupController::class, 'followListSearch'])->name('ipd-daily-followup-list-search');

    Route::get('ipd-input-diabetic/{patient_no_fk?}/{admission_id?}', [IPDDiabeticController::class, 'index'])->name('ipd.input-diabetic');
    Route::post('ipd-input-diabetic', [IPDDiabeticController::class, 'store'])->name('ipd-input-diabetic.store');


    Route::get('ipd-diabetic-chart-pdf/{patient_no_fk?}/{admission_id?}', [IPDDiabeticController::class, 'ipdDiabeticChartPDF'])->name('ipd.diabetic-chart-pdf');

    Route::get('ipd-input-diet/{patient_no_fk?}/{admission_id?}', [IPDDietController::class, 'index'])->name('ipd.input-diet');
    Route::post('ipd-input-diet', [IPDDietController::class, 'store'])->name('ipd-input-diet.store');


    Route::get('ipd-diet-chart-pdf/{patient_no_fk?}/{admission_id?}', [IPDDietController::class, 'ipdDietChartPDF'])->name('ipd.diet-pdf');

    Route::get('ipd-input-oxygen-inhaler/{patient_no_fk?}/{admission_id?}', [IPDOxyGenInhalerController::class, 'index'])->name('ipd.input-oxygen-inhaler');
    Route::post('ipd-input-oxygen-inhaler', [IPDOxyGenInhalerController::class, 'store'])->name('ipd-input-oxygen-inhaler.store');

    Route::get('ipd-oxygen-inhaler-chart-pdf/{patient_no_fk?}/{admission_id?}', [IPDOxyGenInhalerController::class, 'ipdOxygenInhalderChartPDF'])->name('ipd.oxygen-inhaler-pdf');
    Route::get('ipd.doctor-patient-visit/{patient_no_fk?}/{admission_id?}', [IPDOxyGenInhalerController::class, 'ipdDoctorPatientVistPDF'])->name('ipd.doctor-patient-visit');

    Route::get('ipd/admission-label-print/{admission_id?}', [IPDController::class, 'ipdLabelPrint'])->name('ipd.admission-label-print');


    Route::get('ipd/anaesthetic-record-form/{patient_id?}/{reff_no?}', [IPDController::class, 'anaestheticRecordForm'])->name('ipd.anaesthetic-record-form');
    Route::get('ipd/operation-note-form/{patient_id?}/{reff_no?}', [IPDController::class, 'operationForm'])->name('ipd.operation-note-form');
    Route::get('ipd/pre-anesthetic-checkup-form/{patient_id?}/{refNo?}', [IPDController::class, 'preAnestheticCheckupForm'])->name('ipd.pre-anesthetic-checkup-form');
    Route::get('ipd/pre-anesthetic-patient-checkup-form/{patient_id?}/{refNo?}', [IPDController::class, 'preAnestheticPatientCheckupForm'])->name('ipd.pre-anesthetic-patient-checkup-form');
    Route::get('ipd/post-anesthetic-checkup-form/{patient_id?}/{reff_no?}', [IPDController::class, 'postAnestheticCheckupForm'])->name('ipd.post-anesthetic-checkup-form');
    Route::get('ipd/pre-operative-checklist-form/{patient_id?}/{refNo?}', [IPDController::class, 'preOperativeChecklistForm'])->name('ipd.pre-operative-checklist-form');
    Route::get('ipd/pre-operative-checklist/{admission_id?}/{patient_no_fk?}', [IPDController::class, 'preOperativeChecklist'])->name('ipd.pre-operative-checklist');
    Route::get('ipd/pre-operative-checklist-patient-form/{patient_id?}/{refNo?}', [IPDController::class, 'preOperativeChecklistPatientForm'])->name('ipd.pre-operative-checklist-patient-form');
    Route::get('ipd/high-risk-consent-form/{patient_id?}/{refNo?}', [IPDController::class, 'highRiskConsentForm'])->name('ipd.high-risk-consent-form');
    Route::get('ipd/anaesthetic-record-pdf/{patient_id?}/{refNo?}', [IPDController::class, 'anaestheticRecordPDF'])->name('ipd.anaesthetic-record-pdf');
    Route::get('ipd/operation-note-pdf/{admission_id?}/{refNo?}', [IPDController::class, 'operationPDF'])->name('ipd.operation-note-pdf');
    Route::get('ipd/high-risk-consent-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'highRiskConsentPDF'])->name('ipd.high-risk-consent-pdf');
    Route::get('ipd/high-risk-consent-bangla-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'highRiskConsentBanglaPDF'])->name('ipd.high-risk-consent-bangla-pdf');
    Route::get('ipd/pre-operative-checklist-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'preOperativeChecklistPDF'])->name('ipd.pre-operative-checklist-pdf');
    Route::get('ipd/pre-operative-checklist-print/{admission_id?}/{patient_no_fk?}', [IPDController::class, 'preOperativeChecklistPrint'])->name('ipd.pre-operative-checklist-print');
    Route::get('ipd/post-operative-checklist-pdf/{admission_id?}/{refNo?}', [IPDController::class, 'postAnestheticCheckuplistPDF'])->name('ipd.post-operative-checklist-pdf');
    Route::get('ipd/pre-anesthetic-checkup-pdf/{patient_id?}/{refNo?}', [IPDController::class, 'preAnestheticCheckupPDF'])->name('ipd.pre-anesthetic-checkup-pdf');
    Route::get('ipd/pre-anesthetic-patient-checkup-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'preAnestheticPatientCheckupPDF'])->name('ipd.pre-anesthetic-patient-checkup-pdf');
    Route::get('ipd/pre-anesthetic-patient-checkup-doc-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'preAnestheticPatientCheckupDocPDF'])->name('ipd.pre-anesthetic-patient-checkup-doc-pdf');
    Route::post('anaesthetic-record-store', [IPDController::class, 'anaestheticRecordStore'])->name('anaesthetic-record-store');
    Route::post('pre-anesthetic-checkup-store', [IPDController::class, 'preAnestheticCheckupStore'])->name('pre-anesthetic-checkup-store');
    Route::post('pre-anesthetic-patient-checkup-store', [IPDController::class, 'preAnestheticPatientCheckupStore'])->name('pre-anesthetic-patient-checkup-store');
    Route::post('post-anesthetic-checkup-store', [IPDController::class, 'postAnestheticCheckupStore'])->name('post-anesthetic-checkup-store');
    Route::post('anaesthetia-referral-store', [IPDController::class, 'anaestheTiaReferralStore'])->name('anaesthetia-referral-store');
    Route::post('operation-note-store', [IPDController::class, 'operationNoteStore'])->name('operation-note-store');
    Route::post('high-risk-consent-store', [IPDController::class, 'highRiskConsentStore'])->name('high-risk-consent-store');
    Route::post('pre-operative-checklist-store', [IPDController::class, 'preOperativeChecklistStore'])->name('pre-operative-checklist-store');

    Route::get('ipd/nutritional-assessment-form/{admission_id?}', [IPDController::class, 'nutritionAssessmentForm'])->name('ipd.nutritional-assessment-form');


    //IPDCancell
    Route::get('ipd-phr-bill-cancel', [IPDBillingController::class, 'billingCancelation'])->name('ipd.phr-bill-cancel');
    Route::get('ipd/get-billing-cancel-invoice-list', [IPDBillingController::class, 'get_billing_cancel_invoice_list'])->name("ipd.get-billing-cancel-invoice-list");
    Route::post('ipd/store-cancelation', [IPDBillingController::class, 'store_cancelation'])->name("ipd.store_cancelation");

    //IPD Bill Adjustment

    Route::post('ipd/invoice-adjustment', [IPDBillingController::class, 'ipdInvoiceAdjustment'])->name('ipd.invoice-adjustment');

    Route::get('item/itemprevilegesetup', [IPDController::class, 'userItemPrevilegeSetup'])->name('item.useritemprevilegesetup');

    //Inform report
    Route::get('inform-report', [IPDController::class, 'informReport'])->name('inform-report');
    Route::post('inform-report-search', [IPDController::class, 'informReportList'])->name('inform-report-search');
    Route::post('inform-report-pdf', [IPDController::class, 'informReportPdf'])->name('inform-report-pdf');


    Route::get('ipd-input-cafeteria/{patient_no_fk?}/{admission_id?}', [IPDDietController::class, 'cafeteria'])->name('ipd.input-cafeteria');
    Route::post('ipd-input-cafeteria', [IPDDietController::class, 'cafeteriaStore'])->name('ipd-input-cafeteria.store');
    Route::get('ipd-cafeteria-chart-pdf/{patient_no_fk?}/{admission_id?}', [IPDDietController::class, 'cafeteriaChart'])->name('ipd.cafeteria-pdf');


    //Inform report
    Route::get('cafeteria-report', [IPDController::class, 'cafeteriaReport'])->name('cafeteria-report');
    Route::post('cafeteria-report-search', [IPDController::class, 'cafeteriaReportList'])->name('cafeteria-report-search');
    Route::post('cafeteria-report-pdf', [IPDController::class, 'cafeteriaReportPdf'])->name('cafeteria-report-pdf');
    //Inform report
    Route::get('Acceptance-form', [IPDController::class, 'acceptForm'])->name('Acceptance-form');
    Route::get('acceptance-form-data/{id?}', [IPDController::class, 'acceptFormData'])->name('Acceptance-form-data');

    //lohs report
    Route::get('lohs-report', [IPDController::class, 'lohsReport'])->name('lohs-report');
    Route::post('lohs-report-search', [IPDController::class, 'lohsReportList'])->name('lohs-report-search');
    Route::post('lohs-report-pdf', [IPDController::class, 'lohsReportPdf'])->name('lohs-report-pdf');


    Route::get('ipd/back-to-admission', [IPDController::class, 'backToadmission'])->name('ipd-back-to-admission');
    Route::get('ipd/admission-discharge-return-data/{id?}', [IPDController::class, 'backToadmissionID'])->name('ipd.admission-discharge-return-data');
    Route::post('return-to-admission/{id?}', [IPDController::class, 'returnToAdmission'])->name('return-to-admission');


    // *******cleaning Menu ******
    Route::get('ipd/ipd-bed-discharge-by-cleaner', [IPDController::class, 'ipdBedDischargeByCleaner'])->name('ipd.ipd-bed-discharge-by-cleaner');



    //Inform report
    Route::get('ward-wise-report', [IPDController::class, 'wardWiseReport'])->name('ward-wise-report');
    Route::post('ward-wise-report-search', [IPDController::class, 'wardWiseReportList'])->name('ward-wise-report-search');
    Route::post('ward-wise-report-pdf', [IPDController::class, 'wardWiseReportPdf'])->name('ward-wise-report-pdf');

    Route::get('ipd/vitals/data/{id?}', [IPDController::class, 'vitalsData'])->name('ipd.vitals/data');

    //opd admission report
    Route::get('opd-admission-report', [IPDController::class, 'opdAdmissionReport'])->name('opd-admission-report');
    Route::post('opd-admission-report-search', [IPDController::class, 'opdAdmissionReportList'])->name('opd-admission-report-search');
    Route::post('opd-admission-report-pdf', [IPDController::class, 'opdAdmissionReportPdf'])->name('opd-admission-report-pdf');

    //IPD Invoice report
    Route::get('opd-invoice-wise-report', [IPDController::class, 'ipdInvoiceReport'])->name('opd-invoice-wise-report');
    Route::post('opd-invoice-wise-report-search', [IPDController::class, 'ipdInvoiceReportList'])->name('opd-invoice-wise-report-search');
    Route::post('opd-invoice-wise-report-pdf', [IPDController::class, 'ipdInvoiceReportPdf'])->name('opd-invoice-wise-report-pdf');

    //Bed Transfer report
    Route::get('bed-transfer-report', [IPDController::class, 'bedTransferReport'])->name('bed-transfer-report');
    Route::post('bed-transfer-report-search', [IPDController::class, 'bedTransferReportList'])->name('bed-transfer-report-search');
    Route::post('bed-transfer-report-pdf', [IPDController::class, 'bedTransferReportPdf'])->name('bed-transfer-report-pdf');


    // New Nurse Station
    Route::get('v2.ipd-input-diet/{patient_no_fk?}/{admission_id?}', [IPDDietController::class, 'dietRequest'])->name('v2.ipd.input-diet');
    Route::post('v2.ipd-input-diet', [IPDDietController::class, 'dietStore'])->name('v2.ipd-input-diet.store');
    Route::delete('v2.ipd-diet-request/{id}', [IPDDietController::class, 'destroy'])->name('diet-request.destroy');

    Route::post('v2/ipd/doctor-station-discharge-patient', [IPDController::class, 'dischargeRequest'])->name('v2.ipd.patient-discharge-request');
    Route::get('v2/ipd/patient-history-form/{id?}', [IPDController::class, 'patientHistoryFormV2'])->name('v2.ipd.patient-history-form');
    Route::post('v2/ipd/patient-history-store', [IPDController::class, 'patientHistoryStoreV2'])->name('v2.ipd.patient-history-store');

    Route::get('v2/ot-note/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'otNote'])->name('v2.ot-note');
    Route::get('v2.ipd/assign-bed/{adms_no?}', [IPDController::class, 'assignBedV2'])->name('v2.ipd.assign-bed');

    Route::post('v2/ipd/update-assign-bed', [IPDController::class, 'updateAssignBedV2'])->name('v2.ipd.update-assign-bed');
    Route::post('v2/ipd/update-assign-bed-active-free', [IPDController::class, 'updateAssignBedActiveFreeV2'])->name('v2.ipd.update-assign-bed-active-free');
    Route::post('v2/ipd/get-glucose-info', [IPDController::class, 'getGlucoseInfo'])->name('v2.ipd.get-glucose-info');
    Route::post('v2/ipd/get-bed-list-by-ward', [IPDController::class, 'getBedByWordWise'])->name('v2.ipd.get-bed-list-by-ward');

    Route::post('v2/ipd/bed-bill-generate', [IPDController::class, 'billGenerate'])->name('v2.ipd.bed-bill-generate');

    Route::get('v2/ipd/patient-death-certificate-report/{admission_id?}', [CertificateController::class, 'patDeathCertificateV2'])->name('v2.patient-death-certificate-report');
    // Route::post('ipd/patient-death-certificate-report/store', [CertificateController::class, 'patDeathCertificatestore'])->name('death-certificate-store');
    // Route::get('ipd/patient-death-certificate-report/print/{certificate_id?}/{admission_id?}', [CertificateController::class, 'patDeathCertificatePrint'])->name('patient-death-certificate-report-print');



    Route::post('v2/ipd/nurse-station-patient-details', [IPDController::class, 'storeNurseStationPatientDetailsV2'])->name('v2.ipd.store-received-patient-clinical-info');
    Route::get('v2/ipd/medicine-approval', [IPDController::class, 'medicineApprovel'])->name('v2.ipd.medicine-approval');
    Route::post('v2/ipd/get-medicine-approval', [IPDController::class, 'getMedicineApproval'])->name('v2.ipd.get-medicine-approval');
    Route::post('v2/ipd/medicine-approve-request', [IPDController::class, 'medicineApproveRequest'])->name('v2.ipd.medicine-approve-request');
    Route::get('v2/ipd/get-prescription-wise-pending-medicine/{prescription_id}', [IPDController::class, 'medicinePendingList'])->name('v2.ipd.get-prescription-wise-pending-medicine');
    Route::get('v2/ipd/get-prescription-wise-approved-medicine/{prescription_id}', [IPDController::class, 'medicineApprovedList'])->name('v2.ipd.get-prescription-wise-approved-medicine');

    //Medicine Indent
    Route::post('v2/ipd/get-medicine-indent', [IPDController::class, 'getMedicineIndent'])->name('v2.ipd.get-medicine-indent');
    Route::post('v2/ipd/get-completed-medicine-indent', [IPDController::class, 'getMedicineCompletedIndent'])->name('v2.ipd.get-completed-medicine-indent');

    Route::post('v2/ipd/medicine-indent-request', [IPDController::class, 'medicineIndentRequest'])->name('v2.ipd.medicine-indent-request');
    Route::delete('v2/ipd/medicine-indent-delete/{id}', [IPDController::class, 'medicineIndentDelete'])->name('v2.ipd.medicine-indent-delete');


    Route::get('v2/ipd/get-indent-pharmacy', [IPDController::class, 'getMedicineIndentPage'])->name('v2.ipd.get-indent-pharmacy');
    Route::post('v2/ipd/get-medicine-indent-from-pharmacy', [IPDController::class, 'getMedicineIndentFromPharmacy'])->name('v2.ipd.get-medicine-indent-from-pharmacy');


    Route::post('v2/ipd/get-medicine-indent-delivery', [IPDController::class, 'getMedicineIndentDelivery'])->name('v2.ipd.get-medicine-indent-delivery');
    Route::post('v2/ipd/medicine-delivery', [IPDController::class, 'medicineDelivery'])->name('v2.ipd.medicine-delivery');

    // medicine Delivered Complated
    Route::post('v2/ipd/get-medicine-indent-delivered', [IPDController::class, 'getMedicineIndentDelivered'])->name('v2.ipd.get-medicine-indent-delivered');


    Route::get('v2/ipd/get-prescription-wise-pending-medicine-pharmacy/{patmedtran_no_pk}', [IPDController::class, 'medicinePendingListPharmacy'])->name('v2.ipd.get-prescription-wise-pending-medicine-pharmacy');
    Route::get('v2/ipd/get-prescription-wise-pending-medicine-delivered/{med_req_id}', [IPDController::class, 'medicineDelivered'])->name('v2.ipd.get-prescription-wise-pending-medicine-delivered');
    // medicine Delivered Complated
    Route::get('v2/ipd/get-prescription-wise-pending-medicine-delivered-complated/{med_req_id}', [IPDController::class, 'medicineDeliveredComplated'])->name('v2.ipd.get-prescription-wise-pending-medicine-delivered-complated');

    Route::get('v2/ipd/get-prescription-wise-pending-medicine-delivered-receive/{med_req_id}', [IPDController::class, 'medicineDeliveredReceive'])->name('v2.ipd.get-prescription-wise-pending-medicine-delivered-receive');

    Route::post('v2/ipd/medicine-receive', [IPDController::class, 'medicineReceive'])->name('v2.ipd.medicine-receive');

    Route::get('v2/ipd/medicine-receive-request/{id}', [IPDController::class, 'medicineReceiveRequest'])->name('v2.ipd.medicine-receive-request');

    // Medicine Return
    Route::get('v2/ipd/get-patient-wise-medicine-return-request/{patient_no_fk?}/{admission_no_pk?}', [IPDController::class, 'medicinePatientWiseReceive'])->name('v2.ipd.get-patient-wise-medicine-return-request');
    Route::get('v2/ipd/get-patient-wise-medicine-returned-list/{patient_no_fk?}/{admission_no_pk?}', [IPDController::class, 'medicinePatientWiseReturned'])->name('v2.ipd.get-patient-wise-medicine-returned-list');

    // Investigation Indent
    Route::get('v2/ipd/patient-investigation-requisition/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdInvestigationRequistion'])->name('ipd.patient-investigation-requisition');
    Route::post('v2/ipd/get-investigation-indent', [IPDController::class, 'getInvestigationItem'])->name('v2.ipd.get-investigation-indent');
    Route::post('v2/ipd/investigation-indent-request', [IPDController::class, 'InvestigationIndent'])->name('v2.ipd.investigation-indent-request');

    Route::post('v2/ipd/receive-medicine-from-nurse-station', [IPDController::class, 'getMedicineReceiveNS'])->name('v2.ipd.receive-medicine-from-nurse-station');
    Route::post('v2/ipd/received-medicine-from-nurse-station', [IPDController::class, 'getMedicineReceivedNS'])->name('v2.ipd.received-medicine-from-nurse-station');
    Route::post('v2/ipd/medicine-return-consumption', [IPDController::class, 'medicineReturnConsumption'])->name('v2.ipd.medicine-return-consumption');
    // Consumption
    Route::post('v2/ipd/consumption-medicine-from-nurse-station', [IPDController::class, 'getMedicineConsumptionNS'])->name('v2.ipd.consumption-medicine-from-nurse-station');
    Route::post('v2/ipd/return-medicine-from-nurse-station', [IPDController::class, 'getMedicineReturnedNS'])->name('v2.ipd.return-medicine-from-nurse-station');
    Route::post('v2/ipd/return-medicine-from-pharmacy', [IPDController::class, 'getMedicineReturnPharmacy'])->name('v2.ipd.return-medicine-from-pharmacy');
    Route::post('v2/ipd/returned-medicine-from-pharmacy', [IPDController::class, 'getMedicineReturnedPharmacy'])->name('v2.ipd.returned-medicine-from-pharmacy');
    Route::post('v2/ipd/medicine-return-receive', [IPDController::class, 'medicineReturnReceive'])->name('v2.ipd.medicine-return-receive');

    Route::get('v2/ipd/patient-assessment/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdPatientAssesment'])->name('ipd.patient-assesment');
    Route::get('v2/ipd/medicine-discontinue-request-popup/{prescription_med_no_pk?}', [IPDController::class, 'medicineDiscontinueStatusPopUp'])->name('v2.ipd.medicine-discontinue-request-popup');
    Route::post('v2/ipd/medicine-discontinue-request', [IPDController::class, 'medicineDiscontinueStatus'])->name('v2.ipd.medicine-discontinue-request');
    Route::post('v2/ipd/medicine-discontinue-request-update/{med_id?}', [IPDController::class, 'medicineDiscontinueStatusUpdate'])->name('v2.ipd.medicine-discontinue-request-update');



    Route::post('v2/ipd/assesment-save', [IPDController::class, 'assesmentSave'])->name('v2.ipd.assesment-save');
    Route::post('v2/ipd/nurse-assesment-save', [IPDController::class, 'nurseAssesmentSave'])->name('v2.ipd.nurse-assesment-save');

    Route::get('v2/ipd/download-patient-assesment/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadPatientAssesment'])->name('v2.ipd.download-patient-assesment');
    Route::get('v2/ipd/download-patient-daily-followup/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadPatientDailyFollowup'])->name('v2.ipd.download-patient-daily-followup');
    Route::get('v2/ipd/download-referral-doctor/{consultrecord_no_pk?}', [IPDController::class, 'downloadReferralDoctor'])->name('v2.ipd.download-referral-doctor');
    Route::post('v2/ipd/get-referal-info', [IPDController::class, 'getReferInfo'])->name('v2.ipd.get-referal-info');
    Route::get('v2/reply-to-referral/{consultrecord_no_pk?}', [IPDController::class, 'replyToReferral'])->name('v2.reply-to-referral');


    // Nurse initial assesment


    Route::get('v2/ipd/nurse-assessment/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesment'])->name('ipd.nurse-assesment');
    Route::get('v2/ipd/download-nurse-assesment/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssesment'])->name('v2.ipd.download-nurse-assesment');
    Route::get('v2/ipd/download-nurse-assesment-neonates/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssesmentNeonates'])->name('v2.ipd.download-nurse-assesment-neonates');
    Route::get('v2/ipd/download-nurse-assesment-adult/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssesmentAdult'])->name('v2.ipd.download-nurse-assesment-adult');
    Route::get('v2/ipd/download-nurse-assesment-paediatric-icu/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssesmentPaediatricIcu'])->name('v2.ipd.download-nurse-assesment-paediatric-icu');
    Route::get('v2/ipd/download-nurse-assesment-paediatric/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssesmentPaediatric'])->name('v2.ipd.download-nurse-assesment-paediatric');
    Route::get('v2/ipd/download-discharge-lama/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadDischargeLAMA'])->name('v2.ipd.download-discharge-lama');
    Route::get('v2/ipd/download-fall-risk/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadFallRisk'])->name('v2.ipd.download-fall-risk');

    Route::post('v2/ipd/nursing-assesment-save', [IPDController::class, 'nursingAssesmentSave'])->name('v2.ipd.nursing-assesment-save');
    Route::get('v2/ipd/nurse-assessment-paediatric-icu/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesmentPaediatricIcu'])->name('ipd.nurse-assessment-paediatric-icu');
    Route::get('v2/ipd/nurse-assessment-paediatric/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesmentPaediatric'])->name('ipd.nurse-assessment-paediatric');
    Route::get('v2/ipd/nurse-assessment-adult/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesmentAdult'])->name('ipd.nurse-assessment-adult');
    Route::get('v2/ipd/nurse-assessment-neonates/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesmentNeonates'])->name('ipd.nurse-assessment-neonates');
    //emrgency
    Route::get('v2/ipd/nurse-assessment-emergency/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdNurseAssesmentEmergency'])->name('ipd.nurse-assessment-emergency');
    Route::post('v2/ipd/save-nurse-assessment-emergency', [IPDController::class, 'saveNurseAssessmentEmergency'])->name('v2.ipd.save-nurse-assessment-emergency');
    Route::get('v2/ipd/download-nurse-assessment-emergency/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseAssessmentEmergency'])->name('v2.ipd.download-nurse-assessment-emergency');
    //pain assessment
    Route::get('ipd/pain-assessment/{patient_id?}/{admission_uid?}', [IPDController::class, 'painAssessment'])->name('ipd.pain-assessment');
    Route::post('v2/ipd/save-pain-assessment', [IPDController::class, 'savePainAssessment'])->name('v2.ipd.save-pain-assessment');
    Route::get('v2/ipd/download-pain-assessment/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadPainAssessment'])->name('v2.ipd.download-pain-assessment');
    //invasive lines
    Route::get('v2/ipd/invasive-lines-tubes-drains/{patient_id?}/{admission_uid?}', [IPDController::class, 'invasiveLinesTubesDrains'])->name('v2.ipd.invasive-lines-tubes-drains');
    Route::post('v2/ipd/save-invasive-lines', [IPDController::class, 'saveInvasiveLines'])->name('v2.ipd.save-invasive-lines');
    Route::get('v2/ipd/download-invasive-lines/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadInvasiveLines'])->name('v2.ipd.download-invasive-lines');


    // Refer Doctor
    Route::get('ipd/refer-doctor/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'referDoctor'])->name('ipd.refer-doctor');
    Route::post('ipd/save-referral-doctor', [IPDController::class, 'referDoctorSave'])->name('ipd.save-referral-doctor');
    Route::post('ipd/save-referral-doctor-reason', [IPDController::class, 'referDoctorSaveReason'])->name('ipd.save-referral-doctor-reason');
    // Consultation Note
    Route::get('consultation-note/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'consultationNote'])->name('ipd.consultation-note');
    Route::get('nurse-special-note/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'nurseNote'])->name('ipd.nurse-special-note');
    Route::get('problem-list/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'problemlistform'])->name('ipd.problem-list-note');
    Route::post('ipd/save-nurse-special-note', [IPDController::class, 'nurseSpecialNoteStore'])->name('ipd.save-nurse-special-note');
    Route::post('ipd/save-problem-list-note', [IPDController::class, 'problemListNoteStore'])->name('ipd.save-problem-list-note');
    Route::get('ipd/download-nurse-special-notes/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNurseSpecialNotes'])->name('v2.ipd.download-nurse-Special-notes');
    Route::get('ipd/download-problem-list-notes/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'problemListNotePdf'])->name('ipd.problem-list-notes-pdf');
    Route::get('glucose-monitoring-chart/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'glucoseChart'])->name('ipd.glucose-monitoring-chart');
    Route::get('intake-output-chart/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'intakeOutputChart'])->name('ipd.intake-output-chart');
    Route::post('ipd/save-follow-up-notes', [IPDController::class, 'followUpNotes'])->name('ipd.save-follow-up-notes');
    Route::get('ipd/download-follow-up-notes/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadFollowUpNotes'])->name('v2.ipd.download-follow-up-notes');

    //ot procedure note
    Route::get('ot-procedure-note/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'otProcedureNote'])->name('ipd.ot-procedure-note');
    Route::post('ipd/save-ot-procedure-note', [IPDController::class, 'otProcedureNoteStore'])->name('ipd.save-ot-procedure-note');
    Route::get('ipd/download-ot-procedure-notes/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadOtProcedureNote'])->name('v2.ipd.download-ot-procedure-notes');

    // OT Requsition
    Route::get('ot-requsition/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'otRequsition'])->name('ipd.ot-requsition');
    Route::get('consultant-bill/{patient_no_fk?}/{admission_id?}/{type?}', [IPDController::class, 'ipdConsultantBill'])->name('ipd.consultant-bill');
    Route::post('ipd/consultant-bill-generate', [IPDController::class, 'ipdConsultantBillGenerate'])->name('ipd.consultant-bill-generate');
    Route::post('ipd/save-ot-requsition', [IPDController::class, 'saveOT'])->name('ipd.save-ot-requsition');
    Route::post('v2/ipd/get-ot-requsition', [IPDController::class, 'getOTInfo'])->name('v2.ipd.get-ot-requsition');
    // OT
    Route::get('v2/ipd/ot-requsition', [IPDController::class, 'otRequsitionList'])->name('v2.ipd.ot-requsition');
    Route::post('v2/ipd/get-requisition-list', [IPDController::class, 'searchOTRequisition'])->name('v2.ipd.get-requisition-list');
    Route::post('v2/ipd/get-ot-status', [IPDController::class, 'searchOTStatus'])->name('v2.ipd.get-ot-status');

    // OT Slot
    Route::post('v2/ipd/get-ot-slot', [IPDController::class, 'getOTList'])->name('v2.ipd.get-ot-slot');
    //skin care plan
    Route::get('skin-care-plan/{patient_id?}/{admission_uid?}', [IPDController::class, 'skinCarePlan'])->name('ipd.skin-care-plan');
    Route::post('ipd/save-skin-care', [IPDController::class, 'saveSkinCare'])->name('ipd.save-skin-care');
    Route::post('v2/get-skin-care-info', [IPDController::class, 'skinCareInfo'])->name('v2.get-skin-care-info');
    Route::get('ipd/download-skin-care/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadSkinCare'])->name('v2.ipd.download-skin-care');

    //Nursing care plan
    Route::get('nursing-care-plan/{patient_id?}/{admission_uid?}', [IPDController::class, 'nursingCarePlan'])->name('ipd.nursing-care-plan');
    Route::post('ipd/save-nursing-care-plan', [IPDController::class, 'saveNursingCarePlan'])->name('ipd.save-nursing-care-plan');
    Route::post('v2/get-nursing-care-plan-info', [IPDController::class, 'nursingCareInfo'])->name('v2.get-nursing-care-plan-info');
    Route::get('ipd/download-nursing-care-plan/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadNursingCarePlan'])->name('v2.ipd.download-nursing-care-plan');

    //Patient Movement
    Route::get('patient-movement/{patient_id?}/{admission_uid?}', [IPDController::class, 'patientMovement'])->name('ipd.patient-movement');
    Route::post('ipd/save-patient-movement', [IPDController::class, 'savePatientMovement'])->name('ipd.save-patient-movement');
    Route::post('v2/get-patient-movement-info', [IPDController::class, 'getPatientMovementInfo'])->name('v2.get-patient-movement-info');
    Route::get('ipd/download-patient-movement/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'patientMovementDownload'])->name('v2.ipd.download-patient-movement');

    //Nursing Endorsement
    Route::get('nursing-endorsement/{patient_id?}/{admission_uid?}', [IPDController::class, 'nursingEndorsement'])->name('ipd.nursing-endorsement');
    Route::post('ipd/save-nursing-endorsement', [IPDController::class, 'saveNursingEndorsement'])->name('ipd.save-nursing-endorsement');
    Route::post('v2/get-nursing-endorsement-info', [IPDController::class, 'getNursingEndorsementInfo'])->name('v2.get-nursing-endorsement-info');
    Route::get('ipd/download-nursing-endorsement/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'nursingEndorsementDownload'])->name('v2.ipd.nursing-endorsement');

    // Added New
    Route::get('ipd/anaesthetic-refferal-form/{patient_id?}/{reff_no?}', [IPDController::class, 'anaestheticRefferalForm'])->name('ipd.anaesthetic-refferral-form');
    Route::get('ipd/anaesthetic-refferral-reply-form/{patient_id?}/{reff_no?}', [IPDController::class, 'anaestheticRefferalReplyForm'])->name('ipd.anaesthetic-refferral-reply-form');

    Route::get('ipd/add-msu-item/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'AddMSUITEM'])->name('ipd.add-msu-item');
    Route::post('ipd/save-msu-item', [IPDController::class, 'saveMSUItem'])->name('ipd.save-msu-item');

    Route::get('ipd/patient-discharge-lma-checklist/{patient_id?}/{admission_uid?}', [IPDController::class, 'ipdPatientDischargeCheckList'])->name('ipd.patient-discharge-lma-checklist');
    Route::get('ipd/patient-fall-risk/{patient_id?}/{admission_uid?}', [IPDController::class, 'patientFallRisk'])->name('ipd.patient-fall-risk');
    Route::post('v2/ipd/nursing-discharge-lama-save', [IPDController::class, 'dischargeLAMASave'])->name('v2.ipd.nursing-discharge-lama-save');
    Route::post('v2/ipd/save-patient-fall-risk', [IPDController::class, 'saveFallRisk'])->name('v2.ipd.save-patient-fall-risk');

    Route::post('ipd/save-glucose-chart', [IPDController::class, 'saveGlucoseChart'])->name('ipd.save-glucose-chart');
    Route::get('v2/ipd/download-glucose-chart/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadGlucoseChart'])->name('v2.ipd.download-glucose-chart');
    //Intake - Output Chart
    Route::post('ipd/save-intake', [IPDController::class, 'saveIntake'])->name('ipd.save-intake');
    Route::post('ipd/save-output', [IPDController::class, 'saveOutput'])->name('ipd.save-output');
    Route::post('ipd/ipd.get-intake-info', [IPDController::class, 'getIntakeInfo'])->name('ipd.get-intake-info');
    Route::post('ipd/ipd.get-output-info', [IPDController::class, 'getOutputInfo'])->name('ipd.get-output-info');
    Route::get('ipd/download-intake-output-chart/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadIntakeOutput'])->name('ipd.download-intake-output-chart');
    Route::get('ipd/date-wise-intake-output-chart/{patient_no_pk?}/{admission_no_pk?}/{date?}', [IPDController::class, 'datewiseIntakeOutput'])->name('ipd.date-wise-intake-output-chart');

    // Vitals
    Route::get('v2/ipd/vital-report-generate/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'vitalGenerateReport'])->name('v2.ipd.vital-report-generate');
    Route::get('ipd/vital-entry/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'vitalEntry'])->name('ipd.vital-entry');
    Route::post('ipd/save-vital-entry', [IPDController::class, 'saveVitalEntry'])->name('ipd.save-vital-entry');
    Route::post('ipd/get-vital-info', [IPDController::class, 'getVitalInfo'])->name('ipd.get-vital-info');
    Route::get('ipd/download-vital-report/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadVitalReport'])->name('v2.ipd.download-vital-report');

    Route::get('ipd/intra-operative-nursing-form/{patient_id?}/{reff_no?}', [IPDController::class, 'intraOperativeNursingForm'])->name('ipd.intra-operative-nursing-form');
    Route::get('ipd/intra-operative-nursing-pdf/{patient_id?}/{reff_no?}', [IPDController::class, 'intraOperativeNursingPdf'])->name('ipd.intra-operative-nursing-pdf');
    Route::post('ipd/intra-operative-nursing-save', [IPDController::class, 'intraOperativeNursingSave'])->name('ipd.intra-operative-nursing-save');

    Route::get('ipd/surgical-safety-checklist-form/{patient_id?}/{reff_no?}', [IPDController::class, 'surgicalSafetyChecklistForm'])->name('ipd.surgical-safety-checklist-form');
    Route::post('ipd/store-surgical-safety', [IPDController::class, 'storeSurgicalSafety'])->name('ipd.store-surgical-safety');
    Route::get('ipd/surgical-safety-checklist-form-print/{patient_id?}/{reff_no?}', [IPDController::class, 'surgicalSafetyChecklistFormPrint'])->name('ipd.surgical-safety-checklist-form-print');

    //Recovery Room Nurse Note
    Route::get('ipd/recovery-room-nurses-note-form/{patient_id?}/{reff_no?}', [IPDController::class, 'recoveryRoomNursesNoteForm'])->name('ipd.recovery-room-nurses-note-form');
    Route::post('ipd/recovery-room-nurses-note-store', [IPDController::class, 'storeNursesNote'])->name('ipd.store-recovery-room-nurses-note');
    Route::get('ipd/recovery-room-nurses-note-form-print/{patient_id?}/{reff_no?}', [IPDController::class, 'recoveryRoomNursesNoteExportPDF'])->name('ipd.recovery-room-nurses-note-form-print');

    //IPD DOCTOR SHIFT HANDOVER FORM
    Route::get('ipd/doctor-shift-handover-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'doctorShiftHandoverForm'])->name('ipd.doctor-shift-handover-form');
    Route::post('ipd/doctor-shift-handover-store', [IPDController::class, 'storeDocShiftHandover'])->name('ipd.store-doctor-shift-handover');
    Route::get('ipd/doctor-shift-handover-form-print/{handover_id}/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'doctorShiftHandoverExportPDF'])->name('ipd.doctor-shift-handover-form-print');
    Route::get('ipd/doctor-shift-handover-edit/{handover_id}/{patient_no_fk}/{admission_id}', [IPDController::class, 'doctorShiftHandoverEdit'])->name('ipd.doctor-shift-handover-edit');


    //IPD INVESTIGATION REQUEST FORM
    Route::get('ipd/investigation-request-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'investigationRequestForm'])->name('ipd.investigation-request-form');
    Route::post('ipd/investigation-request-store', [IPDController::class, 'storeInvestigationRequest'])->name('ipd.store-investigation-request');
    Route::get('ipd/investigation-request-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'investigationRequestExportPDF'])->name('ipd.investigation-request-form-print');

    //Consultant Change
    Route::get('ipd/consultant-change/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'consultantChange'])->name('ipd.consultant-change');
    Route::post('ipd/save-consultant-change', [IPDController::class, 'saveConsultant'])->name('ipd.save-consultant-change');

    //ICU Form
     Route::get('ipd/crp-documentation-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'crpDocumentationForm'])->name('icu.crp-doc-form');
     Route::post('ipd/crp-documentation-store', [IPDController::class, 'storeCprDoc'])->name('icu.crp-doc-store');
     Route::get('ipd/cpr-documentation-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'cprDocPDF'])->name('icu.cpr-doc-pdf');
     Route::get('ipd/central-line-insertion-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'centralLineInsertionForm'])->name('icu.central-line-insertion-form');
     Route::post('ipd/central-line-insertion-store', [IPDController::class, 'storecentralLineInsertion'])->name('ipd.central-line-insertion-store');
     Route::get('ipd/central-line-insertion-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'centralLineInsertionPDF'])->name('icu.central-line-insertion-pdf');
     Route::get('ipd/ventilator-associated-events-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'ventilatorAssociatedEventsForm'])->name('icu.ventilator-associated-events-form');
     Route::post('ipd/ventilator-associated-events-store', [IPDController::class, 'storeventilatorAssociatedEvents'])->name('icu.ventilator-associated-events-store');
     Route::get('ipd/ventilator-associated-events-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'ventilatorAssociatedEventsPDF'])->name('icu.ventilator-associated-events-pdf');
     Route::get('progress-note/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'progressNote'])->name('ipd.progress-note');
     Route::post('ipd/save-progress-note', [IPDController::class, 'saveProgressNote'])->name('ipd.save-progress-note');
     Route::get('ipd/download-progress-note/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadProgressNote'])->name('v2.ipd.download-progress-note');
     Route::get('ipd/hemodialysis-record-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'hemodialysisRecordForm'])->name('icu.hemodialysis-record-form');
     Route::post('ipd/hemodialysis-record-store', [IPDController::class, 'storeHemodialysisRecord'])->name('icu.hemodialysis-record-store');
     Route::get('ipd/hemodialysis-record-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'hemodialysisRecordPDF'])->name('icu.hemodialysis-record-pdf');
     Route::get('ipd/icu-referral-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'icuReferralForm'])->name('icu.referral-form');
     Route::post('ipd/icu-referral-store', [IPDController::class, 'storeIcuReferral'])->name('icu.referral-form-store');
     Route::get('ipd/icu-referral-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'icuReferralFormPDF'])->name('icu.referral-form-pdf');
     Route::get('ipd/icu-doc-inhouse-transfer-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'icuDocInhouseTransferForm'])->name('icu.doc-inhouse-transfer-form');
     Route::post('ipd/icu-doc-inhouse-transfer-store', [IPDController::class, 'storeIcuDocInhouseTransfer'])->name('icu.doc-inhouse-transfer-form-store');
     Route::get('ipd/icu-doc-inhouse-transfer-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'icuDocInhouseTransferPDF'])->name('icu.doc-inhouse-transfer-form-pdf');
     Route::get('ipd/icu-critical-test-result/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'criticalTestResult'])->name('icu-critical-test-result');
     Route::post('ipd/save-icu-critical-test-result', [IPDController::class, 'saveCriticalTestResult'])->name('save-icu-critical-test-result');
     Route::get('ipd/download-icu-critical-test-result/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadCriticalTestResult'])->name('download-icu-critical-test-result');
     Route::get('ipd/counseling-form-critical-care/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'counselingFormCriticalCare'])->name('counseling-form-critical-care');
     Route::post('ipd/counseling-form-critical-care-store', [IPDController::class, 'counselingFormCriticalCareSave'])->name('counseling-form-critical-care-store');
     Route::get('ipd/counseling-form-critical-care-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'counselingFormCriticalCarePDF'])->name('counseling-form-critical-care-pdf');
     Route::get('ipd/sicu-investigation-chart/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'sicuInvestigationChart'])->name('sicu-investigation-chart');
     Route::post('ipd/sicu-investigation-chart-store', [IPDController::class, 'sicuInvestigationChartSave'])->name('sicu-investigation-chart-store');
     Route::get('ipd/sicu-investigation-chart-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'sicuInvestigationChartPDF'])->name('sicu-investigation-chart-pdf');
     Route::get('ipd/indwelling-urinary-catheter-checklist/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'indwellingUrinaryCatheterChecklist'])->name('indwelling-urinary-catheter-checklist');
     Route::post('ipd/indwelling-urinary-catheter-checklist-store', [IPDController::class, 'indwellingUrinaryCatheterChecklistSave'])->name('indwelling-urinary-catheter-checklist-store');
     Route::get('ipd/indwelling-urinary-catheter-checklist-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'indwellingUrinaryCatheterChecklistPDF'])->name('indwelling-urinary-catheter-checklist-pdf');
     Route::get('ipd/icu-bundle/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'icuBundleList'])->name('icu-bundle-list');
     Route::get('ipd/doctor-handover-sheet-bundle/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'doctorhandoverbundle'])->name('doctor-handover-bundle');


     // indoor dialysis order
     Route::get('ipd/indoor-dialysis-order/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'IndoorDialysisOrder'])->name('indoor-dialysis-order');
     Route::post('ipd/indoor-dialysis-order-store', [IPDController::class, 'IndoorDialysisOrderSave'])->name('indoor-dialysis-order-store');
     Route::get('ipd/indoor-dialysis-order-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'IndoorDialysisOrderPDF'])->name('indoor-dialysis-order-pdf');

     // blood transfusion reaction form
     Route::get('ipd/blood-transfusion-reaction-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'BloodTransfusionReactionForm'])->name('blood-transfusion-reaction-form');
     Route::post('ipd/blood-transfusion-reaction-form-store', [IPDController::class, 'BloodTransfusionReactionSave'])->name('blood-transfusion-reaction-form-store');
     Route::get('ipd/blood-transfusion-reaction-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'BloodTransfusionReactionPDF'])->name('blood-transfusion-reaction-form-pdf');

     // blood transfusion order
     Route::get('ipd/blood-transfusion-order/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'BloodTransfusionOrder'])->name('blood-transfusion-order');
     Route::post('ipd/blood-transfusion-order-store', [IPDController::class, 'BloodTransfusionOrderSave'])->name('blood-transfusion-order-store');
     Route::get('ipd/blood-transfusion-order-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'BloodTransfusionOrderPDF'])->name('blood-transfusion-order-pdf');

     // BLOOD PRODUCTS TRANSFUSION & MONITORING RECORD
     Route::get('ipd/blood-products-transfusion-monitorig-record/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'BloodProductsTransfusionMonitoringRecord'])->name('blood-products-transfusion-monitorig-record');
     Route::post('ipd/blood-products-transfusion-monitorig-record-store', [IPDController::class, 'BloodProductsTransfusionMonitoringRecordSave'])->name('blood-products-transfusion-monitorig-record-store');
     Route::get('ipd/blood-products-transfusion-monitorig-record-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'BloodProductsTransfusionMonitoringRecordPDF'])->name('blood-products-transfusion-monitorig-record-pdf');

     //CAUTI, INSERTION & MAINTENANCE BUNDLE
     Route::get('ipd/cauti-insertion-maintenance-bundle/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'CautiInsertionMaintenanceBundle'])->name('cauti-insertion-maintenance-bundle');
     Route::post('ipd/cauti-insertion-maintenance-bundle-store', [IPDController::class, 'CautiInsertionMaintenanceBundleSave'])->name('cauti-insertion-maintenance-bundle-store');
     Route::get('ipd/cauti-insertion-maintenance-bundle-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'CautiInsertionMaintenanceBundlePDF'])->name('cauti-insertion-maintenance-bundle-pdf');

     //Initial Cardiac Assessment
     Route::get('ipd/initial-cardiac-assessment/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'InitialCardiacAssessment'])->name('initial-cardiac-assessment');
     Route::post('ipd/initial-cardiac-assessment-store', [IPDController::class, 'InitialCardiacAssessmentSave'])->name('initial-cardiac-assessment-store');
     Route::get('ipd/initial-cardiac-assessment-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'InitialCardiacAssessmentPDF'])->name('initial-cardiac-assessment-pdf');


    // Emergency Discharge Summary:
    Route::get('ipd/emergency-discharge-summary/{patient_id?}/{admission_uid?}', [IPDController::class, 'emergencyDischargeSummary'])->name('ipd.emergency-discharge-summary');
    Route::post('ipd/save-emergency-discharge-summary', [IPDController::class, 'saveEmergencyDischargeSummary'])->name('ipd.save-emergency-discharge-summary');
    Route::get('ipd/download-emergency-discharge-summary/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'downloadEmergencyDischargeSummary'])->name('v2.ipd.download-emergency-discharge-summary');
   //Adult Emergency Department Clinical Bundle
     Route::get('adult-emergency-department-clinical-bundle/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'adultEmergencyDeptClinicalBundle'])->name('adult-emergency-dept');
     Route::post('adult-emergency-department-clinical-bundle-store', [IPDController::class, 'adultEmergencyDeptClinicalBundleSave'])->name('adult-emergency-dept-store');
     Route::get('adult-emergency-department-clinical-bundle-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'adultEmergencyDeptClinicalBundlePDF'])->name('adult-emergency-dept-pdf');
    //Adult Emergency Department sepsis Bundle
     Route::get('adult-emergency-department-sepsis-bundle/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'adultEmergencyDeptSepsisBundle'])->name('adult-emergency-dept-sepsis');
     Route::post('adult-emergency-department-sepsis-bundle-store', [IPDController::class, 'adultEmergencyDeptSepsisBundleSave'])->name('adult-emergency-dept-sepsis-store');
     Route::get('adult-emergency-department-sepsis-bundle-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'adultEmergencyDeptSepsisBundlePDF'])->name('adult-emergency-dept-sepsis-pdf');
    // Nursing Initial Assessment (Gynaecology)
     Route::get('ipd/nursing-initial-assessment-gynaecology-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'nursingAssessmentGynaecology'])->name('nursing-initial-assessment-gynaecology');
     Route::post('ipd/nursing-initial-assessment-gynaecology-form-store', [IPDController::class, 'nursingAssessmentGynaecologySave'])->name('nursing-initial-assessment-gynaecology-store');
     Route::get('ipd/nursing-initial-assessment-gynaecology-form-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'nursingAssessmentGynaecologyPDF'])->name('nursing-initial-assessment-gynaecology-pdf');
    // CATH LAB FORMS
     Route::get('procedure-sheet-without-sedation-cathlab/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'withoutSedationCathLab'])->name('without-sedation-cath-lab');
     Route::post('procedure-sheet-without-sedation-cathlab-store', [IPDController::class, 'withoutSedationCathLabSave'])->name('without-sedation-cath-lab-store');
     Route::get('procedure-sheet-without-sedation-cathlab-print/{handover_id}/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'withoutSedationCathLabPDF'])->name('without-sedation-cath-lab-pdf');
     Route::get('ipd/procedure-sheet-without-sedation-cathlab-edit/{handover_id}/{patient_no_fk}/{admission_id}', [IPDController::class, 'withoutSedationCathLabEdit'])->name('ipd.procedure-sheet-without-sedation-cathlab-edit');
     Route::get('ipd/procedure-sheet-without-sedation-cathlab-list/{patient_no_fk}/{admission_id}', [IPDController::class, 'withoutSedationCathLabList'])->name('ipd.procedure-sheet-without-sedation-cathlab-list');
     Route::get('procedure-sheet-under-sedation-cathlab/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'underSedationCathLab'])->name('under-sedation-cath-lab');
     Route::post('procedure-sheet-under-sedation-cathlab-store', [IPDController::class, 'underSedationCathLabSave'])->name('under-sedation-cath-lab-store');
     Route::get('procedure-sheet-under-sedation-cathlab-print/{patient_no_pk?}/{admission_no_pk?}', [IPDController::class, 'underSedationCathLabPDF'])->name('under-sedation-cath-lab-pdf');



    Route::get('ipd/surgical-site-prevention-bundle-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'surgicalPreventionBundle'])->name('ipd.surgical-prevention-bundle-form');
    Route::post('ipd/store-surgical-site-prevention-bundle', [IPDController::class, 'storeSurgicalPreventionBundle'])->name('ipd.store-surgical-prevention-bundle');
    Route::get('ipd/surgical-site-prevention-bundle-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'surgicalPreventionBundlePrint'])->name('ipd.surgical-prevention-bundle-print');

    Route::get('ipd/laryngoscope-checklist-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'laryngoscopeChecklist'])->name('ipd.laryngoscope-checklist-form');
    Route::post('ipd/store-laryngoscope-checklist', [IPDController::class, 'storeLaryngoscopeChecklist'])->name('ipd.store-laryngoscope-checklist');
    Route::get('ipd/laryngoscope-checklist-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'laryngoscopeChecklistPrint'])->name('ipd.laryngoscope-checklist-print');
    Route::get('ipd/daily-checklist-ecg-machine/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyChecklistEcgMachine'])->name('ipd.daily-checklist-ecg-machine');
    Route::post('ipd/store-daily-checklist-ecg-machine', [IPDController::class, 'storeDailyChecklistEcgMachine'])->name('ipd.store-daily-checklist-ecg-machine');
    Route::get('ipd/daily-checklist-ecg-machine-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyChecklistEcgMachinePrint'])->name('ipd.daily-checklist-ecg-machine-print');
    Route::get('ipd/daily-checklist-crash-cart/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyChecklistCrashCart'])->name('ipd.daily-checklist-crash-cart');
    Route::post('ipd/store-daily-checklist-crash-cart', [IPDController::class, 'storeDailyChecklistCrashCart'])->name('ipd.store-daily-checklist-crash-cart');
    Route::get('ipd/daily-checklist-crash-cart-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyChecklistCrashCartPrint'])->name('ipd.daily-checklist-crash-cart-print');
    Route::get('ipd/daily-check-refrigerator/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyCheckRefrigerator'])->name('ipd.daily-check-refrigerator');
    Route::post('ipd/store-daily-check-refrigerator', [IPDController::class, 'storeDailyCheckRefrigerator'])->name('ipd.store-daily-check-refrigerator');
    Route::get('ipd/daily-check-refrigerator-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyCheckRefrigeratorPrint'])->name('ipd.daily-check-refrigerator-print');
    Route::get('ipd/daily-check-temp-humidity/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyCheckTempHumidity'])->name('ipd.daily-check-temp-humidity');
    Route::post('ipd/store-daily-check-temp-humidity', [IPDController::class, 'storedailyCheckTempHumidity'])->name('ipd.store-daily-check-temp-humidity');
    Route::get('ipd/daily-check-temp-humidity-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'dailyCheckTempHumidityPrint'])->name('ipd.daily-check-temp-humidity-print');
    Route::get('ipd/btype-oxyzen-cylinder-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'bTypeOxyzenCylinder'])->name('ipd.btype-oxyzen-cylinder-form');
    Route::post('ipd/store-btype-oxyzen-cylinder', [IPDController::class, 'storebTypeOxyzenCylinder'])->name('ipd.store-btype-oxyzen-cylinder');
    Route::get('ipd/btype-oxyzen-cylinder-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'bTypeOxyzenCylinderPrint'])->name('ipd.btype-oxyzen-cylinder-print');
    Route::get('ipd/haemodialysis-unit-personal-data-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'haemodialysisPD'])->name('ipd.haemodialysis-unit-personal-data-form');
    Route::post('ipd/store-haemodialysis-unit-personal-data', [IPDController::class, 'storehaemodialysisPD'])->name('ipd.store-haemodialysis-unit-personal-data');
    Route::get('ipd/haemodialysis-unit-personal-data-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'haemodialysisPDPrint'])->name('ipd.haemodialysis-unit-personal-data-print');
    Route::get('ipd/haemodialysis-unit-treatment-worksheet-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'haemodialysisTW'])->name('ipd.haemodialysis-unit-treatment-worksheet-form');
    Route::post('ipd/store-haemodialysis-unit-treatment-worksheet', [IPDController::class, 'storehaemodialysisTW'])->name('ipd.store-haemodialysis-unit-treatment-worksheet');
    Route::get('ipd/haemodialysis-unit-treatment-worksheet-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'haemodialysisTWPrint'])->name('ipd.haemodialysis-unit-treatment-worksheet-print');
    Route::get('ipd/nicu-flow-sheet-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'nicuFlowSheetForm'])->name('ipd.nicu-flow-sheet-form');
    Route::post('ipd/store-nicu-flow-sheet-form', [IPDController::class, 'storeNicuFlowSheetForm'])->name('ipd.store-nicu-flow-sheet-form');
    Route::get('ipd/nicu-flow-sheet-form-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'nicuFlowSheetFormPrint'])->name('ipd.nicu-flow-sheet-form-print');
    Route::get('ipd/patient-clinical-records-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'patientClinicalRecords'])->name('ipd.patient-clinical-records-form');
    Route::post('ipd/store-patient-clinical-records', [IPDController::class, 'storePatientClinicalRecords'])->name('ipd.store-patient-clinical-records');
    Route::get('ipd/patient-clinical-records-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'patientClinicalRecordsPrint'])->name('ipd.patient-clinical-records-print');
    Route::get('ipd/neonatal-clinical-record-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'neonatalClinicalRecord'])->name('ipd.neonatal-clinical-record-form');
    Route::post('ipd/store-neonatal-clinical-record-form', [IPDController::class, 'storeNeonatalClinicalRecord'])->name('ipd.store-neonatal-clinical-record-form');
    Route::get('ipd/neonatal-clinical-record-form-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'neonatalClinicalRecordPrint'])->name('ipd.neonatal-clinical-record-form-print');
    Route::get('ipd/patient-discharge-diet-chart-form/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'patientDischargeDietChart'])->name('ipd.patient-discharge-diet-chart-form');
    Route::post('ipd/store-patient-discharge-diet-chart-form', [IPDController::class, 'storePatientDischargeDietChart'])->name('ipd.store-patient-discharge-diet-chart-form');
    Route::get('ipd/patient-discharge-diet-chart-form-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'patientDischargeDietChartPrint'])->name('ipd.patient-discharge-diet-chart-form-print');

    Route::get('ipd/epidural-monitoring-chart/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'epiduralMonitoringChart'])->name('ipd.epidural-monitoring-chart');
    Route::post('ipd/store-epidural-monitoring-chart', [IPDController::class, 'epiduralMonitoringChartStore'])->name('ipd.store-epidural-monitoring-chart');
    Route::get('ipd/epidural-monitoring-chart-print/{patient_no_fk?}/{admission_id?}', [IPDController::class, 'epiduralMonitoringChartPrint'])->name('ipd.epidural-monitoring-chart-print');


  //IPD Doctor Station
    Route::get('v2/ipd/doctor-station-receive-request', [IPDController::class, 'ipdDoctorStation'])->name('v2.ipd.doctor-station-receive-request');
    Route::post('v2/ipd/doctor-station-received-patient', [IPDController::class, 'getDoctorReceivedPatient'])->name('v2.ipd.doctor-station-received-patient');


  //IPD Package setup
    Route::get('v1/ipd/package-setup', [IPDController::class, 'getIpdPackageSetupV1'])->name('v1.ipd-package-setup');
    Route::get('v1/ipd/package-setup/{pkg_no_pk}', [IPDController::class, 'getIpdPackageSetupV1'])->name('v1.ipd-package-edit');
    Route::post('v1/ipd/package-store', [IPDController::class, 'v1IpdPackageStore'])->name('v1.ipd-package-store');
    Route::get('v1/ipd/package-list', [IPDController::class, 'v1IpdPackageList'])->name('v1.ipd-package-list');
    Route::delete('v1/ipd/package-delete/{pkg_no_pk}', [IPDController::class, 'v1IpdPackageDelete'])->name('v1.ipd-package-delete');
    Route::get('v1/ipd/package-patient', [IPDController::class, 'v1IpdPackagePatient'])->name('ipd.package-patient');
    Route::post('v1/ipd/package-patient-store', [IPDController::class, 'v1IpdPackagePatientStore'])->name('v1.ipd-patient-package-store');









});


