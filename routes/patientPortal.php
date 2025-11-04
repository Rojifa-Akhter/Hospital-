<?php

use App\Http\Controllers\PathologyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientPortalController;

Route::get('/login', [PatientPortalController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login-to-dashboard', [PatientPortalController::class, 'login'])->name('login');

Route::group(['middleware' => 'patient'], function() {
    Route::get('/dashboard', [PatientPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoice', [PatientPortalController::class, 'invoice'])->name('invoice');
    Route::get('/prescription', [PatientPortalController::class, 'prescription'])->name('prescription');
    Route::get('/ipd', [PatientPortalController::class, 'ipd'])->name('ipd');
    Route::get('/password-change', [PatientPortalController::class, 'passwordChange'])->name('passwordChange');
    Route::post('/password-update', [PatientPortalController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/logout', [PatientPortalController::class, 'logout'])->name('logout');

    # Report
    Route::get('/invoice/report/{report_id}', [PatientPortalController::class, 'invoiceReport'])->name('invoiceReport');
    Route::get('/prescription/report/{prescription_id}', [PatientPortalController::class, 'prescriptionReport'])->name('prescriptionReport');
    Route::get('/discharge-certificate/{id}', [PatientPortalController::class, 'dischargeCertificate'])->name('dischargeCertificate');

    # Experimental
    // Route::get('path/bc-report-pdf/{report_id?}', [PathologyController::class, 'resultEntryPdf'])->name('path.bc-report-pdf');
    // Route::get('opd_prescription_print_pdf/{prescription_id?}', [PrescriptionController::class, 'opdPrintPrescriptionPdf'])->name('opd_prescription_print_pdf');
    // route::get('discharge/certificate/{id?}', 'ReportController@dischargeReport')->name('report.discharge');
});
