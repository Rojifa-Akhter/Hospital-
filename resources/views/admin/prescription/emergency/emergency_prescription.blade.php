<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style type="text/css">
    #prescription_engin input.form-control,
    #prescription_engin select.form-control {
        height: calc(1em + 0.75rem + 0px) !important;
    }

    #prescription_engin .col-form-label-sm,
    #prescription_engin {
        font-size: .75rem;
    }

    #prescription_engin .card {
        border: 0 !important;
    }

    #pres-favourit-list {
        font-size: .75rem;
    }

    #pres-favourit-list td {
        background-color: #ECF0F5;
        border-top: 2px solid #fff;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        padding: 1px 10px !important;
    }

    .dataTables_filter {
        display: none;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    #presc_details .fa {
        font-size: 9px;
    }

    #presc_details .fa-star:hover {
        color: #38c172 !important;
    }

    .details_header {
        font-size: 11px;
    }

    .dropdown-item {
        padding: 0.25rem 1rem;
    }

    .dropdown-menu {
        padding: 0.5rem 0 0 0;
    }

    .alert-dismissible .close {
        padding: 0.05rem .5rem;
    }

    #dental-teeth-con .list-group .list-group-item {
        padding: 3px 5px !important;
        cursor: pointer;
        color: #fff;
    }

    .list-group-item-navy {
        background-color: #004B7B;
        transition: background-color 0.3s ease;
    }

    .list-group-item-blue {
        background-color: #007FD2;
        transition: background-color 0.3s ease;
    }

    .list-group-item-selected {
        background-color: #34B369
    }

    #dental-teeth-con .list-group .list-group-item:hover {
        background-color: #34B369;
    }

    #dental-teeth-con .list-group .list-group-item div {
        background-color: rgba(77, 171, 247, .7);
    }

    .data-table-inv.dataTable tbody th,
    .data-table-inv.dataTable tbody td {
        padding: 1px 10px !important;
    }

    #path_con_info {
        display: none;
    }

    .gyncology_clinical_history {
        padding-right: 30px;
        position: relative;
    }

    .gyncology_clinical_history_btn {
        position: absolute;
        top: 8px;
        right: 10px;
        /* transform: translateY(-50%); */
    }
</style>
@php
    $department_id = '';

@endphp
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0">Emergency Prescription
                </h5>
                <small>Emergency / Emergency Prescription</small>
            </div>
            <div class="col-8">

            </div>
        </div>

        <form method="post" id="frm-pat-prescription" action="{{ route('pres-opd-save-update') }}" autocomplete="off"
            onsubmit="">

            @csrf
            <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" />
            <input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id" />
            <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
            <input type="hidden" id="hdn_service_id" name="hdn_service_id" />
            <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" />
            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id"
                value="{{ isset($doctor_info->person_no_pk) ? $doctor_info->person_no_pk : 0 }}" />
            @if ($department_id != '')
                <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="{{ $department_id }}" />
            @endif
            <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                value="{{ $department_id == '' ? 1 : 0 }}" />
            <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                value="{{ !empty($su_info) ? $su_info->dental_ind : 0 }}" />
            <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                value="{{ !empty($su_info) ? $su_info->eye_ind : 0 }}" />
            <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="" />
            <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" />
            <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                value="{{ route('physiotherapy.load-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                value="{{ route('lookup-pres-data-autocomplete') }}" />
            <input type="hidden" id="hdn_add_pres_favourit_url" value="{{ route('add-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_interaction_url" value="{{ route('presc-interaction') }}" />
            <div class="row border-bottom-dark">

                @if ($department_id == '')
                    <div class="form-row mt-1 mb-1 w-100">
                        <div class="col">
                            <select class="custom-select" name="su_no" id="su_no" required='required'>
                                <option value="">Select Department</option>
                                @if (!empty($su_arr))
                                    @foreach ($su_arr as $su_row)
                                        <option value="{{ $su_row->serviceunit_no_pk }}"
                                            data-dental-ind="{{ $su_row->dental_ind }}"
                                            data-eye-ind="{{ $su_row->eye_ind }}"
                                            @if (Session::get('user.su_pk_no') == $su_row->serviceunit_no_pk) selected @endif>
                                            {{ $su_row->serviceunit_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col">
                            <input type="text" class="form-control bg-white" id="patient_id" name="service_id"
                                value="" placeholder="Search Patient By Service ID/ Name / Phone NO."
                                data-emr-route="{{ route('emr.patient-emr') }}"
                                title="Search Patient By Service ID/ Name / Phone NO."
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="patient_id" id="hdn_patient_id">
                            {{-- <span class="badge badge-primary cursor-pointer open-modal patient_entry"
                            data-modal="common-modal-md" data-action="#" data-title="Patient Registration Form">+ Add
                            New</span> --}}
                            <span class="badge badge-primary cursor-pointer open-modal patient_entry"
                                data-modal="common-modal-md"
                                data-action="{{ route('registration.quickcreate', 'BILL') }}"
                                data-title="Patient Registration Form">+ Add New</span>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="doctor_name" name="doctor_name"
                                value="{{ isset($doctor_info->full_name) ? $doctor_info->full_name : '' }}"
                                placeholder="Search Doctor By Name / Phone NO. / SPL."
                                title="Search Doctor By Name / Phone NO. / Specialization"
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="doctor_id" id="doctor_id"
                                value="{{ isset($doctor_info->person_no_pk) ? $doctor_info->person_no_pk : 0 }}">

                            <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm"
                                data-id="1" data-action="{{ route('doctor.createquickregistration', 'EMERG') }}"
                                data-title="Add new Doctor (Referral)">
                                + Add New </span>

                        </div>
                        <div class="col">

                            <select class="custom-select" name="cmb_external_hospital">
                                @if (!empty($po_hospital_details))
                                    @foreach ($po_hospital_details as $hrow)
                                        <option value="{{ $hrow->hospital_no_pk }}">{{ $hrow->hospital_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" autocomplete="off" class="form-control form-control-sm date_picker"
                                id="date_pic" name="pres_date" value="" placeholder="Order Date">
                            <span class="focus_input"></span>
                        </div>
                    </div>
                @endif
                {{-- @if ($department_id != '')
                <div class="col-md-12 col-lg-5 col-sm-12 p-1 bg-white border-right">
                    <div class="card border-0">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pending"
                                        role="tab" aria-controls="home" aria-selected="true">
                                        Pending &nbsp;
                                        <span class="badge badge-warning"></span>
                                    </a>
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#completed" role="tab"
                                        aria-controls="home" aria-selected="true">
                                        Completed &nbsp;
                                        <span class="badge badge-success">{{ $prescription_ind }}</span>
                                    </a>
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#absent" role="tab"
                                        aria-controls="home" aria-selected="true">
                                        Absent &nbsp;
                                        <span class="badge badge-danger">{{ $absent_ind }}</span>
                                    </a>
                                    <div class="ml-auto">
                                        <input type="text" class="form-control" style="margin-bottom: 0 !important;"
                                            id="txtSearchPat" placeholder="Search Patient" aria-label="PatientName"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent"
                            style="max-height: 147px; overflow-y: auto;">
                            <div class="tab-pane fade show active border-bottom" id="pending" role="tabpanel"
                                aria-labelledby="pending-tab">
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left"></th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($appointment_rs))
                                        @php $i = 1; @endphp
                                        @foreach ($appointment_rs as $row)
                                        @if ($row->prescription_no_pk == '')
                                        @php
                                        if ($row->priority == 'Urgent') {
                                        $bg_class = 'btn-outline-danger';
                                        } elseif ($row->priority == 'VIP') {
                                        $bg_class = 'btn-outline-info';
                                        } else {
                                        $bg_class = 'btn-outline-success';
                                        }
                                        @endphp
                                        @if ($row->appoint_status == 1)
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;">{{ $row->slot_sl }}</span>
                                            </td>
                                            <td class="text-left p-1 w-5 bg-light border-right">
                                                <span
                                                    class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                    style="font-size:10px;">{{ $row->priority }}</span>
                                            </td>
                                            <td class="text-left p-1">
                                                {{ $row->patient_name }}
                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    data-presc="{{ $row->prescription_no_pk }}"
                                                    data-dtls-action="{{ route('get-prev-prescription-dtls', $row->patient_no_pk) }}"
                                                    data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Create New Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>
                                                <input type="hidden" name="" id="patapp_hdn"
                                                    value="{{ $row->appoint_no_pk }}">
                                                <span
                                                    class="btn btn-outline-danger btn-sm bg-none cursor-pointer patapp_absent">
                                                    A
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        @php $i++; @endphp
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade border-bottom" id="completed" role="tabpanel"
                                aria-labelledby="completed-tab">
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left"></th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($appointment_rs))
                                        @php $i = 1; @endphp
                                        @foreach ($appointment_rs as $row)
                                        @if ($row->prescription_no_pk != '')
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;">{{ $row->slot_sl }}</span>
                                            </td>
                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                <span class="btn btn-outline-info btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px; width: 50px;">{{ $row->priority }}</span>
                                            </td>
                                            <td class="text-left p-1">
                                                {{ $row->patient_name }}
                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    data-presc="{{ $row->prescription_no_pk }}"
                                                    data-dtls-action="{{ route('get-prescription-dtls', $row->prescription_no_pk) }}"
                                                    data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Edit Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>
                                                <a href="{{ route('opd_prescription_print_pdf', $row->prescription_no_pk) }}"
                                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    target="_blank" data-id="{{ $row->prescription_no_pk }}"
                                                    title="Print Prescription"><i class="fa fa-file-pdf"></i></a>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="absent" role="tabpanel" aria-labelledby="absent-tab">
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left"></th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($appointment_rs))
                                        @php $i = 1; @endphp
                                        @foreach ($appointment_rs as $row)
                                        @if ($row->prescription_no_pk == '')
                                        @php
                                        if ($row->priority == 'Urgent') {
                                        $bg_class = 'btn-outline-danger';
                                        } elseif ($row->priority == 'VIP') {
                                        $bg_class = 'btn-outline-info';
                                        } else {
                                        $bg_class = 'btn-outline-success';
                                        }
                                        @endphp
                                        @if ($row->appoint_status == 3)
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;">{{ $row->slot_sl }}</span>
                                            </td>
                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                <span
                                                    class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                    style="font-size:10px;">{{ $row->priority }}</span>
                                            </td>
                                            <td class="text-left bg-none p-1">
                                                {{ $row->patient_name }}
                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    data-presc="{{ $row->prescription_no_pk }}"
                                                    data-dtls-action="{{ route('get-prev-prescription-dtls', $row->patient_no_pk) }}"
                                                    data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Create New Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>

                                            </td>
                                        </tr>
                                        @endif
                                        @php $i++; @endphp
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                @endif --}}
                <div class="col-md-6 col-lg-6 col-sm-12 p-1 bg-white border-right">
                    <div class="card border-0">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <h6>Prescribed patient list</h6>
                                    <div class="ml-auto">
                                        <input type="text" class="form-control"
                                            style="margin-bottom: 0 !important;" id="txtSearchPat"
                                            placeholder="Search Patient" aria-label="PatientName"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent"
                            style="max-height: 204px; overflow-y: auto;">
                            <div class="tab-pane fade show active border-bottom" id="pending" role="tabpanel"
                                aria-labelledby="pending-tab">
                                @if (Session::get('user.ses_hospital_code') == 'IMPERIAL')
                                    @include('admin.prescription.doctor_emergency_prescription_search')
                                @endif
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-left">Date</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientContainer">
                                        @include('admin.prescription.completed_emergency_prescription')
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="tab-pane fade border-bottom" id="completed" role="tabpanel"
                                aria-labelledby="completed-tab">
                                @include('admin.prescription.doctor_prescription_search')
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left"></th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientContainer">
                                        @include('admin.prescription.completed_prescription')
                                    </tbody>
                                </table>
                            </div> --}}

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 p-2 bg-white">
                    <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6>
                    <div class="card mt-0">
                        <div class="card-body pl-3 pr-3">
                            <div class="row border">
                                <div class="col-md-12 col-lg-12 col-sm-12 p-1 bg-navy  border-bottom">
                                    <div id="">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name" class="pl-2"></td>
                                                <td id="patient_gender" style="width:209px"></td>
                                                <td id="patient_age" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="patient_img"
                                                    data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('images/doc-1.png') }}" width="30"
                                                        alt="">
                                                </td>
                                            </tr>
                                            <tr>

                                                <td id="blood_group" class="pl-2"></td>
                                                <td id="patient_mobile" class="pl-2"></td>
                                            </tr>
                                            {{-- <tr>
                                                <td id="patient_mobile" class="pl-2"></td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                </div>



                                {{-- Added for DMHL --}}
                                {{-- <div class="col-md-12 col-lg-6 col-sm-12 p-1 bg-navy border-right border-bottom">
                                    <div id="patient_info">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name_other" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="ref_patient_img"
                                                    data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('img/doc-1.png') }}" width="30" alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age_other" class="pl-2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div> --}}

                                <div
                                    class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-right border-bottom pl-1">
                                    <input type="hidden" id="chronic-route"
                                        value="{{ route('add-chronic-disease') }}">
                                    <input type="hidden" id="chronic-route-save"
                                        value="{{ route('store-chronic-disease') }}">
                                    <input type="hidden" id="chronic-route-delete"
                                        value="{{ route('delete-chronic-disease') }}">
                                    <strong>Chronic Disease:</strong> <span id="chronic_con"></span>
                                    <input type="hidden" class="form-control" id="chrn-items" name="chrn_items" />
                                    <input type="hidden" class="form-control" id="chronic_text"
                                        name="chronic_text" />
                                    <span class="cursor-pointer float-right mt-1"
                                        onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm"
                                        data-action="{{ route('add-chronic-disease') }}"
                                        title="Add New Chronic Disease" style="font-size: 9px;"> <i
                                            class="fa fa-plus"></i> </span>
                                </div>
                                <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-bottom pl-1">
                                    <strong>Allergy:</strong> <span id="allergy_con"></span>
                                    <span class="cursor-pointer float-right open-modal mt-1"
                                        data-modal="common-modal-md" data-action="{{ route('add-allergy') }}"
                                        title="Add New Allergy" data-title="Add New Allergy" style="font-size: 9px;">
                                        <i class="fa fa-plus"></i> </span>
                                </div>



                                {{-- Added For DMHL --}}


                                <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                                    <div class="card mt-0">
                                        <div class="card-body pb-2">
                                            <div class="table-responsive">
                                                <table class="table border-0 m-0">
                                                    <thead>
                                                        <tr class="border-0">
                                                            <th class="p-0 px-1 border-0">Pulse(bpm)</th>
                                                            <th class="p-0 px-1 border-0 w-20">BP (mmHg)</th>
                                                            <th class="p-0 px-1 border-0">Temperature (°F)</th>
                                                            @if (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                                                <th class="p-0 px-1 border-0">Height</th>
                                                                <th class="p-0 px-1 border-0">Weight</th>
                                                            @else
                                                                <th class="p-0 px-1 border-0">Height (inch)</th>
                                                                <th class="p-0 px-1 border-0">Weight (kg)</th>
                                                            @endif
                                                            <th class="p-0 px-1 border-0">OFC</th>
                                                            @if (Session::get('user.serviceunit_code') != 'PAEDIATRIC')
                                                                <th class="p-0 px-1 border-0">BMI (kg/m <sup>2</sup>)
                                                                </th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="border-0">
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_pulse" name="txt_pulse"
                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pulse_val : '' }}">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bp_sys" name="txt_bp_sys"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_sys : '' }}">
                                                                    &nbsp; / &nbsp;
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bp_dia" name="txt_bp_dia"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_dia : '' }}">
                                                                </div>

                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_temperature" name="txt_temperature"
                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->temp_val : '' }}">
                                                            </td>
                                                            @if (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                                                <td class="p-0 px-1 border-0">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="txt_height" name="txt_height"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->height_val : '' }}">
                                                                        <select
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="height_unit" name="height_unit"
                                                                            style="width: 116px">
                                                                            <option value="inch">inch</option>
                                                                            <option value="cm">cm</option>
                                                                        </select>

                                                                    </div>
                                                                </td>
                                                                <td class="p-0 px-1 border-0">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="txt_weight" name="txt_weight"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->weight_val : '' }}">
                                                                        <select
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="weight_unit" name="weight_unit"
                                                                            style="width: 90px">
                                                                            <option value="kg">kg</option>
                                                                            <option value="gm">gm</option>
                                                                        </select>

                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_height" name="txt_height"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->height_val : '' }}">
                                                                </td>
                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_weight" name="txt_weight"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->weight_val : '' }}">
                                                                </td>
                                                            @endif
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_ofc" name="txt_ofc"
                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->ofc : '' }}">
                                                            </td>
                                                            @if (Session::get('user.serviceunit_code') != 'PAEDIATRIC')
                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bmi" name="txt_bmi"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bmi : '' }}">
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                {{-- for alied start --}}
                                                {{-- {{dd($pat_vitals_rs)}} --}}
                                                {{-- {{dd(Session::get('user.serviceunit_code'))}} --}}
                                                @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                                    @if (Session::get('user.serviceunit_code') == 'GYNOB')
                                                        <table class="table border-0 m-0">
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0 px-1 border-0">SFH</th>
                                                                    <th class="p-0 px-1 border-0 w-20">FM</th>
                                                                    <th class="p-0 px-1 border-0">FHS</th>
                                                                    <th class="p-0 px-1 border-0">PR</th>
                                                                    <th class="p-0 px-1 border-0">LIQ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="border-0">
                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="sfh" name="sfh"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->sfh : '' }}">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="fm" name="fm"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->fm : '' }}">
                                                                    </td>
                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="fhs" name="fhs"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->fhs : '' }}">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="pr" name="pr"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pr : '' }}">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="hq" name="hq"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->hq : '' }}">
                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    @elseif (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                                        <table class="table border-0 m-0">
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0 px-1 border-0">RR(breath/min)</th>
                                                                    <th class="p-0 px-1 border-0">SPO2 (%)</th>
                                                                    <th class="p-0 px-1 border-0">Colour</th>
                                                                    <th class="p-0 px-1 border-0 w-20">Lung</th>
                                                                    <th class="p-0 px-1 border-0">Heart</th>
                                                                    <th class="p-0 px-1 border-0">Abdomen</th>
                                                                    <th class="p-0 px-1 border-0">Red Eye Reflex</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="border-0">
                                                                    @if (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                                                        <td class="p-0 px-1 border-0">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm m-0 p-0"
                                                                                id="rr_val" name="rr_val"
                                                                                value="{{ isset($pat_vitals_rs) ? $pat_vitals_rs->rr : '' }}">
                                                                        </td>

                                                                        <td class="p-0 px-1 border-0">
                                                                            <input type="number"
                                                                                class="form-control form-control-sm m-0 p-0"
                                                                                id="spo2_val" name="spo2_val"
                                                                                value="{{ isset($pat_vitals_rs) ? $pat_vitals_rs->spo2 : '' }}"
                                                                                style="width:74px">
                                                                        </td>
                                                                    @endif
                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="color" name="color"
                                                                            value="">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="lung" name="lung"
                                                                            value="">
                                                                    </td>
                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="txt_heart_rate" name="txt_heart_rate"
                                                                            value="">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="abdomen" name="abdomen"
                                                                            value="">
                                                                    </td>

                                                                    <td class="p-0 px-1 border-0">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="red_eye_reflex" name="red_eye_reflex"
                                                                            value="">
                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                        {{-- for alied stop --}}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 bg-none">
                        <div class="card-body" id="presc_details">
                            @include('admin.prescription.prescription_details_doctor_wise')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="examination_modal" role="dialog" aria-labelledby="history_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">Clinical Examination</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-body">
                    @if (!empty($clinical_arr))
                        @if (count($clinical_arr) != 0)
                            @foreach ($clinical_arr as $clinical => $clinical_dtl)
                                <div class="row">
                                    <div class="col-md-12">
                                        <b>{{ $clinical }}</b>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="test345">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @if (!empty($clinical_dtl))
                                                @foreach ($clinical_dtl as $clinical_item)
                                                    @php
                                                        $input_type = isset($clinical_item->input_type)
                                                            ? $clinical_item->input_type
                                                            : 'text';
                                                    @endphp
                                                    @if ($i == 0)
                                                        <div class="col-md-2">

                                                        </div>
                                                    @endif
                                                    <div class="col-md-2">
                                                        <p>{{ $clinical_item->detail_name }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="{{ $input_type }}"
                                                            class="form-control item_dtl_val" name="item_dtl_val[]">
                                                        <input type="hidden" class="form-control item_name "
                                                            name="item_name[]"
                                                            value="{{ $clinical_item->detail_name }}">
                                                        <input type="hidden" class="form-control lookup_id"
                                                            name="item_name[]"
                                                            value="{{ $clinical_item->pres_lookupdata_no_pk }}">
                                                        <input type="hidden" class="form-control lookup_code"
                                                            name="lookup_code[]"
                                                            value="{{ $clinical_item->pres_lookup_code }}">
                                                        <input type="hidden" class="form-control lookupdata_code"
                                                            name="lookupdata_code[]" value="{{ $clinical }}">

                                                    </div>

                                                    @php
                                                        $i++;
                                                        if ($i == 2) {
                                                            $i = 0;
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-danger">No Setup Data Available </p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer py-1">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"
                            onclick="saveExamination()">Save</button>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="history_of_objective_modal" role="dialog" aria-labelledby="history_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    @if (!empty($history_arr))
                        @foreach ($history_arr as $history => $history_dtl)
                            <div class="row">
                                <div class="col-md-12">
                                    <b>{{ $history }}</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="row" id="test123">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @if (!empty($history_dtl))
                                            @foreach ($history_dtl as $history_item)
                                                @php
                                                    $input_type = isset($history_item->input_type)
                                                        ? $history_item->input_type
                                                        : 'text';
                                                @endphp
                                                @if ($i == 0)
                                                    <div class="col-md-2">

                                                    </div>
                                                @endif
                                                <div class="col-md-1">
                                                    <p>{{ $history_item->detail_name }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="{{ $input_type }}"
                                                        class="form-control item_dtl_val" name="item_dtl_val[]">
                                                    <input type="hidden" class="form-control item_name "
                                                        name="item_name[]" value="{{ $history_item->detail_name }}">
                                                    <input type="hidden" class="form-control lookup_id"
                                                        name="item_name[]"
                                                        value="{{ $history_item->pres_lookupdata_no_pk }}">
                                                    <input type="hidden" class="form-control lookup_code"
                                                        name="lookup_code[]"
                                                        value="{{ $history_item->pres_lookup_code }}">
                                                    <input type="hidden" class="form-control lookupdata_code"
                                                        name="lookupdata_code[]" value="{{ $history }}">

                                                </div>

                                                @php
                                                    $i++;
                                                    if ($i == 2) {
                                                        $i = 0;
                                                    }
                                                @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer py-1">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"
                            onclick="saveMenstrual()">Save</button>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('prescription-lookup.storeprescriptionlookupitemdoctor') }}" method="post"
                id="prescription-create">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                                class="col-form-label col-form-label-sm">Label</label>
                            <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                            <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                                value="" placeholder="Enter new option" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                            onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    var PresFunc = {
        emrPrescribedPatientList: function(thisElement) {
            var search_date_from = $('#search_date_from').val();
            var search_date_to = $('#search_date_to').val();
            var action = $(thisElement).attr("data-action");
            $.ajax({
                data: {
                    search_date_from: search_date_from,
                    search_date_to: search_date_to
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    // $(thisElement).parents("#myTab").siblings("#myTabContent").html(data);
                    $("#patientContainer").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }


    function patientFunc() {

    }
    $(document).on('click', '.remove_allergy', function() {
        event.preventDefault();
        var allergy_id = $(this).attr("data-allergyid");
        if (confirm("Are you sure")) {
            $(this).closest('span').remove();
            $.ajax({
                data: {
                    allergy_id: allergy_id
                },
                url: "{{ route('prescription.allergy-data-delete') }}",
                type: "post",
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    console.log('delete done');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
        event.stopImmediatePropagation();

    });
    $('body').on('keyup', '#txt_height', function() {
        let height_to_meter = $(this).val() != "" ? $(this).val() * 0.0254 : 0;
        let weight = $('#txt_weight').val();
        let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#txt_bmi').val(bmi.toFixed(1));
    })

    $('body').on('keyup', '#txt_weight', function() {
        let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.0254 : 0;
        let weight = $(this).val();
        let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#txt_bmi').val(bmi.toFixed(1));
    })

    openPatientAutocomplete('#patient_id', 'hdn_patient_id', function(item, obj) {
        var patient_info_route = "{{ route('prescription.get-patient-info') }}";

        var dtls_action = "{{ route('get-prev-prescription-dtls', ':id') }}";
        var dtlsAction = dtls_action.replace(':id', item.patient_id);
        prescriptionFunc.getPatientDetails(item.patient_id, patient_info_route, dtlsAction);
        obj.stopImmediatePropagation();
    });

    $(document).on("click", ".patapp_absent", function(e) {
        var patapp_id = $(this).siblings('#patapp_hdn').val();
        if (confirm("Are you sure")) {
            $.ajax({

                data: {
                    patapp_id: patapp_id
                },
                url: "{{ route('prescription.appointment-absent') }}",
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    var riderect_action = $("#hdn_current_url").val();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("Absent successful");
                    dynamicFunc.afterSaveLoadPage(riderect_action);
                },

                complete: function() {
                    /*$(".data-table").DataTable({
                    	"ordering": false,
                    	"bPaginate": false,
                    	"bLengthChange": false,
                    	"bInfo": false,
                    	"bAutoWidth": false
                    });*/
                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();

    })

    openDoctorAutocomplete("#doctor_name", "hdn_doctor_id", '', '', function(item, obj) {
        $("#hdn_su_no").val(item.serviceunit_id);
        obj.stopImmediatePropagation();
    });

    $(document).ready(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        var patTable = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "bAutoWidth": false
        });
        $(document).on("keyup", '#txtSearchPat', function() {
            patTable.search($(this).val()).draw();
        });

        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $(document).on("keyup", "#template_name", function(e) {
            $("#template_msg").html("");
            $(this).removeClass("is-invalid");
        });

        $(document).on("click", "#btn_emr", function(e) {
            var hdn_patient_id = $("#hdn_patient_id").val();
            console.log(hdn_patient_id);
            if (hdn_patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                return;
            } else {
                var hdn_patient_id = $("#hdn_patient_id").val();
                window.open("{{ route('emr.patient-emr') }}/" + hdn_patient_id, "_blank");
                return;
            }


        });

        $(document).on('show.bs.dropdown', '.btn_template', function() {
            var doctor_id = $("#hdn_doctor_id").val();
            var hdn_patient_id = $("#hdn_patient_id").val();
            if (hdn_patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                return;
            }

            $("#template-container").html('<div class="d-flex justify-content-center"></div>');
            $.ajax({
                async: true,
                data: {
                    doctor_id: doctor_id
                },
                url: "{{ route('prescription-templates', 2) }}",
                type: "get",
                beforeSend: function() {
                    $("#template-container div").html(
                        '<i class="spinner-border spinner-border-sm"></i>');
                },
                success: function(data) {
                    $("#template-container").html(data);
                }
            });
        });

        $(document).on("change", "#cmb_type", function(e) {
            var type = $(this).find(':selected').val();
            if (type == "DLRG") {
                $('#allergy_con .twitter-typeahead').removeClass('d-none');
                $('#cmb_allergy').addClass('d-none');
            } else {
                $('#allergy_con .twitter-typeahead').addClass('d-none');
                $('#cmb_allergy').removeClass('d-none');
            }
            //$('#medicine_item').typeahead();
        });

        $(document).on("change", "#hdn_su_no", function(e) {
            var hdn_su_no = $(this).val();
            $("#hdn_dental_ind").val($(this).find(":selected").attr("data-dental-ind") * 1);
            $("#hdn_eye_ind").val($(this).find(":selected").attr("data-eye-ind") * 1);

            var dtls_action = "{{ route('get-prev-prescription-dtls', 0) }}";
            prescriptionFunc.prescriptionDetails(hdn_su_no, dtls_action);
        });
    });

    $(document).on('keyup', '#doctor_name', function() {
        if ($(this).val() == "") {
            $('#hdn_doctor_id').val('');
        }
    })



    // for emergency 
    $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    let patientIdFromUrl = urlParams.get('patient_id') || window.location.pathname.split('/').slice(-3, -2)[0];
    const admissionIdFromUrl = window.location.pathname.split('/').slice(-2, -1)[0];
    let doctorIdFromUrl = window.location.pathname.split('/').pop();

    // Ensure doctorIdFromUrl is treated as an integer
    doctorIdFromUrl = parseInt(doctorIdFromUrl, 10);  // Convert to integer

    // Check if doctorIdFromUrl is a valid number (integer)
    if (isNaN(doctorIdFromUrl)) {
        console.log('Doctor ID is not a valid integer:', doctorIdFromUrl);
        return;  // Exit early if doctorIdFromUrl is not a valid integer
    }

    console.log('Patient ID from URL:', patientIdFromUrl);
    console.log('Admission ID from URL:', admissionIdFromUrl);
    console.log('Doctor ID from URL:', doctorIdFromUrl);

    // Handle patient ID auto-fill and selection
    if (patientIdFromUrl) {
        $('#patient_id').val(patientIdFromUrl);
        $('#patient_id').trigger('input');
        $('#patient_id').focus();

        setTimeout(function() {
            var firstSuggestion = $('.tt-suggestion').first();
            if (firstSuggestion.length > 0) {
                firstSuggestion.trigger('mouseover');
                firstSuggestion.trigger('click');
            }
        }, 500);
    }

    // Handle doctor name auto-fill and selection
    if (doctorIdFromUrl) {
        // Set the value of the doctor_name input
        $('#doctor_name').val(doctorIdFromUrl);
        $('#doctor_name').trigger('input');
        $('#doctor_name').focus();

        // AJAX request using the doctorIdFromUrl
        $.ajax({
            url: '{{route("doctor-name-find")}}',  // Replace with the actual URL where you want to fetch doctor details
            method: 'POST',
            data: { doctor_id: doctorIdFromUrl },  // Pass the integer doctorId
            success: function(response) {
                console.log('Doctor data fetched successfully:', response);
                // Assuming the response contains the doctor's name and other info
                if (response) {
                    $('#doctor_name').val(response);  // Set the doctor's name if returned from the API
                }
                
                // Trigger the input event again for typeahead to show suggestions
                $('#doctor_name').trigger('input');

                // Wait for suggestions to appear and select the first one
                setTimeout(function() {
                    var firstSuggestion = $('.tt-suggestion').first();
                    if (firstSuggestion.length > 0) {
                        firstSuggestion.trigger('mouseover');
                        firstSuggestion.trigger('click');
                    }
                }, 500);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching doctor data:', error);
            }
        });
    }

    // Handle admission ID auto-fill
    if (admissionIdFromUrl) {
        $('#hdn_admission_id').val(admissionIdFromUrl);
        console.log('Admission ID set:', admissionIdFromUrl);
    } else {
        console.log('No Admission ID found in URL.');
    }

    // Handle doctor ID auto-fill
    if (doctorIdFromUrl) {
        $('#hdn_doctor_id').val(doctorIdFromUrl);
    }

    // Handle selection of patient ID from autocomplete
    $('#patient_id').on('typeahead:selected', function(event, item) {
        console.log('Selected patient:', item);
        $('#hdn_patient_id').val(item.patient_id);
        $('#hdn_admission_id').val(item.admission_no_pk);
    });

    // Handle selection of doctor name from autocomplete
    $('#doctor_name').on('typeahead:selected', function(event, item) {
        console.log('Selected doctor:', item);
        $('#hdn_doctor_id').val(item.doctor_id);
    });
});




</script>
