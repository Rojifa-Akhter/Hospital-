<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LabRequestController;
use App\Http\Controllers\PatientAppointmentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/send-data/{id?}', [LabRequestController::class, 'sendLabelData']);
Route::post('/update-label-print-ind', [LabRequestController::class, 'updateLabelPrintInd']);

// api for website
Route::get('doctor-details/{id?}', [LabRequestController::class, 'doctorDetails'])->name('doctor-details');
Route::get('slot-data/{doctorId?}', [PatientAppointmentController::class,'slotData'])->name('slot-data');
Route::post('appointment-save-api', [PatientAppointmentController::class,'saveApiApointment'])->name('appointment-save-api');
