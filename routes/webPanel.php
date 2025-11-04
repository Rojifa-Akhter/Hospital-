<?php

use Illuminate\Http\Request;
use App\Http\Controllers\WebPanel\VideoCallController;
use App\Http\Controllers\WebPanel\ChatsController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ChamberHospitalController;
use App\Http\Controllers\PrescriptionController;



Route::get('/video-call', [VideoCallController::class, 'videoCall'])->name('video-call');

Route::post('/video/call-user', 'App\Http\Controllers\VideoCallController@callUser');
Route::post('/video/accept-call', 'App\Http\Controllers\VideoCallController@acceptCall');

Route::post('physiotherapy/load-pres-favourit-list-web-portal', [PrescriptionController::class, 'loadPresFavouritListForWebPortal'])->name('physiotherapy.load-pres-favourit-list-web-portal');
Route::get('get-prev-prescription-dtls-web-portal/{patient_id?}', [PrescriptionController::class, 'getPrevPrescriptionDtlsWebPortal'])->name('get-prev-prescription-dtls-web-portal');

Route::get('/agora-chat', [VideoCallController::class, 'index']);
Route::post('/agora/token', [VideoCallController::class, 'token']);
Route::post('/agora/call-user', [VideoCallController::class, 'callUser']);
Route::post('/agora/accept-call', [VideoCallController::class, 'acceptCall']);

Route::get('/chats', [ChatsController::class, 'index']);
//Route::get('/messages', [ChatsController::class,'fetchMessages']);
//Route::post('/messages', [ChatsController::class,'sendMessage']);

//Added By Nazmul

Route::get('cover/otp-verify', [SiteController::class, 'otpVerify'])->name('cover.otp-verify');
Route::get('cover.verify-otp-for-appointment/{id?}', [SiteController::class, 'otpVerifyForAppointment'])->name('cover.verify-otp-for-appointment');
Route::get('mcare/doctor-details/{id?}', [SiteController::class, 'doctorDetails'])->name('mcare.doctor-details');
Route::get('mcare/hospital-details/{id?}', [SiteController::class, 'hospitalDetails'])->name('mcare.hospital-details');
Route::post('cover.verify-otp', [SiteController::class, 'verifyOtpStore'])->name('cover.verify-otp');
Route::post('cover.verify-otp-for-appointment/{id?}', [SiteController::class, 'verifyOtpStoreForAppointment'])->name('cover.verify-otp-for-appointment');
Route::get('patient/appointment-book/{patient_id}', [AdminPanelController::class, 'patAppointmentBook'])->name('patient.appointment-book');
Route::get('cover/book-appointment-sign-doctor/by-patient/{doctor_id?}', [AdminPanelController::class, 'coverBookAppointmentSignDoctorByPatient'])->name('cover.book-appointment-sign-doctor-by-patient');
Route::post('get-doctors-by-specialized-patient', [AdminPanelController::class, 'doctorSpecializedByPatient'])->name('get-doctors-by-specialized-patient');
Route::get('patient/profile/edit/{id}', [AdminPanelController::class, 'editpatientProfile'])->name('patient.register-profile');
Route::get('patient/details/{id?}', [AdminPanelController::class, 'PatientShow'])->name('patient.details');
Route::get('patient/doctor-details', [AdminPanelController::class, 'DoctorShow'])->name('patient.doctor-details');
Route::get('patient.appointment-modal', [AdminPanelController::class, 'appModal'])->name('patient.appointment-modal');
Route::get('patient/e-commerce/orders/{id?}', [AdminPanelController::class, 'eCommerceOrderList'])->name('patient.e-commerce-orders');
Route::get('order/details', [AdminPanelController::class, 'orderDetails'])->name('order.details');
Route::post('patient/e-commerce/orders/search', [AdminPanelController::class, 'eCommerceOrderListSearch'])->name('patient.e-commerce-orders-search');
Route::post('mcare/update/doctor/{id?}', [AdminPanelController::class, 'updateDoctor'])->name('mcare-update-doctor');
Route::post('mcare/update/doctor-information/{id?}', [AdminPanelController::class, 'updateDoctorInfo'])->name('mcare-update-doctor-info');


Route::post('chamber-hospital-list', [ChamberHospitalController::class, 'chamberHospitalList'])->name('chamber-hospital-list');
Route::resource('chamber-hospital', ChamberHospitalController::class);
Route::get('/about-us', [SiteController::class, 'mcareAboutUs'])->name('mcare.about-us');
Route::get('/contact-us', [SiteController::class, 'mcareContactUs'])->name('mcare.contact-us');
Route::get('/terms-condition', [SiteController::class, 'termsCondition'])->name('mcare.terms-condition');
Route::get('/refund-policy', [SiteController::class, 'refundPolicy'])->name('mcare.refund-policy');
Route::get('/privacy-policy', [SiteController::class, 'privacyPolicy'])->name('mcare.privacy-policy');


Route::post('coverpage/search-doctor-list', [SiteController::class, 'searchDoctorList'])->name('coverpage/search-doctor-list');
Route::post('coverpage/search-hospital-list', [SiteController::class, 'searchHospitalList'])->name('coverpage/search-hospital-list');
Route::post('coverpage/search-product-list', [SiteController::class, 'searchProductList'])->name('coverpage/search-product-list');
