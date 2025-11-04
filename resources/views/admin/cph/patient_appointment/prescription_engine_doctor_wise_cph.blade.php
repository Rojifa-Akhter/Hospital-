<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
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
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0"> Prescription Entry</h5>
                <small>Prescription / Prescription Entry</small>
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
            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id" />
                <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="" />
            <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                value="" />
            <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                value="" />
            <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                value="" />
            <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="" />
            <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" />
            <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                value="" />
            <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                value="" />
            <input type="hidden" id="hdn_add_pres_favourit_url" value="" />
            <input type="hidden" id="hdn_interaction_url" value="" />
            <input type="hidden" name="hospital_code" id="hospital_code" value="{{ Session::get('user.ses_hospital_code') }}">
            <div class="row border-bottom-dark">
                    <div class="form-row mt-1 mb-1 w-100">
                        <div class="col">
                            <select class="custom-select" name="hdn_su_no" id="hdn_su_no">
                                <option value="0">Select Department</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="service_id" name="service_id"
                                value="" placeholder="Search Patient By Service ID/ Name / Phone NO."
                                data-emr-route="{{ route('emr.patient-emr') }}"
                                title="Search Patient By Service ID/ Name / Phone NO."
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="patient_id" id="patient_id">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="doctor_name" name="doctor_name"
                                value="" placeholder="Search Doctor By Name / Phone NO. / SPL."
                                title="Search Doctor By Name / Phone NO. / Specialization"
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="doctor_id" id="doctor_id">

                        </div>
                        <div class="col">
                            <select class="custom-select" name="cmb_external_hospital">
                                <option value="0">Select Extarnal Hospital</option>
                            </select>
                        </div>
                    </div>

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
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#completed"
                                        role="tab" aria-controls="home" aria-selected="true">
                                        Completed &nbsp;
                                        <span class="badge badge-success"></span>
                                    </a>
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#absent"
                                        role="tab" aria-controls="home" aria-selected="true">
                                        Absent &nbsp;
                                        <span class="badge badge-danger"></span>
                                    </a>
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
                                <table class="table data-table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center w-10">Serial</th>
                                            <th class="text-left"></th>
                                            <th class="text-left">Patient</th>
                                            <th class="text-center w-20">App. Type</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                        <tr>
                                                            <td class="text-center p-1 bg-light border-right"><span
                                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                    style="font-size:10px;"></span>
                                                            </td>
                                                            <td class="text-left p-1 w-5 bg-light border-right">
                                                                <span
                                                                    class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                    style="font-size:10px;"></span>
                                                            </td>
                                                            <td class="text-left p-1"></td>

                                                            <td class="text-left p-1">
                                                                    <span
                                                                        class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                        style="font-size:10px;">New</span>
                                                    
                                                                    <span
                                                                        class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                        style="font-size:10px;">Follow up</span>
                                                            
                                                            </td>
                                                            <td class="text-center p-1 bg-light">
                                                                <span
                                                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                    data-presc=""
                                                                    data-dtls-action="{{ route('get-prev-prescription-dtls', 1) }}"
                                                                    data-action="{{ route('get-prescription-mst', [5,2, 1]) }}"
                                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                                    title="Create New Prescription">
                                                                    <i class="fa fa-prescription"></i>
                                                                </span>
                                                                <input type="hidden" name="" id="patapp_hdn"
                                                                    value="">
                                                                <span
                                                                    class="btn btn-outline-danger btn-sm bg-none cursor-pointer patapp_absent">
                                                                    A
                                                                </span>
                                                            </td>
                                                        </tr>
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
                                            <th class="text-left">Date</th>
                                            <th class="text-left">App. Type</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientContainer">
                                        @include('admin.prescription.completed_prescription')
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
                                            <th class="text-left">App. Type</th>
                                            <th class="text-center w-10">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                        <tr>
                                                            <td class="text-center p-1 bg-light border-right"><span
                                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                    style="font-size:10px;"></span>
                                                            </td>
                                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                                <span
                                                                    class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                    style="font-size:10px;"></span>
                                                            </td>
                                                            <td class="text-left bg-none p-1"></td>

                                                            <td class="text-left p-1">
                                                                    <span
                                                                        class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                        style="font-size:10px;">New</span>
                                                                    <span
                                                                        class="btn btn-sm bg-none cursor-pointer btn-block"
                                                                        style="font-size:10px;">Follow up</span>
                                                            </td>
                                                            <td class="text-center p-1 bg-light">
                                                                <span
                                                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                                    data-presc=""
                                                                    data-dtls-action="{{ route('get-prev-prescription-dtls', 1) }}"
                                                                    data-action="{{ route('get-prescription-mst', [7, 5, 1]) }}"
                                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                                    title="Create New Prescription">
                                                                    <i class="fa fa-prescription"></i>
                                                                </span>

                                                            </td>
                                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-7 col-sm-12 p-2 bg-white">
                    <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6>
                    <div class="card mt-0">
                        <div class="card-body pl-3 pr-3">
                            <div class="row border">
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 border-right border-bottom" style="background: #2f1385;">
                                    <div id="patient_info">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="patient_img"
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
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 border-right border-bottom" style="background: #2f1385;">
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
                                                            <th class="p-0 px-1 border-0">Height (cm)</th>
                                                            <th class="p-0 px-1 border-0">Weight (kg)</th>
                                                            <th class="p-0 px-1 border-0">OFC</th>
                                                            <th class="p-0 px-1 border-0">BMI (kg/m <sup>2</sup>)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="border-0">
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_pulse" name="txt_pulse" value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bp_sys" name="txt_bp_sys"
                                                                        value="">
                                                                    &nbsp; / &nbsp;
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bp_dia" name="txt_bp_dia"
                                                                        value="">
                                                                </div>

                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_temperature" name="txt_temperature"
                                                                    value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_height" name="txt_height"
                                                                    value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_weight" name="txt_weight"
                                                                    value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_ofc" name="txt_ofc"
                                                                    value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_bmi" name="txt_bmi"
                                                                    value="">
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>

                                                {{-- @if (Session::get('user.ses_hospital_code') == 'AMCSH')
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
                                                @endif --}}


                                                <table class="table border-0 m-0 mb-2" hidden>
                                                    <thead>
                                                        <tr class="border-0">
                                                            <th class="p-0 px-1 border-0">Heart </th>
                                                            <th class="p-0 px-1 border-0">Lung Condition </th>
                                                                <th class="p-0 px-1 border-0">Per abdominal examination
                                                                </th>
                                                                <th class="p-0 px-1 border-0">CNS</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="border-0">
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_heart_rate" name="txt_heart_rate"
                                                                    value="">
                                                            </td>
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_lung_condition" name="txt_lung_condition"
                                                                    value="">
                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0"
                                                                        id="txt_bowel_condition" name="txt_bowel_condition" value="">
                                                                </div>

                                                            </td>

                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0" id="txt_bladder_condition" name="txt_bladder_condition"
                                                                    value="">
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
                    <div class="card border-0 bg-none">
                        <div class="card-body" id="presc_details">
                            @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                                @include('admin.cph.patient_appointment.prescription_details_doctor_wise_cph')
                            @else
                                @include('admin.cph.patient_appointment.prescription_details_doctor_wise_impala_cph')
                            @endif
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <b></b>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="test345">
                                                        <div class="col-md-2">

                                                        </div>
                                                    <div class="col-md-2">
                                                        <p></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type=""
                                                            class="form-control item_dtl_val" name="item_dtl_val[]">
                                                        <input type="hidden" class="form-control item_name "
                                                            name="item_name[]"
                                                            value="">
                                                        <input type="hidden" class="form-control lookup_id"
                                                            name="item_name[]"
                                                            value="">
                                                        <input type="hidden" class="form-control lookup_code"
                                                            name="lookup_code[]"
                                                            value="">
                                                        <input type="hidden" class="form-control lookupdata_code"
                                                            name="lookupdata_code[]" value="">

                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-danger">No Setup Data Available </p>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>

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
                            <div class="row">
                                <div class="col-md-12">
                                    <b></b>
                                </div>
                                <div class="col-md-12">
                                    <div class="row" id="test123">
                                                    <div class="col-md-2">

                                                    </div>
                                                <div class="col-md-1">
                                                    <p></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type=""
                                                        class="form-control item_dtl_val" name="item_dtl_val[]">
                                                    <input type="hidden" class="form-control item_name "
                                                        name="item_name[]" value="">
                                                    <input type="hidden" class="form-control lookup_id"
                                                        name="item_name[]"
                                                        value="">
                                                    <input type="hidden" class="form-control lookup_code"
                                                        name="lookup_code[]"
                                                        value="">
                                                    <input type="hidden" class="form-control lookupdata_code"
                                                        name="lookupdata_code[]" value="">

                                                </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>

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
<script type="text/javascript">
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    var PresFunc = {
        prescribedPatientList: function(thisElement) {
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
        // let height_to_meter = $(this).val() != "" ? $(this).val() * 0.0254 : 0;old
        let height_to_meter = $(this).val() != "" ? $(this).val() * 0.01 : 0;
        let weight = $('#txt_weight').val();
        let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#txt_bmi').val(bmi.toFixed(1));
    })

    $('body').on('keyup', '#txt_weight', function() {
        // let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.0254 : 0;old
        let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.01 : 0;
        let weight = $(this).val();
        let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
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
</script>
