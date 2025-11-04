
<?php

use App\Http\Controllers\AttendenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRM\HRMLoanRequestController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\HRM\HRMIncreamentPolicyController;
use App\Http\Controllers\HRM\HRMDashboardPlanningController;
use App\Http\Controllers\HRM\EmployeePhoneBookController;
use App\Http\Controllers\HRM\HRMLoanSettlementController;
use App\Http\Controllers\HRM\ProvidentFundController;
use App\Http\Controllers\HRM\CVController;
use App\Http\Controllers\HRM\EmployeePortalController;
use App\Http\Controllers\HRM\HRMEmployeeSeparationController;
use App\Http\Controllers\HRM\HRMSelectionController;
use App\Http\Controllers\HRM\HRMTemplateController;
use App\Http\Controllers\HRM\HRMManpowerRequisitionController;
use App\Http\Controllers\HRM\HRMOrganogramController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'v1/hrm', 'as' => 'v1.hrm.'], function () {

        Route::get('loan-list',  [HRMLoanRequestController::class, 'loanList'])->name('loan-list');
        Route::get('loan-request',  [HRMLoanRequestController::class, 'loanRequest'])->name('loan-request');
        Route::post('store-loan-request',  [HRMLoanRequestController::class, 'storeLoanRequest'])->name('store-loan-request');
        Route::get('edit-loan-request/{loadId}',  [HRMLoanRequestController::class, 'editLoanRequest'])->name('edit-loan-request');
        Route::post('search-loan-request-list',  [HRMLoanRequestController::class, 'loanRequestListSearch'])->name('search-loan-request-list');



        Route::get('loan-settlement/{loadId}',  [HRMLoanSettlementController::class, 'loanSettlement'])->name('loan-settlement');
        Route::post('loan-settlement-date-time',  [HRMLoanSettlementController::class, 'loanSettlementDateTime'])->name('loan-settlement-date-time');
        Route::post('store-loan-settlement',  [HRMLoanSettlementController::class, 'storeLoanSettlement'])->name('store-loan-settlement');

        Route::get('loan-installment-payment-and-closing/{loanReqNo?}', [HRMLoanSettlementController::class, 'loanInstallmentPaymentAndClose'])->name('loan-installment-payment-and-closing');
        Route::post('search-loan-installment-payment-and-closing', [HRMLoanSettlementController::class, 'searchLoanInstallmentPaymentAndClose'])->name('search-loan-installment-payment-and-closing');
        Route::post('update-loan-installment-payment-and-closing', [HRMLoanSettlementController::class, 'updateLoanInstallmentPaymentAndClose'])->name('update-loan-installment-payment-and-closing');

        Route::get('employee-phonebook', [EmployeePhoneBookController::class, 'employeePhoneBook'])->name('employee-phonebook');

        Route::get('provident-fund-policy', [ProvidentFundController::class, 'fundPolicy'])->name('provident-fund-policy');
        Route::post('store-provident-fund-policy', [ProvidentFundController::class, 'storFundPolicy'])->name('store-provident-fund-policy');

        Route::get('monthly-loan-status',  [HRMLoanRequestController::class, 'monthlyLoanStatus'])->name('monthly-loan-status');
        Route::post('search-monthly-loan-status',  [HRMLoanRequestController::class, 'searchMonthlyLoanStatus'])->name('search-monthly-loan-status');


        Route::get('provident-fund-settlement', [ProvidentFundController::class, 'fundSettlement'])->name('provident-fund-settlement');
        Route::post('get-all-salary-info', [ProvidentFundController::class, 'getAllSalaryInfo'])->name('get-all-salary-info');
        Route::post('store-provident-fund-settlement', [ProvidentFundController::class, 'storeFundSettlement'])->name('store-provident-fund-settlement');
        Route::get('monthly-office-wise-contribution-posting', [ProvidentFundController::class, 'monthWiseContributionPosting'])->name('monthly-office-wise-contribution-posting');


        Route::get('cv-entry/{id?}', [CVController::class, 'cvEntry'])->name('cv-entry');
        Route::get('cv-edit/{applicant_id}', [CVController::class, 'cvEdit'])->name('cv-edit');
        Route::post('store-cv', [CVController::class, 'storeCV'])->name('store-cv');
        Route::get('cv-list', [CVController::class, 'cvList'])->name('cv-list');


        Route::post('search_cv_list', [CVController::class, 'cvSearch'])->name('search_cv_list');
        Route::get('cv-view/{applicant_id}', [CVController::class, 'cvView'])->name('cv-view');
        Route::post('remove-applicant-cv/{cvapplicant_no_pk}', [CVController::class, 'cvRemove'])->name('remove-applicant-cv');
        Route::post('update-applicant-interview/{cvapplicant_no_pk}', [CVController::class, 'updateInterviewStatus'])->name('update-applicant-interview');

        //Increament Policy
        Route::get('increment-promotion-policy',  [HRMIncreamentPolicyController::class, 'incrementPromotionPolicy'])->name('increment-promotion-policy');
        Route::post('store-increament-policy',  [HRMIncreamentPolicyController::class, 'storeIncreamentPromotionPolicy'])->name('store-increament-policy');
        Route::get('due-increment-work-list',  [HRMIncreamentPolicyController::class, 'dueIncreamentWorkList'])->name('due-increment-work-list');
        Route::post('search-employee-due-increament',  [HRMIncreamentPolicyController::class, 'searchEmployeeDueIncreament'])->name('search-employee-due-increament');
        Route::post('employee_increament_store',  [HRMIncreamentPolicyController::class, 'employeeIncreamentStore'])->name('employee_increament_store');
        Route::get('increment-processing-work-list',  [HRMIncreamentPolicyController::class, 'increamentProcessingWorklist'])->name('increment-processing-work-list');
        Route::post('remove-employee-increament-processing',  [HRMIncreamentPolicyController::class, 'removeEmployeeIncreamentProcessing'])->name('remove-employee-increament-processing');
        Route::post('search-employee-increament-processing',  [HRMIncreamentPolicyController::class, 'searchEmployeeIncreamentProcessing'])->name('search-employee-increament-processing');
        Route::get('v1/award-letter-print/{id}', [HRMIncreamentPolicyController::class, 'awardLetterPrint'])->name('award-letter-print');
        Route::get("v1/increament-approve/{id}", [HRMIncreamentPolicyController::class, 'increamentApprove'])->name('increament-approve');
        Route::post('employee_increament_approve_store',  [HRMIncreamentPolicyController::class, 'employeeIncreamentApproveStore'])->name('employee_increament_approve_store');

        // Routes for Promotion by duration
        Route::get('promotion_work_list', [PromotionController::class, 'due_promotion_work_list'])->name('promotion_work_list');
        Route::post('search_promotion_work_list', [PromotionController::class, 'search_promotion_work_list'])->name('search_promotion_work_list');
        Route::post('promotion_trans_store', [PromotionController::class, 'promotion_trans_store'])->name('promotion_trans_store');

        // Routes for HR selection
        Route::get('create-job-circular', [HRMSelectionController::class, 'jobCircularCreate'])->name('create-job-circular');
        Route::post('store-job-circular', [HRMSelectionController::class, 'jobCircularStore'])->name('store-job-circular');
        Route::get('job-circulation-work-list', [HRMSelectionController::class, 'jobCircularWorkList'])->name('job-circulation-work-list');
        Route::get('job-circulation-edit/{id}', [HRMSelectionController::class, 'jobCircularEdit'])->name('job-circulation-edit');
        Route::post('job-circulation-search', [HRMSelectionController::class, 'searchJobCircular'])->name('job-circulation-search');
        Route::get('view-all-applicants/{id}', [HRMSelectionController::class, 'viewAllApplicants'])->name('view-all-applicants');
        Route::get('view-circular/{id}', [HRMSelectionController::class, 'viewCircular'])->name('view-circular');
        Route::get('add-applicant/{id}', [HRMSelectionController::class, 'addApplicant'])->name('add-applicant');
        Route::get('applicant-work-list', [HRMSelectionController::class, 'applicantWorkList'])->name('applicant-work-list');
        Route::post('update-applicant-selected-status/{cvapplicant_no_pk?}', [CVController::class, 'updateSelectStatus'])->name('update-applicant-selected-status');

        Route::post('search-applicant-worklist', [HRMSelectionController::class, 'searchApplicant'])->name('search-applicant-worklist');
        Route::get('marking-criteria', [HRMSelectionController::class, 'markingCriteria'])->name('marking-criteria');
        Route::post('save-marking-criteria', [HRMSelectionController::class, 'saveMarkingCriteria'])->name('save-marking-criteria');

        Route::get('update-marking-criteria/{id}', [HRMSelectionController::class, 'updateMarkingCriteria'])->name('update-marking-criteria');
        Route::get('applicant-marks/{id?}/{uid?}', [HRMSelectionController::class, 'applicantMarks'])->name('applicant-marks');
        Route::post('applicant-marks-store', [HRMSelectionController::class, 'applicantMarkSave'])->name('applicant-marks-store');

        Route::get('marking-criteria-find', [HRMSelectionController::class, 'markingDataFind'])->name('marking-criteria-find');
        Route::get('issue-appointment-letter/{id?}', [HRMSelectionController::class, 'issueLetter'])->name('issue-appointment-letter');
        Route::post('letter-issue-save', [HRMSelectionController::class, 'letterIssueSave'])->name('letter-issue-save');
        Route::get('appointment-letter/{id?}', [HRMSelectionController::class, 'appointmentLetter'])->name('appointment-letter');



        //Dashboard & planning
        Route::get('hr-dashboard-planning',  [HRMDashboardPlanningController::class, 'hrDashboardPlanning'])->name('hr-dashboard-planning');


        // Route::get('v1/increment-processing-work-list', function () { remove-employee-increament
        //     return Template::loadView("admin.uhl.increment-processing-work-list");
        // })->name('v1.increment-processing-work-list');

        // Route::get('v1/due-increment-work-list', function () {
        //     return Template::loadView("admin.uhl.due-increment-work-list");
        // })->name('v1.due-increment-work-list');

        // Route::get('loan-list',  [HRMLoanRequestController::class, 'loanList'])->name('loan-list');
        // Route::get('loan-request',  [HRMLoanRequestController::class, 'loanRequest'])->name('loan-request');
        // Route::get('edit-loan-request/{loadId}',  [HRMLoanRequestController::class, 'editLoanRequest'])->name('edit-loan-request');
        // Route::post('search-loan-request-list',  [HRMLoanRequestController::class, 'loanRequestListSearch'])->name('search-loan-request-list');

        //HR Template:
        Route::get('hr-letter-templates', [HRMTemplateController::class, 'HrmTemplateMain'])->name('hr-letter-templates');
        Route::post('hr-letter-templates-save', [HRMTemplateController::class, 'saveTemplate'])->name('hr-letter-templates-save');
        Route::get('template_edit', [HRMTemplateController::class, 'editTemplate'])->name('template_edit');
        Route::get('template-parameter/{lettertemp_name?}/{lettertemp_no_fk?}/{lettertemp_uid?}', [HRMTemplateController::class, 'templateParameter'])->name('template-parameter');
        Route::post('hrm-letter-parameter-store', [HRMTemplateController::class, 'templateParameterStore'])->name('hrm-letter-parameter-store');
        Route::post('hrm_letter_delete_parameter', [HRMTemplateController::class, 'templateParameterDelete'])->name('hrm_letter_delete_parameter');
        Route::get('letter_template_worklist', [HRMTemplateController::class, 'templateList'])->name('letter_template_worklist');
        Route::post('search_letter_work_list', [HRMTemplateController::class, 'searchTemplateList'])->name('search_letter_work_list');

        Route::get('hrm-prepare-letter', [HRMTemplateController::class, 'templatePrepare'])->name('hrm-prepare-letter');
        Route::post('get-letter-type', [HRMTemplateController::class, 'getTemplateType'])->name('get-letter-type');
        Route::post('get-applicant', [HRMTemplateController::class, 'getApplicantList'])->name('get-applicant');
        Route::get('template_generate', [HRMTemplateController::class, 'templateGenerateData'])->name('template_generate');
        Route::post('save-generate-letter', [HRMTemplateController::class, 'templateGeneratSave'])->name('save-generate-letter');
        Route::post('letter-templates-pdf', [HRMTemplateController::class, 'templateGeneratePdf'])->name('letter-templates-pdf');
        Route::get('letter_preview/{letterpreview?}', [HRMTemplateController::class, 'templatePreview'])->name('letter_preview');

        Route::post('get-person-type', [HRMTemplateController::class, 'getPersonType'])->name('get-person-type');

        // HR Manpower Requisition
        Route::get('manpower-requisition', [HRMManpowerRequisitionController::class, 'manpowerRequisition'])->name('manpower-requisition');
        Route::post('manpower-requisition-save', [HRMManpowerRequisitionController::class, 'manpowerRequisitionStore'])->name('manpower-requisition-save');
        Route::get('manpowreq-edit', [HRMManpowerRequisitionController::class, 'manpowerRequisitionUpdate'])->name('manpowreq-edit');
        Route::get('manpowreq-worklist', [HRMManpowerRequisitionController::class, 'manpowerRequisitionWorklist'])->name('manpowreq-worklist');
        Route::post('search_hmanpowreq', [HRMManpowerRequisitionController::class, 'manpowerRequisitionSearch'])->name('search_hmanpowreq');
        Route::post('manpowreq-worklist-print', [HRMManpowerRequisitionController::class, 'requisitionWorklistPrint'])->name('manpowreq-worklist-print');
        Route::post('manpowreq-worklist-excel', [HRMManpowerRequisitionController::class, 'requisitionWorklistExcel'])->name('manpowreq-worklist-excel');

        // HR Organogram

        Route::get('create-hr-level', [HRMOrganogramController::class, 'createHrLevel'])->name('create-hr-level');
        Route::post('save-hr-level', [HRMOrganogramController::class, 'saveHrLevel'])->name('save-hr-level');
        Route::get('hr_level_edit', [HRMOrganogramController::class, 'editHrLevel'])->name('hr_level_edit');
        Route::get('hr_level_map_designation', [HRMOrganogramController::class, 'MapwithDesignation'])->name('hr_level_map_designation');
        Route::post('level_map_designation_save', [HRMOrganogramController::class, 'MapwithDesignationSave'])->name('level_map_designation_save');
        Route::get('level_map_designation_edit', [HRMOrganogramController::class, 'MapwithDesignationUpdate'])->name('level_map_designation_edit');
        Route::get('level_map_designation_worklist', [HRMOrganogramController::class, 'levelMapDesignationWorklist'])->name('level_map_designation_worklist');
        Route::post('search_level_map_designation', [HRMOrganogramController::class, 'levelMapDesignationSearch'])->name('search_level_map_designation');
        Route::post('level_map_designation_worklist_print', [HRMOrganogramController::class, 'levelMapDesignationWorklistPrint'])->name('level_map_designation_worklist_print');
        Route::post('level_map_designation_worklist_excel', [HRMOrganogramController::class, 'levelMapDesignationWorklistExcel'])->name('level_map_designation_worklist_excel');
        Route::post('level_map_designation_delete', [HRMOrganogramController::class, 'levelMapDesignationDelete'])->name('level_map_designation_delete');
        Route::get('hr_organogram', [HRMOrganogramController::class, 'HROrganogram'])->name('hr_organogram');


        //HR Employee Separation

        Route::get('application-for-seperation', [HRMEmployeeSeparationController::class, 'SeperationApplication'])->name('application-for-seperation');
        Route::post('seperation-application-save', [HRMEmployeeSeparationController::class, 'SeperationApplicationSave'])->name('seperation-application-save');
        Route::get('employee-seperation', [HRMEmployeeSeparationController::class, 'employeeSeparation'])->name('employee-seperation');
        Route::post('search-seperation-worklist', [HRMEmployeeSeparationController::class, 'employeeSeparationSearch'])->name('search-seperation-worklist');
        Route::post('employee-separation-worklist-print', [HRMEmployeeSeparationController::class, 'SeparationWorklistPrint'])->name('employee-separation-worklist-print');
        Route::post('employee-separation-worklist-excel', [HRMEmployeeSeparationController::class, 'SeparationWorklistExcel'])->name('employee-separation-worklist-excel');
        Route::get('update-emp-separation/{id?}/{save_option?}', [HRMEmployeeSeparationController::class, 'UpdateEmployeeSeparation'])->name('update-emp-separation');


        //Employee Setup
        Route::get('employees.create_v1', [DoctorController::class, 'createEmployeeV1'])->name('employees.create_v1');
        Route::get('employees.list_v1', [EmployeeController::class, 'loadEmployeeListV1'])->name('employees.list_v1');
        Route::post('employees/get-units-by-department', [EmployeeController::class, 'getUnitsByDepartment'])->name('employees.get-units-by-department');
        Route::post('employee_search_v1', [EmployeeController::class, 'employeeSearchV1'])->name('employee_search_v1');

        //Employee Portal

        Route::get('employee-portalv1', [EmployeePortalController::class, 'employeePortal'])->name('employee-portalv1');
        Route::post('store_leave_application', [EmployeePortalController::class, 'storeLeaveApplication'])->name('store_leave_application');
        Route::post('store_alternative_leave_application', [EmployeePortalController::class, 'storeAlternativeLeaveApplication'])->name('store_alternative_leave_application');
        Route::get('leave-edit/{id}', [EmployeePortalController::class, 'leaveEdit'])->name('leave-edit');
        Route::post('delete-leave-application', [EmployeePortalController::class, 'deleteLeaveApplication'])->name('delete-leave-application');
        Route::get('leave_report_for_approval/{id?}', [EmployeePortalController::class, 'leaveReportforApproval'])->name('leave_report_for_approval');
        Route::get('attendance_request_report_for_approval/{id?}', [AttendenceController::class, 'attenRequestReportforApproval'])->name('attendance_request_report_for_approval');
        Route::get('approval-level-tracking-leave-application/{id?}', [EmployeePortalController::class, 'LevelTrackingforLeaveApplication'])->name('approval-level-tracking-leave-application');


        Route::post('my_attendance_search_v1', [EmployeePortalController::class, 'myAttendanceSearchV1'])->name('my_attendance_search_v1');
        Route::get('edit_my_attendance/{requsition_no_pk?}', [EmployeePortalController::class, 'editMyAttendance'])->name('edit_my_attendance');
        Route::post('save-my-attendance', [EmployeePortalController::class, 'saveMyLateAttendance'])->name('save-my-attendance');

        //Attendance list to see HOD
        Route::get('show-employee-attendance', [AttendenceController::class, 'showEmployeeAttendenceforHOD'])->name('show-employee-attendance');
        Route::post('search-attendance-list-for-hod', [AttendenceController::class, 'searchEmployeeAttendenceforHOD'])->name('search-attendance-list-for-hod');

        //Attendance list to see HR
        Route::get('show-employee-attendence-for-hr', [AttendenceController::class, 'showEmployeeAttendenceforHR'])->name('show-employee-attendence-for-hr');
        Route::post('search-attendance-list-for-hr', [AttendenceController::class, 'searchEmployeeAttendenceforHR'])->name('search-attendance-list-for-hr');
        //Manual Attendance
        Route::get('manual-attendancev1', [AttendenceController::class, 'manualAttendanceV1'])->name('manual-attendancev1');
        Route::post('save-manual-attendance', [AttendenceController::class, 'saveManualAttendanceV1'])->name('save-manual-attendance');
        Route::get('check-attendance-date', [AttendenceController::class, 'ceckAttendanceDate'])->name('check-attendance-date');
        Route::get('edit_manual_attendancev1/{requsition_no_pk?}', [AttendenceController::class, 'editManualAttendanceV1'])->name('edit_manual_attendancev1');
        Route::post('manual-attendance-searchv1', [AttendenceController::class, 'searchManualAttendancev1'])->name('manual-attendance-searchv1');
        // Route::get('manual-attendance-listv1', [AttendenceController::class, 'manualAttendanceListV1'])->name('manual-attendance-listv1');
        Route::get('approval-level-tracking/{id?}', [AttendenceController::class, 'approvalLevelTrackingAttendanceRequ'])->name('approval-level-tracking');
        //Manual Leave
        Route::get('manual-leave', [LeaveController::class, 'ManualLeaveHR'])->name('manual-leave');
        Route::post('save-manual-leave', [LeaveController::class, 'SaveManualLeave'])->name('save-manual-leave');
        Route::post('search-manual-leave', [LeaveController::class, 'SearchManualLeave'])->name('search-manual-leave');
        Route::get('manual-leave-edit/{id}', [LeaveController::class, 'ManualLeaveEdit'])->name('manual-leave-edit');

        Route::get('leave-report-worklist', [LeaveController::class, 'LeaveReportWorklist'])->name('leave-report-worklist');
        Route::post('search-leave-report-worklist', [LeaveController::class, 'LeaveReportWorklistSearch'])->name('search-leave-report-worklist');
        Route::post('search-leave-report-pdf-download', [LeaveController::class, 'searchLeaveReportPdfDownload'])->name('search-leave-report-pdf-download');
        //pending leave list
        Route::get('pending-leave-list', [LeaveController::class, 'pendingLeaveList'])->name('pending-leave-list');
        Route::post('search-pending-leave-list', [LeaveController::class, 'searchPendingLeaveList'])->name('search-pending-leave-list');
        Route::post('print-pending-leave-list', [LeaveController::class, 'printPendingLeaveList'])->name('print-pending-leave-list');
        //pre employee report
        Route::get('pre-employee-report', [EmployeeController::class, 'preEmployeeReport'])->name('pre-employee-report');
        Route::post('search-pre-employee', [EmployeeController::class, 'searchPreEmployee'])->name('search-pre-employee');
        Route::get('pre-employee-certificate/{id?}', [EmployeeController::class, 'preEmployeeCertificate'])->name('pre-employee-certificate');
        Route::get('pre-employee-certificate-form/{id?}/{person_id?}/{patient_id?}', [EmployeeController::class, 'preEmployeeCertificateForm'])->name('pre-employee-certificate-form');
        Route::post('store-pre-employee-certificate', [EmployeeController::class, 'storePreEmployeeCertificate'])->name('store-pre-employee-certificate');

        // HOD Assign AL/OT
        Route::get('hod-assign-al-ot', [EmployeeController::class, 'hodAssignAlOt'])->name('hod-assign-al-ot');
        Route::post('search-hod-assign-al-ot', [EmployeeController::class, 'searchHodAssignAlOt'])->name('search-hod-assign-al-ot');
        Route::post('store-hod-assign-al-ot', [EmployeeController::class, 'storeHodAssignAlOt'])->name('store-hod-assign-al-ot');
        Route::get('hod-assign-duty-worklist', [EmployeeController::class, 'hodAssignDutyWorklist'])->name('hod-assign-duty-worklist');
        Route::post('search-hod-assign-duty', [EmployeeController::class, 'searchHodAssignDuty'])->name('search-hod-assign-duty');
    
    });
});
