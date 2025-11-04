<?php
//  Admission
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CPH\CPHPatientAppointmentController;
use App\Http\Controllers\CPH\MedicineDistributionController;
use App\Http\Controllers\CPH\CPHController;
use App\Http\Controllers\HRM\EmployeePhoneBookController;

Route::middleware(['auth'])->group(function () {
    //Appoinment
    Route::get('patient_appointment', [CPHPatientAppointmentController::class, 'index'])->name('patient_appointment');
    Route::get('add_new_appointment_popup_cph', [CPHPatientAppointmentController::class, 'AddNewOthersPatient'])->name('add_new_appointment_popup_cph');
    Route::post('patient_appointment_save_cph', [CPHPatientAppointmentController::class, 'SavePatientAppointmentCPH'])->name('patient_appointment_save_cph');
    Route::get('queue_preview', [CPHPatientAppointmentController::class, 'QueuePreview'])->name('queue_preview');
    Route::get('appointmented_patient_list', [CPHPatientAppointmentController::class, 'AppointmentedPatientList'])->name('appointmented_patient_list');
    Route::get('opd_nurse_station_cph', [CPHPatientAppointmentController::class, 'OpdNurseStationCPH'])->name('opd_nurse_station_cph');
    Route::get('doctor_entry_page_cph', [CPHPatientAppointmentController::class, 'DoctorEntryPageCPH'])->name('doctor_entry_page_cph');
    Route::get('doctor_dashboard_cph', [CPHPatientAppointmentController::class, 'DoctorDashboardCPH'])->name('doctor_dashboard_cph');
    Route::get('today_serial_cph', [CPHPatientAppointmentController::class, 'TodaySerialCPH'])->name('today_serial_cph');

    //prescription
    Route::get('prescription_engine_doctor_wise_cph', [CPHPatientAppointmentController::class, 'PrescriptionEngineDoctorWiseCPH'])->name('prescription_engine_doctor_wise_cph');
    Route::get('prescription_worklist_cph', [CPHPatientAppointmentController::class, 'PrescriptionWorklistCPH'])->name('prescription_worklist_cph');
    Route::get('blank-prescription-form', [MedicineDistributionController::class, 'blankPrescriptionForm'])->name('medicine.blank-prescription-form');

    // medicine distribution
    Route::get('medicine/medicine-distribution-dashboard', [MedicineDistributionController::class, 'medicineDistributionDashboard'])->name('medicine.medicine-distribution-dashboard');
    Route::get('medicine/medicine-detail-stock', [MedicineDistributionController::class, 'medicineDetailStock'])->name('medicine.medicine-detail-stock');
    Route::get('medicine/medicine-packet-pending', [MedicineDistributionController::class, 'medicinePacketPending'])->name('medicine.medicine-packet-pending');
    Route::get('medicine/medicine-packet-detail', [MedicineDistributionController::class, 'medicinePacketDetail'])->name('medicine.medicine-packet-detail');
    Route::get('medicine/medicine-packet-print', [MedicineDistributionController::class, 'medicinePacketPrint'])->name('medicine.medicine-packet-print');
    Route::get('medicine/medicine-rack-in', [MedicineDistributionController::class, 'medicinRackIn'])->name('medicine.medicine-rack-in');
    Route::get('medicine/medicine-customer-token', [MedicineDistributionController::class, 'medicineCustomerToken'])->name('medicine.medicine-customer-token');
    Route::get('medicine/medicine-customer-token-print', [MedicineDistributionController::class, 'medicineCustomerTokenPrint'])->name('medicine.medicine-customer-token-print');
    Route::get('medicine/medicine-rack-out', [MedicineDistributionController::class, 'medicineRackOut'])->name('medicine.medicine-rack-out');
    Route::get('medicine/medicine-distribution-report', [MedicineDistributionController::class, 'medicineDistributionReport'])->name('medicine.medicine-distribution-report');
    Route::get('medicine/medicine-box-a-distribution', [MedicineDistributionController::class, 'medicineBoxaDistribution'])->name('medicine.medicine-box-a-distribution');
    Route::get('medicine/medicine-box-a-distribution-pending', [MedicineDistributionController::class, 'medicineBoxaDistributionPending'])->name('medicine.medicine-box-a-distribution-pending');
});


<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CPH\CPHPatientAppointmentController;
use App\Http\Controllers\CPH\MedicineDistributionController;
use App\Http\Controllers\CPH\CPHController;
use App\Http\Controllers\HRM\EmployeePhoneBookController;

Route::middleware(['auth'])->group(function () {
    //Appoinment
    Route::get('patient_appointment', [CPHPatientAppointmentController::class, 'index'])->name('patient_appointment');
    Route::get('add_new_appointment_popup_cph', [CPHPatientAppointmentController::class, 'AddNewOthersPatient'])->name('add_new_appointment_popup_cph');
    Route::post('patient_appointment_save_cph', [CPHPatientAppointmentController::class, 'SavePatientAppointmentCPH'])->name('patient_appointment_save_cph');
    Route::get('queue_preview', [CPHPatientAppointmentController::class, 'QueuePreview'])->name('queue_preview');
    Route::get('appointmented_patient_list', [CPHPatientAppointmentController::class, 'AppointmentedPatientList'])->name('appointmented_patient_list');
    Route::get('opd_nurse_station_cph', [CPHPatientAppointmentController::class, 'OpdNurseStationCPH'])->name('opd_nurse_station_cph');
    Route::get('doctor_entry_page_cph', [CPHPatientAppointmentController::class, 'DoctorEntryPageCPH'])->name('doctor_entry_page_cph');
    Route::get('doctor_dashboard_cph', [CPHPatientAppointmentController::class, 'DoctorDashboardCPH'])->name('doctor_dashboard_cph');
    Route::get('today_serial_cph', [CPHPatientAppointmentController::class, 'TodaySerialCPH'])->name('today_serial_cph');
    //prescription
    Route::get('prescription_engine_doctor_wise_cph', [CPHPatientAppointmentController::class, 'PrescriptionEngineDoctorWiseCPH'])->name('prescription_engine_doctor_wise_cph');
    Route::get('prescription_worklist_cph', [CPHPatientAppointmentController::class, 'PrescriptionWorklistCPH'])->name('prescription_worklist_cph');
    Route::get('blank-prescription-form', [MedicineDistributionController::class, 'blankPrescriptionForm'])->name('medicine.blank-prescription-form');
    // medicine distribution
    Route::get('medicine/medicine-distribution-dashboard', [MedicineDistributionController::class, 'medicineDistributionDashboard'])->name('medicine.medicine-distribution-dashboard');
    Route::get('medicine/medicine-detail-stock', [MedicineDistributionController::class, 'medicineDetailStock'])->name('medicine.medicine-detail-stock');
    Route::get('medicine/medicine-packet-pending', [MedicineDistributionController::class, 'medicinePacketPending'])->name('medicine.medicine-packet-pending');
    Route::get('medicine/medicine-packet-detail', [MedicineDistributionController::class, 'medicinePacketDetail'])->name('medicine.medicine-packet-detail');
    Route::get('medicine/medicine-packet-print', [MedicineDistributionController::class, 'medicinePacketPrint'])->name('medicine.medicine-packet-print');
    Route::get('medicine/medicine-rack-in', [MedicineDistributionController::class, 'medicinRackIn'])->name('medicine.medicine-rack-in');
    Route::get('medicine/medicine-customer-token', [MedicineDistributionController::class, 'medicineCustomerToken'])->name('medicine.medicine-customer-token');
    Route::get('medicine/medicine-customer-token-print', [MedicineDistributionController::class, 'medicineCustomerTokenPrint'])->name('medicine.medicine-customer-token-print');
    Route::get('medicine/medicine-rack-out', [MedicineDistributionController::class, 'medicineRackOut'])->name('medicine.medicine-rack-out');
    Route::get('medicine/medicine-distribution-report', [MedicineDistributionController::class, 'medicineDistributionReport'])->name('medicine.medicine-distribution-report');
    Route::get('medicine/medicine-box-a-distribution', [MedicineDistributionController::class, 'medicineBoxaDistribution'])->name('medicine.medicine-box-a-distribution');
    Route::get('medicine/medicine-box-a-distribution-pending', [MedicineDistributionController::class, 'medicineBoxaDistributionPending'])->name('medicine.medicine-box-a-distribution-pending');
});

