<?php

use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\EmergencyPrescriptionController;
use App\Http\Controllers\PrescriptionFreeTextController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('presc-interaction', [PrescriptionController::class, 'prescInteraction'])->name('presc-interaction');
    // Route::get('get-prescription-mst/{appointment}/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionMst'])->name('get-prescription-mst');

    Route::get('get-prescription-mst/{appointment}/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionMst'])->name('get-prescription-mst');
    Route::get('get-prescription-mst-cc/{appointment}/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionMstCC'])->name('get-prescription-mst-cc');
    // Route::get('get-prescription-mst-uhl/{appointment}/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionMstUHL'])->name('get-prescription-mst-uhl');
    Route::get('get-prescription-mst-uhl/{appoint_no_pk}/{patient_no_pk}/{prescription_no_pk}', [PrescriptionController::class, 'getPrescriptionMstUHL'])
        ->name('get-prescription-mst-uhl');
    Route::get('get-emergency-prescription-mst/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getEmergencyPrescriptionMst'])->name('get-emergency-prescription-mst');
    Route::get('get-prescription-mst2/{appointment}/{patient_id?}/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionMst2'])->name('get-prescription-mst2');
// Route::get('get-prescription-dtls-edit/{prescription_id?}/{room_id?}', [PrescriptionController::class, 'getPrescriptionDtlsEdit'])->name('get-prescription-dtls-edit');

    Route::get('get-prescription-dtls/{prescription_id?}/{patient_code?}', [PrescriptionController::class, 'getPrescriptionDtls'])->name('get-prescription-dtls');
    Route::get('get-prescription-dtls-uhl/{prescription_id?}/{patient_code?}', [PrescriptionController::class, 'getPrescriptionDtlsUHL'])->name('get-prescription-dtls-uhl');
    Route::get('get-prescription-dtls2/{prescription_id?}', [PrescriptionController::class, 'getPrescriptionDtls2'])->name('get-prescription-dtls2');
    Route::get('get-prescription-medicine-dtls-uhl/{prescription_id?}/{patient_code?}', [PrescriptionController::class, 'getPrescriptionMedicineDtlsUHL'])->name('get-prescription-medicine-dtls-uhl');

    Route::get('get-last-prescription-medicine-dtls-uhl/{prescription_id?}/{patient_code?}', [PrescriptionController::class, 'getPrescriptionMedicineLastDtlsUHL'])->name('get-last-prescription-medicine-dtls-uhl');

    Route::post('get-prescription-dtls-from-template', [PrescriptionController::class, 'getPrescriptionDtlsFromTemplate'])->name('get-prescription-dtls-from-template');
    Route::post('get-prescription-dtls-from-template-uhl', [PrescriptionController::class, 'getPrescriptionDtlsFromTemplateUHL'])->name('get-prescription-dtls-from-template-uhl');
    Route::get('get-prev-prescription-dtls/{patient_id?}/{patient_code?}', [PrescriptionController::class, 'getPrevPrescriptionDtls'])->name('get-prev-prescription-dtls');
    // Route::get('get-prev-prescription-dtls-uhl/{appointment_id?}/{patient_id?}/{patient_code?}/{prescription_no_pk?}', [PrescriptionController::class, 'getPrevPrescriptionDtlsUHL'])->name('get-prev-prescription-dtls-uhl');
    Route::get('get-prev-prescription-dtls-uhl/{patient_no_pk}/{patient_code}', [PrescriptionController::class, 'getPrevPrescriptionDtlsUHL'])
        ->name('get-prev-prescription-dtls-uhl');
    // {appointment_id?}/{patient_code?}/{patient_no_pk?}/{prescription_no_pk?}
    Route::get('get-prev-prescription-dtls2/{patient_id?}', [PrescriptionController::class, 'getPrevPrescriptionDtls2'])->name('get-prev-prescription-dtls2');

    Route::get('/prescription-entry/{id?}/{patient_id?}', [PrescriptionController::class, 'prescriptionEntry'])->name('prescription-entry');
    Route::get('/prescription-view', [PrescriptionController::class, 'prescriptionView'])->name('prescription-view');
    Route::post('add-pres-favourit-list', [PrescriptionController::class, 'presFavouritListSaveUpdate'])->name('add-pres-favourit-list');
    Route::post('physiotherapy/load-pres-favourit-list', [PrescriptionController::class, 'loadPresFavouritList'])->name('physiotherapy.load-pres-favourit-list');
    Route::post('physiotherapy/load-pres-favourit-list-uhl', [PrescriptionController::class, 'loadPresFavouritListUHL'])->name('physiotherapy.load-pres-favourit-list-uhl');
    Route::post('remove-from-pres-favourit-list', [PrescriptionController::class, 'removeFromPresFavouritList'])->name('remove-from-pres-favourit-list');
    Route::post('pres-physio-save-update', [PrescriptionController::class, 'presPhysiotherapySaveUpdate'])->name('pres-physio-save-update');
    Route::post('pres-opd-save-update', [PrescriptionController::class, 'presOpdSaveUpdate'])->name('pres-opd-save-update');
    Route::post('pres-opd-save-update-uhl', [PrescriptionController::class, 'presOpdSaveUpdateUHL'])->name('pres-opd-save-update-uhl');
    Route::post('pres-opd-save-update2', [PrescriptionController::class, 'presOpdSaveUpdate2'])->name('pres-opd-save-update2');
    Route::post('delete-prescription-template', [PrescriptionController::class, 'deletePrescriptionTemplate'])->name('delete-prescription-template');

    Route::post('opd-nurse-station-vital-save-update', [PrescriptionController::class, 'OpdNurseStationVitalsSaveUpdate'])->name('opd-nurse-station-vital-save-update');
    Route::post('pres-opd-save-update-template', [PrescriptionController::class, 'presOpdSaveUpdateTemplate'])->name('pres-opd-save-update-template');
    Route::get('prescription-print/{id}', [PrescriptionController::class, 'printPrescription'])->name('prescription-print');
    Route::get('prescription-print-pdf', [PrescriptionController::class, 'printPrescriptio'])->name('prescription-print-pdf');
    Route::get('prescription-print-specticles-pdf/{id?}', [PrescriptionController::class, 'printSpecticlesPrescriptionPdf'])->name('prescription-print-specticles-pdf');
    Route::get('prescription-templates/{doctor_id}/{patient_id?}', [PrescriptionController::class, 'getPrescriptionTemplates'])->name('prescription-templates');
    Route::get('prescription-templates-uhl/{doctor_id}/{patient_id?}', [PrescriptionController::class, 'getPrescriptionTemplatesUHL'])->name('prescription-templates-uhl');
    Route::post('presc-autocomplete', [PrescriptionController::class, 'prescAutocomplete'])->name('presc-autocomplete');
    Route::get('prescription_print/{prescription_id?}', [PrescriptionController::class, 'printPrescription'])->name('prescription_print');
    Route::post('add-chronic-disease', [PrescriptionController::class, 'addChronicDisease'])->name('add-chronic-disease');
    Route::post('store-chronic-disease', [PrescriptionController::class, 'storeChronicDisease'])->name('store-chronic-disease');

    Route::get('add-new-chronic-deasease', [PrescriptionController::class, 'createNewChronicDeasese'])->name('add-new-chronic-deasease');
    Route::post('store-new-chronic-deasease', [PrescriptionController::class, 'StoreNewChronicDeasease'])->name('store-new-chronic-deasease');


    Route::post('store-allergy', [PrescriptionController::class, 'storeAllergy'])->name('store-allergy');
    Route::post('prescription.allergy-data-delete', [PrescriptionController::class, 'AllergyDataDelete'])->name('prescription.allergy-data-delete');
    Route::post('delete-chronic-disease', [PrescriptionController::class, 'deleteAllergy'])->name('delete-chronic-disease');
    Route::post('update_continue_chronic', [PrescriptionController::class, 'updateContinueChronic'])->name('update_continue_chronic');
    Route::get('add-allergy', [PrescriptionController::class, 'addAllergy'])->name('add-allergy');
    Route::get('prescription/create', [PrescriptionController::class, 'prescreate'])->name('prescription.create');
    Route::get('create-doctor-wise/{appointment_id?}', [PrescriptionController::class, 'prescreateDoctorWise'])->name('prescription.create-doctor-wise');
    Route::get('create-doctor-wise-uhl/{appointment_id?}/{patient_code?}/{patient_no_pk?}/{prescription_no_pk?}', [PrescriptionController::class, 'prescreateDoctorWiseUHL'])->name('prescription.create-doctor-wise-uhl');
    Route::get('appointment-list/{appointment_id?}', [PrescriptionController::class, 'prescreateDoctorWiseAppointmentList'])->name('prescription.appointment-list');
    Route::get('create-doctor-wise2/{appointment_id?}', [PrescriptionController::class, 'prescreateDoctorWise2'])->name('prescription.create-doctor-wise2');
    Route::get('opd-nurse-station-vitals/{appointment_id?}', [PrescriptionController::class, 'opd_nurse_station_vitals'])->name('prescription.opd-nurse-station-vitals');
    Route::post('prescription.doctor-prescribed-patient-list', [PrescriptionController::class, 'getDoctorWisePrescribedPatientList'])->name('prescription.doctor-prescribed-patient-list');


    // v2
    Route::get('v2/opd-nurse-station-vitals/{appointment_id?}', [PrescriptionController::class, 'opd_nurse_station_vitals_v2'])->name('v2.prescription.opd-nurse-station-vitals');
    Route::get('v2/opd-nurse-station-vitals-er/{appointment_id?}', [PrescriptionController::class, 'opd_nurse_station_vitals_v2_er'])->name('v2.prescription.opd-nurse-station-vitals-er');

    Route::get('block-slot/{schedule_id?}/{doctor_id?}/{date?}', [PrescriptionController::class, 'blockSlotShow'])->name('prescription.blockSlotShow');
    Route::post('block-slot', [PrescriptionController::class, 'blockSlot'])->name('prescription.blockSlot');
    Route::get('unblock-slot/{schedule_id?}', [PrescriptionController::class, 'unblockSlotShow'])->name('prescription.unblockSlotShow');
    Route::post('unblock-slot', [PrescriptionController::class, 'unblockSlot'])->name('prescription.unblockSlot');

    Route::post('add-multidose', [PrescriptionController::class, 'addMultidose'])->name('add-multidose');
    Route::post('alternative-medicine', [PrescriptionController::class, 'altMedicine'])->name('alternative-medicine');
    // Route::get('prescription/presc-form-doctor-wise',' PrescriptionController@prescreate_doctor_wise')->name('prescription.presc-form-doctor-wise');
    Route::post('prescription/get-patient-info-1234', [PrescriptionController::class, 'getPatientInfo'])->name('prescription.get-patient-info');
    Route::get('appointment-absent', [PrescriptionController::class, 'appointmentAbsent'])->name('prescription.appointment-absent');
    Route::get('opd_vitals_print/{appoint_id?}', [PrescriptionController::class, 'opdPrintvaitals'])->name('opd_vitals_print');
    //OPD Prescription Print
    Route::get('opd_prescription_print/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescription'])->name('opd_prescription_print');
    Route::get('opd_prescription_print_uhl/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionUHL'])->name('opd_prescription_print_uhl');
    Route::get('opd_prescription_print_uhl_app/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionUHLApp'])->name('opd_prescription_print_uhl_app');
    Route::get('opd_prescription_preview_uhl', [PrescriptionController::class, 'opdPreviewPrescriptionUHL'])->name('opd_prescription_preview_uhl');
    Route::get('opd_prescription_print2/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescription2'])->name('opd_prescription_print2');
    Route::get('opd_prescription_print_pdf/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionPdf'])->name('opd_prescription_print_pdf');
    Route::get('opd_prescription_print_pdf_uhl/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionPdfUHL'])->name('opd_prescription_print_pdf_uhl');
    Route::get('op_summary_pdf_uhl/{prescription_id?}', [PrescriptionController::class, 'opSummaryPrintPdfUHL'])->name('op_summary_pdf_uhl');
    Route::get('prescription_pdf_uhl/{prescription_id?}', [PrescriptionController::class, 'prescriptionPrintPdfUHL'])->name('prescription_pdf_uhl');
    Route::get('opd_prescription_print_pdf_uhl/a5/{prescription_id?}', [PrescriptionController::class, 'prescriptionPrintPdfUHLA5'])->name('opd_prescription_print_pdf_uhl.a5');
    // Route::get('opd_prescription_print_pdf/{prescription_id?}/{type?}', [PrescriptionController::class, 'opdPrintPrescriptionPdf'])->name('opd_prescription_print_pdf');
    Route::get('opd_prescription_print_pdf2/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionPdf2'])->name('opd_prescription_print_pdf2');

    Route::get('v1/ipd_prescription_preview', [PrescriptionController::class, 'ipdPreviewPrescriptionV1'])->name('v1.ipd_prescription_preview');

    Route::resource('prescription', PrescriptionController::class, ['except' => 'create']);

    //Emergency
    Route::get('emergency-prescription', [EmergencyPrescriptionController::class, 'emergencyPres'])->name('emergency-prescription');
    Route::get('ipd/emergency-prescription/{pat_id?}/{adm_id?}/{doc_id?}', [EmergencyPrescriptionController::class, 'emergencyPresIpd'])->name('ipd.emergency-prescription');
    Route::get('anes/emergency-prescription/{pat_id?}/{doc_id?}', [EmergencyPrescriptionController::class, 'emergencyPresAnes'])->name('anes.emergency-prescription');
    Route::get('prescription-order-entry', [EmergencyPrescriptionController::class, 'getPrescriptionOderEntry'])->name('prescription-order-entry');
    Route::post('prescription.doctor-emergency-prescribed-patient-list', [EmergencyPrescriptionController::class, 'getDoctorWiseEmrPrescribedPatientList'])->name('prescription.doctor-emergency-prescribed-patient-list');

    Route::get('international-prostate-symptom-score-questionnaire', [PrescriptionController::class, 'getProstateSymptomForm'])->name('international-prostate-symptom-score-questionnaire');
    Route::get('international-prostate-symptom-score-questionnaire-page', [PrescriptionController::class, 'getProstateSymptomPage'])->name('international-prostate-symptom-page');
    Route::post('international-prostate-symptom-score-questionnaire-list', [PrescriptionController::class, 'getProstateSymptomList'])->name('international-prostate-symptom-score-questionnaire-list');
    Route::get('international-prostate-symptom-score-questionnaire-edit/{id?}', [PrescriptionController::class, 'getProstateSymptomedit'])->name('international-prostate-symptom-score-questionnaire-edit');

    Route::post('store-international-prostate-symptom-score-questionnaire', [PrescriptionController::class, 'storeProstateSymptom'])->name('store-international-prostate-symptom-score-questionnaire');
    Route::get('IIEF-5-questionnaire', [PrescriptionController::class, 'getIIEF_5_questionnaireForm'])->name('IIEF-5-questionnaire');
    Route::post('store-IIEF-5-questionnaire', [PrescriptionController::class, 'storeIIEF_5_questionnaire'])->name('store-IIEF-5-questionnaire');
    Route::get('IIEF-5-questionnaire-page', [PrescriptionController::class, 'getIIEFPage'])->name('IIEF-5-questionnaire-page');
    Route::get('IIEF-5-questionnaire-edit/{id?}', [PrescriptionController::class, 'getIIEFEdit'])->name('IIEF-5-questionnaire-edit');
    Route::post('IIEF-5-questionnaire-list', [PrescriptionController::class, 'getIIEFList'])->name('IIEF-5-questionnaire-list');
    Route::get('therapy-details-page', [PrescriptionController::class, 'getTherapyDetailsPage'])->name('therapy-details-page');

    Route::get('therapy-details-list', [PrescriptionController::class, 'getTherapyList'])->name('therapy-details-list');
    Route::get('test', [PrescriptionController::class, 'test'])->name('test');
    Route::post('prescription-free-text', [PrescriptionFreeTextController::class, 'prescriptionFreeText'])->name('prescription-free-text');


    Route::post('prescription-favorite-worklist-search-data', [PrescriptionController::class, 'presFavoriteWorklistSearchData'])->name('prescription-favorite-worklist-search-data');

    Route::get('prescription-favorite-worklist', [PrescriptionController::class, 'presFavoriteWorklist'])->name('prescription-favorite-worklist');
    Route::post('prescription-favorite-search-worklist', [PrescriptionController::class, 'presFavoriteWorklistSearch'])->name('prescription-favorite-search-worklist');
    Route::post('prescription.favorite-add-medicine', [PrescriptionController::class, 'addDoctorWiseFavorite'])->name('prescription.favorite-add-medicine');
    Route::post('prescription.favorite-add-service', [PrescriptionController::class, 'addDoctorWiseFavoriteService'])->name('prescription.favorite-add-service');
    Route::post('prescription.favorite-add-all', [PrescriptionController::class, 'addDoctorWiseFavoriteAll'])->name('prescription.favorite-add-all');

    Route::get('prescription-most-used-medicine', [PrescriptionController::class, 'mostUsedMedicine'])->name('prescription-most-used-medicine');
    Route::post('prescription-item-load-group-wise', [PrescriptionController::class, 'itemLoadPrescriptionGroup'])->name('prescription-item-load-group-wise');
    Route::get('prescription-most-used-refered-doctor', [PrescriptionController::class, 'mostUsedDoctor'])->name('prescription-most-used-refered-doctor');
    Route::get('prescription-most-used-items/{type?}', [PrescriptionController::class, 'mostUsedItems'])->name('prescription-most-used-items');
    Route::get('prescription-most-used-medicine-data', [PrescriptionController::class, 'mostUsedMedicineData'])->name('prescription-most-used-medicine-data');
    Route::post('prescription-alt-search-data', [PrescriptionController::class, 'presAltSearchData'])->name('prescription-alt-search-data');
    Route::post('prescription-mum-search-data', [PrescriptionController::class, 'presMumSearchData'])->name('prescription-mum-search-data');
    Route::post('prescription-mum-search-data-all', [PrescriptionController::class, 'presMumSearchDataAll'])->name('prescription-mum-search-data-all');
    Route::post('prescription-group-item-save', [PrescriptionController::class, 'presGroupSave'])->name('prescription-group-item-save');

    Route::post('prescription-department-wise-doctor', [PrescriptionController::class, 'presDeptWiseDoctor'])->name('prescription-department-wise-doctor');


    // OPD Prescription v2

    Route::get('v2/opd_prescription_print_pdf/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionPdfV2'])->name('v2.opd_prescription_print_pdf');
    Route::get('v2/op_summary_pdf_uhl/{prescription_id?}', [PrescriptionController::class, 'opSummaryPrintPdfUHLV2'])->name('v2.op_summary_pdf_uhl');
    Route::get('v3/op_summary_pdf_uhl/{prescription_id?}', [PrescriptionController::class, 'opSummaryPrintPdfUHLV3'])->name('v3.op_summary_pdf_uhl');
    Route::post('doctor-name-find', [PrescriptionController::class, 'doctorNameFind'])->name('doctor-name-find');
    Route::get('prescription-most-used-medicine-uhl', [PrescriptionController::class, 'mostUsedMedicineUhl'])->name('prescription-most-used-medicine-uhl');
    Route::post('prescription-mum-search-data-uhl', [PrescriptionController::class, 'presMumSearchDataUhl'])->name('prescription-mum-search-data-uhl');
    Route::get('prescription-most-used-items-uhl/{type?}', [PrescriptionController::class, 'mostUsedItemsUhl'])->name('prescription-most-used-items-uhl');
    Route::get('prescription-packages-uhl', [PrescriptionController::class, 'pakagesUhl'])->name('prescription-packages-uhl');
    Route::get('add-allergy-uhl', [PrescriptionController::class, 'addAllergyUhl'])->name('add-allergy-uhl');
    Route::post('prescription-item-load-group-wise-uhl', [PrescriptionController::class, 'itemLoadPrescriptionGroupUhl'])->name('prescription-item-load-group-wise-uhl');
});
