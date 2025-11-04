@extends('iCure-Home.admin.partials.cover_master')
@section('admin_content')
    <style type="text/css">
        /*#prescription_engin input.form-control,
                        #prescription_engin select.form-control {
                            height: calc(1em + 0.75rem + 0px) !important;
                            }*/

        #prescription_engin .col-form-label-sm,
        #prescription_engin {
            font-size: .75rem;
        }

        #prescription_engin .card {
            border: 0 !important;
            margin-bottom: 3px;
            border-radius: 0px;
        }

        #pres-favourit-list {
            font-size: .75rem;
        }

        #pres-favourit-list td {
            background-color: #ECF0F5;
            border-top: 2px solid #fff;
        }

        #pres-favourit-list td {
            background-color: #00a79d;
            border-top: 2px solid #fff;
            padding: 6px 10px !important;
            color: #fff;
        }

        #pres-favourit-list tr td:first-child {
            border-radius: 4px 0px 0px 4px;
        }

        #pres-favourit-list tr td:last-child {
            border-radius: 0px 4px 4px 0px;
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


        .tabs-menu-body {
            border: 0px;
        }

        .patients_symptoms_info .card-body>.form-group {
            border: 1px solid #ebecf1;
        }

        .patients_symptoms_info .card-body>.form-group input.form-control {
            border: 0px;
            /*border-bottom: 1px solid #ebecf1;*/
            border-radius: 8px;
            overflow: hidden;
        }

        .patients_symptoms_info .list-unstyled li {
            padding: 5px;
        }

        .patients_symptoms_info .list-unstyled li:last-child {
            border-bottom: 0px;
        }

        .patients_symptoms_info .list-unstyled li:first-child {
            border-top: 1px solid #ebecf1;
        }

        select.form-control:not([size]):not([multiple]) {
            height: 1.95rem;
            font-size: 12px;
        }

        .app-content .side-app {
            padding: 12px 0px !important;
        }

        table tr td {
            vertical-align: middle !important;
        }

        .form-control {
            color: #090909;
            opacity: 1;
            height: 1.95rem;
            font-size: 12px;
        }

        .form-control:focus {
            border-color: #38cb89;
        }

        .list-unstyled li {
            border-bottom: 1px solid #ebecf1;
            padding: 5px 10px;
            background-color: azure;
            color: #000;
        }

        .list-unstyled li:last-child {
            border-bottom: 0px;
        }

        .margin_bottom {
            margin-bottom: 5px !important;
        }

    </style>

    <section id="prescription_engin">
        <div class="container-fluid">
            <!--Page header-->
            <div class="page-header shadow-sm">
                <div class="page-leftheader">
                    <h4 class="page-title">Prescription Engine</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fe fe-grid mr-2 fs-14"></i> Doctor</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Prescription </a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Prescription Engine</a></li>
                    </ol>
                </div>
                <div class="page-rightheader">
                    <div class="btn btn-list">
                        <a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add New</a>
                    </div>
                </div>
            </div>
            <!--End Page header-->

            <form method="post" id="frm-pat-prescription" action="{{ route('pres-opd-save-update') }}" autocomplete="off"
                onsubmit="">
                @csrf
                <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" />
                <input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id" />
                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                <input type="hidden" id="hdn_service_id" name="hdn_service_id" />
                <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id" />
                @if ($department_id != '')
                    <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="{{ $department_id }}" />
                @endif
                <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                    value="{{ $department_id == '' ? 1 : 0 }}" />
                <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                    value="{{ !empty($su_info) ? $su_info->dental_ind : 0 }}" />
                <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                    value="{{ !empty($su_info) ? $su_info->eye_ind : 0 }}" />
                <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="{{ $room_id }}" />
                <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" />
                <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                    value="{{ route('physiotherapy.load-pres-favourit-list') }}" />
                <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                    value="{{ route('lookup-pres-data-autocomplete') }}" />
                <input type="hidden" id="hdn_add_pres_favourit_url" value="{{ route('add-pres-favourit-list') }}" />
                <input type="hidden" id="hdn_interaction_url" value="{{ route('presc-interaction') }}" />


                <div class="card">
                    <div class="card-body p-0">
                        <div class="form-row border-bottom-dark">
                            <div class="col-md-12 col-lg-6 col-sm-12">
                                <div class="card mb-0" style="box-shadow: initial;">
                                    <div class="card-body p-0 border-0">
                                        <div class="panel panel-primary tabs-style-3">
                                            <div class="panel panel-primary">
                                                <div class=" tab-menu-heading p-0 bg-light">
                                                    <div class="tabs-menu1 ">
                                                        <ul class="nav panel-tabs align-items-center">
                                                            <li><a href="#pending" class="active"
                                                                    data-toggle="tab">Pending &nbsp;<span
                                                                        class="badge badge-warning">{{ $pending_ind }}</span></a>
                                                            </li>
                                                            <li><a href="#completed" data-toggle="tab">Completed <span
                                                                        class="badge badge-success">{{ $prescription_ind }}</span></a>
                                                            </li>
                                                            <li><a href="#absent" data-toggle="tab">Absent &nbsp;<span
                                                                        class="badge badge-danger">{{ $absent_ind }}</span></a>
                                                            </li>
                                                            <li class="ml-auto">
                                                                <div class="mr-1">
                                                                    <input type="text" class="form-control"
                                                                        style="margin-bottom: 0 !important;"
                                                                        id="txtSearchPat" placeholder="Search Patient"
                                                                        aria-label="PatientName"
                                                                        aria-describedby="basic-addon1">
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="panel-body tabs-menu-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active " id="pending">
                                                            <table class="table  table-hover m-0">
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
                                                                        @php $i = 1; @endphp @foreach ($appointment_rs as $row)
                                                                            @if ($row->prescription_no_pk == '')

                                                                                @php
                                                                                $bg_class ='';
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
                                                                                        <td
                                                                                            class="text-center p-1 bg-light border-right">
                                                                                            <span
                                                                                                class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                                                style="font-size: 10px;">{{ $row->slot_sl }}</span>
                                                                                        </td>
                                                                                        <td
                                                                                            class="text-left p-1 w-5 bg-light border-right">
                                                                                            <span
                                                                                                class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                                                                style="font-size: 10px;">Routine</span>
                                                                                        </td>
                                                                                        <td class="text-left p-1">
                                                                                            {{ $row->patient_name }}
                                                                                        </td>
                                                                                        <td
                                                                                            class="text-center p-1 bg-light">
                                                                                            <span
                                                                                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                                                data-presc="{{ $row->prescription_no_pk }}"
                                                                                                data-dtls-action="{{ route('get-prev-prescription-dtls-web-portal', $row->patient_no_pk) }}"
                                                                                                data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                                                                onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                                                                title="Create New Prescription">
                                                                                                <i
                                                                                                    class="fa fa-prescription"></i>
                                                                                            </span>
                                                                                            <input type="hidden" name=""
                                                                                                id="patapp_hdn"
                                                                                                value="{{ $row->appoint_no_pk }}" />
                                                                                            <span
                                                                                                class="btn btn-outline-danger btn-sm bg-none cursor-pointer patapp_absent">A</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @php $i++; @endphp @endif
                                                                        @endforeach @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane " id="completed">
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
                                                                        @php $i = 1; @endphp @foreach ($appointment_rs as $row)
                                                                            @if ($row->prescription_no_pk != '')
                                                                                <tr>
                                                                                    <td
                                                                                        class="text-center p-1 bg-light border-right">
                                                                                        <span
                                                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                                            style="font-size: 10px;">{{ $row->slot_sl }}</span>
                                                                                    </td>
                                                                                    <td
                                                                                        class="text-left p-1 w-8 bg-light border-right">
                                                                                        <span
                                                                                            class="btn btn-outline-info btn-sm bg-none cursor-pointer"
                                                                                            style="font-size: 10px; width: 50px;">{{ $row->priority }}</span>
                                                                                    </td>
                                                                                    <td class="text-left p-1">
                                                                                        {{ $row->patient_name }}
                                                                                    </td>
                                                                                    <td class="text-center p-1 bg-light">
                                                                                        <span
                                                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                                            data-presc="{{ $row->prescription_no_pk }}"
                                                                                            data-dtls-action="{{ route('get-prescription-dtls', $row->prescription_no_pk) }}"
                                                                                            data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                                                            title="Edit Prescription"><i
                                                                                                class="fa fa-prescription"></i>
                                                                                        </span>
                                                                                        <a href="{{ route('opd_prescription_print_pdf', $row->prescription_no_pk) }}"
                                                                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                                            target="_blank"
                                                                                            data-id="{{ $row->prescription_no_pk }}"
                                                                                            title="Print Prescription">
                                                                                            <i class="fa fa-file-pdf"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                @php $i++; @endphp
                                                                            @endif
                                                                        @endforeach @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane " id="absent">
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
                                                                        @php $i = 1; @endphp @foreach ($appointment_rs as $row)
                                                                            @if ($row->prescription_no_pk == '')
                                                                                @phpif ($row->priority == 'Urgent') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $bg_class = 'btn-outline-danger';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } elseif ($row->priority == 'VIP') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $bg_class = 'btn-outline-info';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $bg_class = 'btn-outline-success';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } @endphp  @if ($row->appoint_status == 3)
                                                                                    <tr>
                                                                                        <td
                                                                                            class="text-center p-1 bg-light border-right">
                                                                                            <span
                                                                                                class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                                                style="font-size: 10px;">{{ $row->slot_sl }}</span>
                                                                                        </td>
                                                                                        <td
                                                                                            class="text-left p-1 w-8 bg-light border-right">
                                                                                            <span
                                                                                                class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                                                                style="font-size: 10px;">{{ $row->priority }}</span>
                                                                                        </td>
                                                                                        <td class="text-left bg-none p-1">
                                                                                            {{ $row->patient_name }}
                                                                                        </td>
                                                                                        <td
                                                                                            class="text-center p-1 bg-light">
                                                                                            <span
                                                                                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                                                data-presc="{{ $row->prescription_no_pk }}"
                                                                                                data-dtls-action="{{ route('get-prev-prescription-dtls-web-portal', $row->patient_no_pk) }}"
                                                                                                data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                                                                onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                                                                title="Create New Prescription">
                                                                                                <i
                                                                                                    class="fa fa-prescription"></i>
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @php $i++; @endphp @endif
                                                                        @endforeach @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6 col-sm-12">
                                <div class="card mt-0" style="box-shadow: initial;">
                                    <div class="card-header bg-light" style="min-height: 2.8rem;">
                                        <h6 class="card-title">Patient Details</h6>
                                    </div>
                                    <div class="card-body p-0 px-3 pb-4">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-6 col-sm-12 border-right border-bottom">
                                                <div id="patient_info">
                                                    <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                                        <tr>
                                                            <td id="patient_name" class="pl-2"></td>
                                                            <td rowspan="2" width="30" class="p-2"
                                                                id="patient_img"
                                                                data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                                <img src="{{ asset('images/doc-1.png') }}" width="30"
                                                                    alt="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td id="patient_age" class="pl-2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="patient_mobile" class="pl-2"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-6 col-sm-12 border-right border-bottom">
                                                <div id="patient_info">
                                                    <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                                        <tr>
                                                            <td id="patient_name_other" class="pl-2"></td>
                                                            <td rowspan="2" width="30" class="p-2"
                                                                id="ref_patient_img"
                                                                data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                                <img src="{{ asset('img/doc-1.png') }}" width="30"
                                                                    alt="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td id="patient_age_other" class="pl-2"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-12 col-sm-12 border-right border-bottom">
                                                <input type="hidden" id="chronic-route"
                                                    value="{{ route('add-chronic-disease') }}">
                                                <input type="hidden" id="chronic-route-save"
                                                    value="{{ route('store-chronic-disease') }}">
                                                <input type="hidden" id="chronic-route-delete"
                                                    value="{{ route('delete-chronic-disease') }}">
                                                <strong>Chronic Disease:</strong> <span id="chronic_con"></span>
                                                <input type="hidden" class="form-control" id="chrn-items"
                                                    name="chrn_items" />
                                                <span class="cursor-pointer float-right mt-1"
                                                    onclick="prescriptionFunc.addChronicItem(this)"
                                                    data-modal="common-modal-sm"
                                                    data-action="{{ route('add-chronic-disease') }}"
                                                    title="Add New Chronic Disease" style="font-size: 9px;"> <i
                                                        class="fa fa-plus"></i> </span>
                                            </div>

                                            <div class="col-md-6 col-lg-12 col-sm-12 border-bottom">
                                                <strong>Allergy:</strong> <span id="allergy_con"></span>
                                                <span class="cursor-pointer float-right open-modal mt-1"
                                                    data-modal="common-modal-md" data-action="{{ route('add-allergy') }}"
                                                    title="Add New Allergy" data-title="Add New Allergy"
                                                    style="font-size: 9px;"> <i class="fa fa-plus"></i> </span>
                                            </div>

                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table border-0 m-0">
                                                        <thead>
                                                            <tr class="border-0">
                                                                <th class="p-0 px-1 border-0">Pulse</th>
                                                                <th class="p-0 px-1 border-0 w-20">BP</th>
                                                                <th class="p-0 px-1 border-0">Temperature</th>
                                                                <th class="p-0 px-1 border-0">Height</th>
                                                                <th class="p-0 px-1 border-0">Weight</th>
                                                                <th class="p-0 px-1 border-0">OFC</th>
                                                                <th class="p-0 px-1 border-0">BMI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="border-0">
                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_pulse" name="txt_pulse"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pulse_val : '' }}">
                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            style="padding: 0px 5px !important;"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="txt_bp_sys" name="txt_bp_sys"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_sys : '' }}">
                                                                        &nbsp; <span style="font-size: 20px;"> /
                                                                        </span>&nbsp;
                                                                        <input type="text"
                                                                            style="padding: 0px 5px !important;"
                                                                            class="form-control form-control-sm m-0 p-0"
                                                                            id="txt_bp_dia" name="txt_bp_dia"
                                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_dia : '' }}">
                                                                    </div>

                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_temperature" name="txt_temperature"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->temp_val : '' }}">
                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_height" name="txt_height"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->height_val : '' }}">
                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_weight" name="txt_weight"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->weight_val : '' }}">
                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_ofc" name="txt_ofc"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->ofc : '' }}">
                                                                </td>

                                                                <td class="p-0 px-1 border-0">
                                                                    <input type="text" style="padding: 0px 5px !important;"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bmi" name="txt_bmi"
                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bmi : '' }}">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
                        <div class="border-0 bg-none"
                            style="background-color: #fff;border-bottom: 3px solid #d5d5d5 !important;">
                            <div class="p-3">
                                <div class="form-row">
                                    <div class="col-md-12 col-lg-6 col-sm-12" id="cc-con">
                                        <div class="card-body p-0">
                                            <div class="form-group margin_bottom">
                                                @php $action_url = route('physiotherapy.load-pres-favourit-list-web-portal'); @endphp
                                                <input type="text" class="form-control mb-0" id="cheif_complaint"
                                                    name="cheif_complaint" placeholder="Enter Chief Complaints"
                                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'CHIEFCOM','CC','#chfcom', '{{ $action_url }}')"
                                                    data-lookup-id="{{ $lookup_id_arr->CHIEFCOM }}"
                                                    data-lookup-code="CHIEFCOM">
                                                <div class="card m-0 bg-none" style="box-shadow: initial;">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0" id="chfcom">
                                                            @if (!empty($cc_arr))
                                                                @foreach ($cc_arr as $rows)
                                                                    @foreach ($rows as $row)
                                                                        @php
                                                                            $row_data = explode('_', $row);
                                                                        @endphp
                                                                        <li id="item-{{ $row_data[0] }}">
                                                                            <input type="hidden" name="item_id[]"
                                                                                value="{{ $row_data[0] != 0 ? $row_data[0] : '' }}"
                                                                                readonly="readonly">
                                                                            <input class="left-element" type="hidden"
                                                                                name="item_name[]"
                                                                                value="{{ $row_data[1] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_id[]"
                                                                                value="{{ $row_data[2] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_code[]"
                                                                                value="CHIEFCOM" readonly="readonly">
                                                                            <input type="hidden" name="lookupdata_code[]"
                                                                                value="{{ $row_data[3] }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class='' id=''
                                                                                name='unit_intensity[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='no_of_session[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_mu[]'>
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                            {{ $row_data[1] }}&nbsp;&nbsp;
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)"><i
                                                                                    class="fa fa-times"></i></span>&nbsp;
                                                                            @if ($row_data[0] != 0)
                                                                                <span
                                                                                    class="float-right text-secondary mr-1 cursor-pointer"
                                                                                    style="font-size:11px;"
                                                                                    title="Add To Favourite List"
                                                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                                    data-url="{{ $add_to_pres_url }}"
                                                                                    data-id="{{ $row_data[0] }}"
                                                                                    data-name="{{ $row_data[1] }}"
                                                                                    data-type="CHIEFCOM"><i
                                                                                        class="fa fa-star text-primary"></i></span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6 col-sm-12" id="cc-con">
                                        <div class="card-body p-0">
                                            <div class="form-group margin_bottom">
                                                <input type="text" class="form-control mb-0" id="history_of_objective"
                                                    name="history_of_objective" placeholder="Enter Clinical History"
                                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'CLINICHIST','Clinical History','#ho', '{{ $action_url }}')"
                                                    data-lookup-id="{{ $lookup_id_arr->CLINICHIST }}"
                                                    data-lookup-code="CLINICHIST">
                                                <div class="card m-0 bg-none" style="box-shadow: initial;">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0" id="ho">
                                                            @if (!empty($ch_arr))
                                                                @foreach ($ch_arr as $rows)
                                                                    @foreach ($rows as $row)
                                                                        @php
                                                                            $row_data = explode('_', $row);
                                                                        @endphp
                                                                        <li id="item-{{ $row_data[0] }}">
                                                                            <input type="hidden" name="item_id[]"
                                                                                value="{{ $row_data[0] }}"
                                                                                readonly="readonly">
                                                                            <input class="left-element" type="hidden"
                                                                                name="item_name[]"
                                                                                value="{{ $row_data[1] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_id[]"
                                                                                value="{{ $row_data[2] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_code[]"
                                                                                value="CLINICHIST" readonly="readonly">
                                                                            <input type="hidden" name="lookupdata_code[]"
                                                                                value="{{ $row_data[3] }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class='' id=''
                                                                                name='unit_intensity[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='no_of_session[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_mu[]'>
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                            {{ $row_data[1] }}&nbsp;&nbsp;
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)"><i
                                                                                    class="fa fa-times"></i></span>&nbsp;
                                                                            @if ($row_data[0] != 0)
                                                                                <span
                                                                                    class="float-right text-secondary mr-1 cursor-pointer"
                                                                                    style="font-size:11px;"
                                                                                    title="Add To Favourite List"
                                                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                                    data-url="{{ $add_to_pres_url }}"
                                                                                    data-id="{{ $row_data[0] }}"
                                                                                    data-name="{{ $row_data[1] }}"
                                                                                    data-type="CLINICHIST"><i
                                                                                        class="fa fa-star text-primary"></i></span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12" id="cc-con">
                                        <div class="card-body p-0">
                                            <div class="form-group margin_bottom">
                                                <input type="text" class="form-control mb-0" id="provisional_diag"
                                                    name="provisional_diag" placeholder="Enter Clinical Examination"
                                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'PROVDIAG','Clinical Examination','#prov_diag', '{{ $action_url }}')"
                                                    data-lookup-id="{{ $lookup_id_arr->PROVDIAG }}"
                                                    data-lookup-code="PROVDIAG">
                                                <div class="card m-0 bg-none" style="box-shadow: initial;">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0" id="prov_diag">
                                                            @if (!empty($pd_arr))
                                                                @foreach ($pd_arr as $rows)
                                                                    @foreach ($rows as $row)
                                                                        @php
                                                                            $row_data = explode('_', $row);
                                                                        @endphp
                                                                        <li id="item-{{ $row_data[0] }}">
                                                                            <input type="hidden" name="item_id[]"
                                                                                value="{{ $row_data[0] }}"
                                                                                readonly="readonly">
                                                                            <input class="left-element" type="hidden"
                                                                                name="item_name[]"
                                                                                value="{{ $row_data[1] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_id[]"
                                                                                value="{{ $row_data[2] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_code[]"
                                                                                value="PROVDIAG" readonly="readonly">
                                                                            <input type="hidden" name="lookupdata_code[]"
                                                                                value="{{ $row_data[3] }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class='' id=''
                                                                                name='unit_intensity[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='no_of_session[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_mu[]'>
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                            {{ $row_data[1] }}&nbsp;&nbsp;
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)"><i
                                                                                    class="fa fa-times"></i></span>&nbsp;
                                                                            @if ($row_data[0] != 0)
                                                                                <span
                                                                                    class="float-right text-secondary mr-1 cursor-pointer"
                                                                                    style="font-size:11px;"
                                                                                    title="Add To Favourite List"
                                                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                                    data-url="{{ $add_to_pres_url }}"
                                                                                    data-id="{{ $row_data[0] }}"
                                                                                    data-name="{{ $row_data[1] }}"
                                                                                    data-type="PROVDIAG"><i
                                                                                        class="fa fa-star text-primary"></i></span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6 col-sm-12" id="cc-con">
                                        <div class="card-body p-0">
                                            <div class="form-group margin_bottom">
                                                <input type="text" class="form-control mb-0" id="desease" name="desease"
                                                    placeholder="Enter Diagnosis"
                                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'DISEASE','Disease','#desease_con', '{{ $action_url }}')"
                                                    data-lookup-id="{{ $lookup_id_arr->DISEASE }}"
                                                    data-lookup-code="DISEASE">
                                                <div class="card m-0 bg-none" style="box-shadow: initial;">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0" id="desease_con">
                                                            @if (!empty($ds_arr))
                                                                @foreach ($ds_arr as $rows)
                                                                    @foreach ($rows as $row)
                                                                        @php
                                                                            $row_data = explode('_', $row);
                                                                        @endphp
                                                                        <li id="item-{{ $row_data[0] }}">
                                                                            <input type="hidden" name="item_id[]"
                                                                                value="{{ $row_data[0] }}"
                                                                                readonly="readonly">
                                                                            <input class="left-element" type="hidden"
                                                                                name="item_name[]"
                                                                                value="{{ $row_data[1] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_id[]"
                                                                                value="{{ $row_data[2] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_code[]"
                                                                                value="DISEASE" readonly="readonly">
                                                                            <input type="hidden" name="lookupdata_code[]"
                                                                                value="{{ $row_data[3] }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class='' id=''
                                                                                name='unit_intensity[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='no_of_session[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_mu[]'>
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                            {{ $row_data[1] }}&nbsp;&nbsp;
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)"><i
                                                                                    class="fa fa-times"></i></span>&nbsp;
                                                                            @if ($row_data[0] != 0)
                                                                                <span
                                                                                    class="float-right text-secondary mr-1 cursor-pointer"
                                                                                    style="font-size:11px;"
                                                                                    title="Add To Favourite List"
                                                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                                    data-url="{{ $add_to_pres_url }}"
                                                                                    data-id="{{ $row_data[0] }}"
                                                                                    data-name="{{ $row_data[1] }}"
                                                                                    data-type="DISEASE"><i
                                                                                        class="fa fa-star text-primary"></i></span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-6 col-sm-12" id="cc-con">
                                        <div class="card-body p-0">
                                            <div class="form-group margin_bottom">
                                                <input type="text" class="form-control mb-0" id="icd" name="icd"
                                                    placeholder="Enter Confirmatory Diagnosis (ICD)"
                                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'ICD','icd','#icd_con', '{{ $action_url }}')"
                                                    data-lookup-id="{{ !empty($lookup_id_arr->ICD) ? $lookup_id_arr->ICD : '' }}"
                                                    data-lookup-code="ICD">
                                                <div class="card m-0 bg-none">
                                                    <div class="card-body p-0">
                                                        <ul class="list-unstyled mb-0" id="icd_con">
                                                            @if (!empty($icd_arr))
                                                                @foreach ($icd_arr as $rows)
                                                                    @foreach ($rows as $row)
                                                                        @php
                                                                            $row_data = explode('_', $row);
                                                                        @endphp
                                                                        <li id="item-{{ $row_data[0] }}">
                                                                            <input type="hidden" name="item_id[]"
                                                                                value="{{ $row_data[0] }}"
                                                                                readonly="readonly">
                                                                            <input class="left-element" type="hidden"
                                                                                name="item_name[]"
                                                                                value="{{ $row_data[1] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_id[]"
                                                                                value="{{ $row_data[2] }}"
                                                                                readonly="readonly">
                                                                            <input type="hidden" name="lookup_code[]"
                                                                                value="ICD" readonly="readonly">
                                                                            <input type="hidden" name="lookupdata_code[]"
                                                                                value="{{ $row_data[3] }}"
                                                                                readonly="readonly">
                                                                            <input type='hidden' class='' id=''
                                                                                name='unit_intensity[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_duration[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='no_of_session[]'>
                                                                            <input type='hidden' class='' id=''
                                                                                name='session_mu[]'>
                                                                            <i class="fa fa-angle-double-right"></i>
                                                                            {{ $row_data[1] }}&nbsp;&nbsp;
                                                                            <span
                                                                                class="float-right text-danger cursor-pointer"
                                                                                title="Remove This Item"
                                                                                onclick="removeParentElement(this)"><i
                                                                                    class="fa fa-times"></i></span>&nbsp;
                                                                            @if ($row_data[0] != 0)
                                                                                <span
                                                                                    class="float-right text-secondary mr-1 cursor-pointer"
                                                                                    style="font-size:11px;"
                                                                                    title="Add To Favourite List"
                                                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                                                    data-url="{{ $add_to_pres_url }}"
                                                                                    data-id="{{ $row_data[0] }}"
                                                                                    data-name="{{ $row_data[1] }}"
                                                                                    data-type="ICD"><i
                                                                                        class="fa fa-star text-primary"></i></span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card border-0 bg-none">
                            <div class="card-body p-0" id="presc_details">
                                @include('iCure-Home.admin.doctor.prescription.prescription_details')
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('admin_js')

    <script type="text/javascript">
        $('body').on('keyup', '#txt_height', function() {
            let height_to_meter = $(this).val() * 0.0254;
            let weight = $('#txt_weight').val();
            let bmi = weight / (height_to_meter * height_to_meter);
            $('#txt_bmi').val(bmi.toFixed(1));
        })

        $('body').on('keyup', '#txt_weight', function() {
            let height_to_meter = $('#txt_height').val() * 0.0254;
            let weight = $(this).val();
            let bmi = weight / (height_to_meter * height_to_meter);
            $('#txt_bmi').val(bmi.toFixed(1));
        })

        openPatientAutocomplete('#service_id', 'hdn_patient_id', function(item, obj) {
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

        openDoctorAutocomplete("#doctor_name", "hdn_doctor_id", function(item, obj) {
            $("#hdn_su_no").val(item.serviceunit_id);
            obj.stopImmediatePropagation();
        });

        $(document).ready(function() {
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
                var hdn_patient_id = $("#patapp_hdn").val();
                console.log(hdn_patient_id);
                if (hdn_patient_id == "") {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                    return;
                }

                window.open("{{ route('emr.patient-emr') }}/" + hdn_patient_id, "_blank");
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
    </script>
@endpush
