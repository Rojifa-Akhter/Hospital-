<style>
    .receive_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .receive_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .received_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .received_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .position-center {
        /* margin-bottom: -30px  */
    }

    .yelow {
        border: 1px solid yellow;
        background-color: none !important;
    }

    .pink {
        border: 2px solid pink;
        color: gray !important;
        background-color: pink !important;

    }

    .blue {
        border: 1px solid blue;
        background-color: none !important;
    }

    .allerg {
        background-color: #ff8080;
        color: white;

    }

    .vulnerability {
        background-color: #ffff66;
        color: black;

    }

    .clinical {
        background-color: #ffad33;
        color: white;

    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Nursing Note</h5>
                            <small>IPD / Nursing Note </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="height:85vh">
                        <div class="card-header">Patient Information</div>
                        <div class="card-body">

                            <!-- patient info -->

                            <div class="row">
                                <div class="col-md-4 col-12">


                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Patient
                                                Name</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->patient_name }}
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">UHID</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->patient_code }}
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Patient
                                                Type</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->patient_type_code }}
                                        </div>
                                    </div>


                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">IP No</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->admission_no_pk }}
                                        </div>
                                    </div>



                                </div>



                                <div class="col-md-4 col-12">


                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Bed
                                                No</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->bed_name }}
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Admitting
                                                Doctor</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->primary_doctor_name }}
                                        </div>
                                    </div>



                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Age</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->age }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm"
                                                for="">Gender</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->gender_txt }}
                                        </div>
                                    </div>





                                </div>


                                <div class="col-md-4 col-12">

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Contact
                                                No</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->contact_number }}
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm" for="">Blood
                                                Group</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->blood_group_text }}
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <label class="col-form-label col-form-label-sm"
                                                for="">Address</label>
                                        </div>
                                        <div class="col-6">
                                            : {{ @$patient_data->present_addr }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end patient info -->


                            <!-- Alert -->

                            <div class="row pt-3">
                                @if (@$allergy_alert == 1)
                                    <div class="col-md-4 col-12">
                                        <div class="alert allerg" role="alert">
                                            Allergy Alert!
                                        </div>
                                    </div>
                                @endif

                                @if (@$clinicalcharacteristics >= 4)
                                    <div class="col-md-4 col-12">
                                        <div class="alert vulnerability" role="alert">
                                            Vulnerability Alert!
                                        </div>
                                    </div>
                                @endif

                                @if (!empty(@$vulnerabilityassessment))
                                    <div class="col-md-4 col-12">
                                        <div class="alert clinical" role="alert">
                                            Clinical Alert!
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- Close Alert -->




                            <!-- actions -->
                            <div class="row mt-4 pt-2">
                                <div class="col-12">
                                    <h6 class="text-center">Others Information </h6>
                                </div>
                                <div class="col-md-3">

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.admission-print-pdf', @$patient_data->admission_no_pk) }}"
                                        target="_blank">Face Sheet</a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.patient-assesment', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Doctor Initial Assessment</a>
                                    @if (!isset($patient_data->dob))
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assessment-adult', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nursing Assessment (Adult)</a>
                                    @elseif($patient_data->ward_uid == 'CCU')
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assesment', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nurse Assessment(Critical Care)</a>
                                    @elseif(calculateAgeInDays($patient_data->dob, $patient_data->admission_date) <= 20)
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assessment-neonates', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nursing Assessment (Neonates)</a>
                                    @elseif(calculateAgeInDays($patient_data->dob, $patient_data->admission_date) <= 5840 && $patient_data->ward_uid != 'ICU')
                                        {{-- 5840days = 16 years --}}
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assessment-paediatric', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nursing Assessment (Paediatric)</a>
                                    @elseif(calculateAgeInDays($patient_data->dob, $patient_data->admission_date) > 5840)
                                        {{-- 5840days = 16 years --}}
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assessment-adult', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nursing Assessment (Adult)</a>
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.patient-fall-risk', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Fall Risk</a>

                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.pain-assessment', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Pain Assessment</a>
                                    @elseif(calculateAgeInDays($patient_data->dob, $patient_data->admission_date) <= 5840 && $patient_data->ward_uid == 'ICU')
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nurse-assessment-paediatric-icu', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Nursing Assessment (Paediatric ICU)</a>
                                    @else
                                    @endif





                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-sm"
                                        data-title="Integrated Patient Care Plan & Progress"
                                        data-action="{{ route('v1.ipd.daily-followup', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Patient Care Plan
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Consultant Change"
                                        data-action="{{ route('ipd.consultant-change', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Consultant Change
                                    </a>


                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Refer Doctor"
                                        data-action="{{ route('ipd.refer-doctor', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Refer Doctor
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Integrated Follow Up Notes"
                                        data-action="{{ route('ipd.consultation-note', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Integrated Follow Up Notes
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.nurse-assessment-emergency', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Nursing Assessment (Emergency)</a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('blood-transfusion-reaction-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Blood Transfusion Reaction Form
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('blood-transfusion-order', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Blood Transfusion Order
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('blood-products-transfusion-monitorig-record', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Blood Products Transfusion & Monitoring Record
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('cauti-insertion-maintenance-bundle', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Cauti, Insertion & Maintenance Bundle
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('initial-cardiac-assessment', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Initial Cardiac Assessment
                                    </a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.nicu-flow-sheet-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">NICU Flow Sheet</a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.patient-clinical-records-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Patient Clinical Records</a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.neonatal-clinical-record-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Neonatal Clinical Record</a>



                                </div>
                                <div class="col-md-3">

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.patient-nursing-requisition', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Nursing Requistion</a>


                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        data-modal="common-modal-xl" data-title="Bed Transfer"
                                        data-action="{{ route('v2.ipd.assign-bed', [
                                            'adms_no' => @$patient_data->admission_no_pk,
                                        ]) }}">
                                        Bed Transfer
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.patient-medicine', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Medicine</a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.patient-investigation', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Investigation</a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.patient-investigation-requisition', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Investigation Indent</a>
                                    @if ($patient_data->lock_ind == '')
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('billing.pharmacy-bill-generate', $patient_data->admission_uid) }}"
                                            rel="tab">Floor Stock Bill</a>
                                    @endif


                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                        href="{{ route('ipd.patient-discharge-lma-checklist', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Discharge/LMA/Death Check List</a>
                                    @if ($patient_data->dis_ind == 0)
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                            href="{{ route('ipd.blood-bank-requisition', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                            rel="tab">Blood Bank Requisition</a>
                                    @endif

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Consultant Visit Note"
                                        data-action="{{ route('ipd.nurse-special-note', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Consultant Visit Note
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Problem List"
                                        data-action="{{ route('ipd.problem-list-note', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Problem List
                                    </a>

                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.doctor-shift-handover-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Doctor Shift Handover</a> --}}

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Doctor Shift Handover Bundle"
                                        data-action="{{ route('doctor-handover-bundle', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Doctor Shift Handover
                                    </a>

                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.investigation-request-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">IPD Investigation Request</a> --}}
                                  <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('nursing-initial-assessment-gynaecology', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Nursing Initial Assessment(Obstetrics & Gynaecology)</a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="OT/Procedure Note"
                                        data-action="{{ route('ipd.ot-procedure-note', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        OT/Procedure Note
                                    </a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.patient-discharge-diet-chart-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Patient Discharge Diet Chart</a>


                                </div>
                                <div class="col-md-2">

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('v2.ipd.input-diet', [@$patient_data->patient_no_fk, @$patient_data->admission_no_pk]) }}"
                                        rel="tab" target="_blank">Diet Request
                                    </a>

                                    @if ($patient_data->dis_ind == 0 && $patient_data->dis_req_ind == 0)
                                        <a style="cursor:pointer" class="btn btn-md  pink w-100 text-white mt-1"
                                            title="Discharge the Patient"
                                            onclick="dischargeRequest({{ $patient_data->admission_no_pk }})">
                                            Discharge Request
                                        </a>
                                    @endif

                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-info w-100 text-white mt-1"
                                        data-id="{{ @$patient_data->admission_no_pk }}"
                                        data-action="{{ route('v2.ipd.patient-history-form', @$patient_data->admission_no_pk) }}"
                                        data-modal="common-modal-xl" data-title="Patient History">
                                        Patient History
                                    </a> --}}

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        data-id="{{ @$patient_data->admission_no_pk }}"
                                        data-action="{{ route('v2.patient-death-certificate-report', @$patient_data->admission_uid) }}"
                                        data-modal="common-modal-md" data-title="Death Certificate">
                                        Death Certificate
                                    </a>



                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Glucose Monitoring Chart"
                                        data-action="{{ route('ipd.glucose-monitoring-chart', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Glucose Monitorong Chart
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Intake-Output Chart"
                                        data-action="{{ route('ipd.intake-output-chart', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Intake-Output Chart
                                    </a>

                                    {{-- ICU Form --}}

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Progress Note"
                                        data-action="{{ route('ipd.progress-note', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Progress Note
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.crp-doc-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">CPR Documentation</a>
                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.central-line-insertion-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Central Line Insertion</a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.ventilator-associated-events-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Ventilator Bundle</a> --}}
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.hemodialysis-record-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">HemoDialysis Record</a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.referral-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Referral Form
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('icu.doc-inhouse-transfer-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Doctors In-House Transfer
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Critical Test Result"
                                        data-action="{{ route('icu-critical-test-result', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Critical Test Result
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('counseling-form-critical-care', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Counselling Form Critical Care
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('sicu-investigation-chart', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">SICU Investigation Chart
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('indoor-dialysis-order', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Indoor Dialysis Order
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.epidural-monitoring-chart', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Epidural Monitoring Chart
                                    </a>


                                    {{-- <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Indwelling Urinary Catheter Checklist"
                                        data-action="{{ route('indwelling-urinary-catheter-checklist', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Indwelling Urinary Catheter
                                    </a> --}}



                                </div>
                                <div class="col-md-2">
                                    <a style="cursor:pointer;"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Vital Sign"
                                        data-action="{{ route('ipd.vital-entry', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Vital Sign
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Skin Care Plan"
                                        data-action="{{ route('ipd.skin-care-plan', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Skin Care Plan
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Nursing Care Plan"
                                        data-action="{{ route('ipd.nursing-care-plan', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Nursing Care Plan
                                    </a>

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Patient Movement"
                                        data-action="{{ route('ipd.patient-movement', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Patient Movement
                                    </a>


                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Nursing Endorsement"
                                        data-action="{{ route('ipd.nursing-endorsement', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Nursing Endorsement
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('ipd.emergency-discharge-summary', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Emergency Discharge Summary
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('adult-emergency-dept', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">ADULT Emergency Dept. Clinical
                                    </a>
                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('adult-emergency-dept-sepsis', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">ADULT Emergency Dept. Sepsis
                                    </a>
                                    {{-- CATH LAB FORMS --}}
                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('without-sedation-cath-lab', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Procedure Sheet Without Sedation-Cath Lab
                                    </a> --}}

                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-md" data-title="Procedure Sheet Without Sedation-Cath Lab"
                                        data-action="{{ route('ipd.procedure-sheet-without-sedation-cathlab-list', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Procedure Sheet Without Sedation-Cath Lab
                                    </a>

                                    <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('under-sedation-cath-lab', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                        rel="tab">Procedure Sheet Under Sedation-Cath Lab
                                    </a>



                                    {{-- <a style="cursor:pointer"
                                        class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                        href="{{ route('v2.ipd.invasive-lines-tubes-drains', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk]) }}"
                                        rel="tab">Invasive Lines</a> --}}
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="DAILY CHECK LIST CRASH CART"
                                        data-action="{{ route('ipd.daily-checklist-crash-cart', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Daily Checklist Crash Cart
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="DAILY CHECK FOR REFRIGERATOR"
                                        data-action="{{ route('ipd.daily-check-refrigerator', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Daily Check For Refrigerator
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="DAILY CHECKLIST FOR TEMPERATURE & HUMIDITY"
                                        data-action="{{ route('ipd.daily-check-temp-humidity', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Daily Checklist For Temperature & Humidity
                                    </a>

                                </div>

                                <div class="col-md-2">

                                    @inject('otcheck', 'App\Http\Controllers\OTController')

                                    @php
                                        $otCheck = $otcheck->getOTCheckData($patient_data->admission_no_pk);
                                    @endphp

                                    @if ($otCheck === null)
                                        <div class="alert alert-warning text-center mt-2">
                                            Not Admitted Patient
                                        </div>
                                    @elseif (!$otCheck)
                                        <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                            href="{{ route('ipd.ot-requsition', [$patient_data->patient_no_fk, $patient_data->admission_uid]) }}"
                                            rel="tab">
                                            OT Requisition
                                        </a>
                                        <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('emr.patient-emr', [@$patient_data->patient_no_fk]) }}"
                                            rel="tab">EMR</a>
                                    @else
                                        <button class="btn btn-md btn-secondary w-100 text-white mt-1 px-0" disabled>
                                            OT Already Requested or In Progress
                                        </button>
                                    @endif
                                    @if ($patient_data->lock_ind == '')
                                        <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                            href="{{ route('uhl.billing-invoice-form', ['0' . '-' . $patient_data->admission_no_pk . '-ipd']) }}"
                                            rel="tab">
                                          Service  Billing
                                        </a>
                                    @endif

                                    <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                        href="{{ route('ipd.pre-operative-checklist', [$patient_data->admission_no_pk, $patient_data->patient_no_fk]) }}"
                                        target="_blank">
                                        Pre-operative Checklist
                                    </a>
                                    <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                        href="{{ route('ipd.consultant-bill', [$patient_data->patient_no_fk, $patient_data->admission_no_pk]) }}"
                                        target="_blank">
                                        Cunsultant Bill
                                    </a>

                                    <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                        href="{{ route('ipd.ipd-discharge-summary', [$patient_data->admission_no_pk]) }}"
                                        target="_blank">
                                        Discharge Summary
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-sm" data-title="ICU Bundle Forms"
                                        data-action="{{ route('icu-bundle-list', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Bundle
                                    </a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.surgical-prevention-bundle-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Surgical Site Infection Prevention Bundle</a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="Laryngoscope Checklist"
                                        data-action="{{ route('ipd.laryngoscope-checklist-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Laryngoscope Cheklist
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="DAILY CHECK LIST FOR ECG MACHINE"
                                        data-action="{{ route('ipd.daily-checklist-ecg-machine', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Daily Checklist ECG Machine
                                    </a>
                                    <a style="cursor:pointer"
                                        class="btn btn-md btn-primary w-100 text-white mt-1 open-modal"
                                        data-modal="common-modal-xl" data-title="DAILY CHECKLIST FOR B-TYPE OXYGEN CYLINDER"
                                        data-action="{{ route('ipd.btype-oxyzen-cylinder-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}">
                                        Daily Checklist for B-Type Oxygen Cylinder
                                    <a class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0"
                                        href="{{ route('ipd.ipd-final-bill-print-v2', [$patient_data->admission_no_pk]) }}"
                                        target="_blank">
                                        Details Bill
                                    </a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.haemodialysis-unit-personal-data-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Haemodialysis Unit Personal Data</a>
                                    <a style="cursor:pointer"
                                            class="open-modal btn btn-md btn-primary w-100 text-white mt-1"
                                            href="{{ route('ipd.haemodialysis-unit-treatment-worksheet-form', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"
                                            rel="tab">Haemodialysis Unit Treatment Worksheet</a>











                                    {{-- <a style="cursor:pointer" class="open-modal btn btn-md btn-primary w-100 text-white mt-1 px-0" href="{{ route('ipd.ot-requsition', [@$patient_data->patient_no_fk, @$patient_data->admission_uid]) }}"  rel="tab">OT Requsition</a>
                                         --}}

                                    {{-- <a style="cursor:pointer" class="open-modal btn btn-md btn-primary w-100 text-white mt-1" href="{{route('ipd.nurse-assessment-paediatric-icu', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk])}}"  rel="tab">Nursing Assessment (Paediatric ICU)</a>
                                        <a style="cursor:pointer" class="open-modal btn btn-md btn-primary w-100 text-white mt-1" href="{{route('ipd.nurse-assessment-paediatric', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk])}}"  rel="tab">Nursing Assessment (Paediatric)</a>
                                        <a style="cursor:pointer" class="open-modal btn btn-md btn-primary w-100 text-white mt-1" href="{{route('ipd.nurse-assessment-adult', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk])}}"  rel="tab">Nursing Assessment (Adult)</a>
                                        <a style="cursor:pointer" class="open-modal btn btn-md btn-primary w-100 text-white mt-1" href="{{route('ipd.nurse-assessment-neonates', ['patient_id' => @$patient_data->patient_no_fk, 'admission_uid' => @$patient_data->admission_no_pk])}}"  rel="tab">Nursing Assessment (Neonates)</a> --}}
                                </div>




                            </div>
                            <!--close actions -->



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    //  $("body").addClass("sidebar-collapse");
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function dischargeRequest(admissionNoPk) {
        if (!confirm("Are you sure?")) {
            return false;
        }

        $.ajax({
            type: 'post',
            data: {
                admission_no_pk: admissionNoPk,
            },
            url: "{{ route('v2.ipd.patient-discharge-request') }}",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                location.reload(true);
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(data) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error.message);
                $.unblockUI();
            }
        })
    }
</script>
