<link href="{{ asset('datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
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
</style>
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0">Prescription Entry</h5>
                <small>Prescription / Prescription Entry</small>
            </div>
            <div class="col-8">

            </div>
        </div>

        <form method="post" id="frm-pat-prescription" action="{{ route('pres-opd-save-update') }}" autocomplete="off"
            onsubmit="">
            {{--			@csrf --}}
            {{--			<input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" /> --}}
            {{--			<input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id" /> --}}
            {{--			<input type="hidden" id="hdn_patient_id" name="hdn_patient_id" /> --}}
            {{--			<input type="hidden" id="hdn_service_id" name="hdn_service_id" /> --}}
            {{--			<input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id" /> --}}
            {{--			@if ($department_id != '') --}}
            {{--			<input type="hidden" id="hdn_su_no" name="hdn_su_no" value="{{ $department_id }}" /> --}}
            {{--			@endif --}}
            {{--			<input type="hidden" id="hdn_external_ind" name="hdn_external_ind" value="{{ ($department_id == "")?1:0 }}" /> --}}
            {{--			<input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind" value="{{ !empty($su_info)?$su_info->dental_ind:0 }}" /> --}}
            {{--			<input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind" value="{{ !empty($su_info)?$su_info->eye_ind:0 }}" /> --}}
            {{--			<input type="hidden" id="hdn_room_no" name="hdn_room_no" value="{{ $room_id }}" /> --}}
            {{--			<input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" /> --}}
            {{--			<input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route" value="{{ route('physiotherapy.load-pres-favourit-list') }}" /> --}}
            {{--			<input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom" value="{{ route('lookup-pres-data-autocomplete') }}" /> --}}
            {{--			<input type="hidden" id="hdn_add_pres_favourit_url" value="{{ route('add-pres-favourit-list') }}" /> --}}
            {{--			<input type="hidden" id="hdn_interaction_url" value="{{ route('presc-interaction') }}" /> --}}
            <div class="row border-bottom-dark">
                {{--				@if ($department_id == '') --}}
                {{--				<div class="form-row mt-1 mb-1 w-100"> --}}
                {{--					<div class="col"> --}}
                {{--						<select class="custom-select" name="hdn_su_no" id="hdn_su_no"> --}}
                {{--							<option value="0">Select Department</option> --}}
                {{--							@if (!empty($su_arr)) --}}
                {{--							@foreach ($su_arr as $su_row) --}}
                {{--							<option value="{{ $su_row->su_no_pk }}" data-dental-ind="{{ $su_row->dental_ind }}" data-eye-ind="{{ $su_row->eye_ind }}">{{ $su_row->su_name }}</option> --}}
                {{--							@endforeach --}}
                {{--							@endif --}}
                {{--						</select> --}}
                {{--					</div> --}}
                {{--					<div class="col"> --}}
                {{--						<input type="text" class="form-control bg-white" id="service_id" name="service_id" value="" placeholder="Search Patient By Service ID/ Name / Phone NO." data-emr-route="" title="Search Patient By Service ID/ Name / Phone NO." style="margin-bottom: 0 !important; padding: 12px 5px !important" /> --}}
                {{--						<input type="hidden" name="patient_id" id="patient_id"> --}}
                {{--					</div> --}}
                {{--					<div class="col"> --}}
                {{--						<input type="text" class="form-control bg-white" id="doctor_name" name="doctor_name" value="" placeholder="Search Doctor By Name / Phone NO. / SPL." title="Search Doctor By Name / Phone NO. / Specialization" style="margin-bottom: 0 !important; padding: 12px 5px !important" /> --}}
                {{--						<input type="hidden" name="doctor_id" id="doctor_id"> --}}
                {{--					</div> --}}
                {{--					<div class="col"> --}}
                {{--						<select class="custom-select" name="cmb_external_hospital"> --}}
                {{--							<option value="0">Select Extarnal Hospital</option> --}}
                {{--							@if (!empty($extarnal_hospitals)) --}}
                {{--							@foreach ($extarnal_hospitals as $hkey => $hrow) --}}
                {{--							<option value="{{ $hkey }}">{{ $hrow }}</option> --}}
                {{--							@endforeach --}}
                {{--							@endif --}}
                {{--						</select> --}}
                {{--					</div> --}}
                {{--				</div> --}}
                {{--				@endif --}}

                <div class="col-md-12 col-lg-6 col-sm-12 p-1 bg-white border-right">
                    {{--					@if ($department_id != '') --}}
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
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#absent" role="tab"
                                        aria-controls="home" aria-selected="true">
                                        Absent &nbsp;
                                        <span class="badge badge-danger"></span>
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
                                        {{--										@if (!empty($appointment_rs)) --}}
                                        {{--										@php $i = 1; @endphp --}}
                                        {{--										@foreach ($appointment_rs as $row) --}}
                                        {{--										@if ($row->prescription_no_pk == '') --}}
                                        {{--										@php --}}
                                        {{--										if($row->priority == "Urgent") --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-danger"; --}}
                                        {{--										} --}}
                                        {{--										else if($row->priority == "VIP") --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-info"; --}}
                                        {{--										} --}}
                                        {{--										else --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-success"; --}}
                                        {{--										} --}}
                                        {{--										@endphp --}}
                                        {{--										@if ($row->appoint_status == 1) --}}
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;"></span></td>
                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                <span class="btn btn-sm bg-none cursor-pointer btn-block"
                                                    style="font-size:10px;"></span>
                                            </td>
                                            <td class="text-left p-1">
                                                {{--												{{ $row->patient_name_rank }} --}}
                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    data-presc="" data-dtls-action="" data-action=""
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Create New Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>
                                                <input type="hidden" name="" id="patapp_hdn" value="">
                                                <span
                                                    class="btn btn-outline-danger btn-sm bg-none cursor-pointer patapp_absent">
                                                    A
                                                </span>
                                            </td>
                                        </tr>
                                        {{--										@endif --}}
                                        {{--										@php $i++; @endphp --}}
                                        {{--										@endif --}}
                                        {{--										@endforeach --}}
                                        {{--										@endif --}}
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
                                        {{--										@if (!empty($appointment_rs)) --}}
                                        {{--										@php $i = 1; @endphp --}}
                                        {{--										@foreach ($appointment_rs as $row) --}}
                                        {{--										@if ($row->prescription_no_pk != '') --}}
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;"></span></td>
                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                <span class="btn btn-outline-info btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px; width: 50px;"></span>
                                            </td>
                                            <td class="text-left p-1">

                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    data-presc="" data-dtls-action="" data-action=""
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Edit Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>
                                                <a href=""
                                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    target="_blank" data-id="" title="Print Prescription"><i
                                                        class="fa fa-file-pdf"></i></a>
                                            </td>
                                        </tr>
                                        {{--										@php $i++; @endphp --}}
                                        {{--										@endif --}}
                                        {{--										@endforeach --}}
                                        {{--										@endif --}}
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
                                        {{--										@if (!empty($appointment_rs)) --}}
                                        {{--										@php $i = 1; @endphp --}}
                                        {{--										@foreach ($appointment_rs as $row) --}}
                                        {{--										@if ($row->prescription_no_pk == '') --}}
                                        {{--										@php --}}
                                        {{--										if($row->priority == "Urgent") --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-danger"; --}}
                                        {{--										} --}}
                                        {{--										else if($row->priority == "VIP") --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-info"; --}}
                                        {{--										} --}}
                                        {{--										else --}}
                                        {{--										{ --}}
                                        {{--											$bg_class = "btn-outline-success"; --}}
                                        {{--										} --}}
                                        {{--										@endphp --}}
                                        {{--										@if ($row->appoint_status == 3) --}}
                                        <tr>
                                            <td class="text-center p-1 bg-light border-right"><span
                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                    style="font-size:10px;"></span></td>
                                            <td class="text-left p-1 w-8 bg-light border-right">
                                                <span class="btn btn-sm bg-none cursor-pointer btn-block"
                                                    style="font-size:10px;"></span>
                                            </td>
                                            <td class="text-left bg-none p-1">
                                                {{--												{{ $row->patient_name_rank }} --}}
                                            </td>
                                            <td class="text-center p-1 bg-light">
                                                <span class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                    data-presc="" data-dtls-action="" data-action=""
                                                    onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                    title="Create New Prescription">
                                                    <i class="fa fa-prescription"></i>
                                                </span>

                                            </td>
                                        </tr>
                                        {{--										@endif --}}
                                        {{--										@php $i++; @endphp --}}
                                        {{--										@endif --}}
                                        {{--										@endforeach --}}
                                        {{--										@endif --}}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    {{--					@endif --}}
                </div>
                <div class="col-md-12 col-lg-6 col-sm-12 p-2 bg-white">
                    <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6>
                    <div class="card mt-0">
                        <div class="card-body pl-3 pr-3">
                            <div class="row border">
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 bg-navy border-right border-bottom">
                                    <div id="patient_info">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="patient_img"
                                                    data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('img/doc-1.png') }}" width="30"
                                                        alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 bg-navy border-right border-bottom">
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
                                <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                                    <div class="card mt-0">
                                        <div class="card-body p-2">
                                            <div class="form-row">
                                                <div class="col-md-10">
                                                    <div class="tab-content d-block p-0" id="v-pills-tabContent">
                                                        <div class="tab-pane fade show active" id="v-pills-vitals"
                                                            role="tabpanel" aria-labelledby="v-pills-vitals-tab">
                                                            <div class="table-responsive">
                                                                <table class="table border-0 m-0">
                                                                    <thead>
                                                                        <tr class="border-0">
                                                                            <th class="p-0 px-1 border-0">Pulse</th>
                                                                            <th class="p-0 px-1 border-0 w-20">BP</th>
                                                                            <th class="p-0 px-1 border-0">Temperature
                                                                            </th>
                                                                            <th class="p-0 px-1 border-0">Height</th>
                                                                            <th class="p-0 px-1 border-0">Weight</th>
                                                                            <th class="p-0 px-1 border-0">OFC</th>
                                                                            <th class="p-0 px-1 border-0">BMI</th>
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
                                                                                        id="txt_bp_sys"
                                                                                        name="txt_bp_sys"
                                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_sys : '' }}">
                                                                                    &nbsp; / &nbsp;
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm m-0 p-0"
                                                                                        id="txt_bp_dia"
                                                                                        name="txt_bp_dia"
                                                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_dia : '' }}">
                                                                                </div>

                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="txt_temperature"
                                                                                    name="txt_temperature"
                                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->temp_val : '' }}">
                                                                            </td>

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

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="txt_ofc" name="txt_ofc"
                                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->ofc : '' }}">
                                                                            </td>

                                                                            <td class="p-0 px-1 border-0">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm m-0 p-0"
                                                                                    id="txt_bmi" name="txt_bmi"
                                                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bmi : '' }}">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="v-pills-speciality"
                                                            role="tabpanel" aria-labelledby="v-pills-speciality-tab">
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="ofc"
                                                                            class="col-form-label col-form-label-sm">Ofc</label>
                                                                        <input readonly="" type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="ofc" name="ofc"
                                                                            value="" placeholder="Ofc">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="lmp"
                                                                            class="col-form-label col-form-label-sm">Lmp</label>
                                                                        <input readonly="" type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="lmp" name="lmp"
                                                                            value="" placeholder="Lmp">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="nav flex-column nav-pills" id="v-pills-tab"
                                                        role="tablist" aria-orientation="vertical">
                                                        <a class="nav-link text-center active" id="v-pills-vitals-tab"
                                                            data-toggle="pill" href="#v-pills-vitals" role="tab"
                                                            aria-controls="v-pills-vitals"
                                                            aria-selected="true">Vitals</a>
                                                        <a class="nav-link text-center mt-1"
                                                            id="v-pills-speciality-tab" data-toggle="pill"
                                                            href="#v-pills-speciality" role="tab"
                                                            aria-controls="v-pills-speciality"
                                                            aria-selected="false">Speciality</a>
                                                    </div>
                                                </div>
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
                        <input type="hidden" id="department_id" name="department_id" value="" />
                        <div class="card-body" id="presc_details">
                            @include('admin.prescription.prescription_details')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    {{--	<div class="neurologyHistory_pop_up"> --}}
    {{--		<div class="neurology_popup" title="Physical Findings" data-toggle="modal" data-target="#neurology_modal"> --}}
    {{--			<img class="w-100" src="{{ asset('img/neurology.png') }}" alt=""> --}}
    {{--		</div> --}}
    {{--		<div class="history_popup" title="History" data-toggle="modal" data-target="#history_modal"> --}}
    {{--			<img class="w-100" src="{{ asset('img/history.png') }}" alt=""> --}}
    {{--		</div> --}}
    {{--	</div> --}}


    <!-- Neurology Modal -->
    <div class="modal fade" id="neurology_modal" role="dialog" aria-labelledby="neurology_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">NEUROLOGY</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mt-0">
                        <div class="card-header">
                            <h5>Physical Findings</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="anaemia_select"
                                            class="col-form-label col-form-label-sm">Anaemia</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="anaemia_select"
                                            name="anaemia_select">
                                            <option value="0">Select Disposal</option>
                                            <option value="0">Anaemia-1</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="BP_cyanosis" class="col-form-label col-form-label-sm">BP
                                            Cyanosis</label>
                                        <input type="text" class="form-control form-control-sm" id="BP_cyanosis"
                                            name="BP_cyanosis"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="oedema_select"
                                            class="col-form-label col-form-label-sm">Oedema</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="oedema_select"
                                            name="oedema_select">
                                            <option value="0">Select Disposal</option>
                                            <option value="0">Oedema-1</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lymph_nodes" class="col-form-label col-form-label-sm">Lymph
                                            Nodes</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="lymph_nodes"
                                            name="lymph_nodes">
                                            <option value="0">Select Disposal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="weight" class="col-form-label col-form-label-sm">Weight</label>
                                        <input type="text" class="form-control form-control-sm" id="weight"
                                            name="weight"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rr" class="col-form-label col-form-label-sm">RR</label>
                                        <input type="text" class="form-control form-control-sm" id="rr"
                                            name="rr"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jaundice_select"
                                            class="col-form-label col-form-label-sm">Jaundice</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="jaundice_select"
                                            name="jaundice_select">
                                            <option value="0">Select Disposal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dehydration_select"
                                            class="col-form-label col-form-label-sm">Dehydration</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="dehydration_select"
                                            name="dehydration_select">
                                            <option value="0">Select Disposal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="neck_rigidity" class="col-form-label col-form-label-sm">Neck
                                            Rigidity</label>
                                        <select class="form-control form-control-sm  m-0 p-0" id="neck_rigidity"
                                            name="neck_rigidity">
                                            <option value="0">Select Disposal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pr" class="col-form-label col-form-label-sm">P/R</label>
                                        <input type="text" class="form-control form-control-sm" id="pr"
                                            name="pr"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="temp" class="col-form-label col-form-label-sm">Temp</label>
                                        <input type="text" class="form-control form-control-sm" id="temp"
                                            name="temp"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="others" class="col-form-label col-form-label-sm">Others</label>
                                        <input type="text" class="form-control form-control-sm" id="others"
                                            name="others"value="">
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>


                    <div class="card ">
                        <div class="card-header">
                            <h5>Systemic Findings</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_heart"
                                            class="col-form-label col-form-label-sm">Heart</label>
                                        <input type="text" class="form-control form-control-sm" id="finding_heart"
                                            name="finding_heart"value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_Lungs"
                                            class="col-form-label col-form-label-sm">Lungs</label>
                                        <input type="text" class="form-control form-control-sm" id="finding_Lungs"
                                            name="finding_Lungs"value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nervous_system" class="col-form-label col-form-label-sm">Nervous
                                            System</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="nervous_system" name="nervous_system"value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_Weight"
                                            class="col-form-label col-form-label-sm">Weight</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="finding_Weight" name="finding_Weight"value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="skin_pigmentation" class="col-form-label col-form-label-sm">Skin
                                            Pigmentation</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="skin_pigmentation" name="skin_pigmentation"value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_Abdomen"
                                            class="col-form-label col-form-label-sm">Abdomen</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="finding_Abdomen" name="finding_Abdomen"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_OFC" class="col-form-label col-form-label-sm">OFC</label>
                                        <input type="text" class="form-control form-control-sm" id="finding_OFC"
                                            name="finding_OFC"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_Spine"
                                            class="col-form-label col-form-label-sm">Spine</label>
                                        <input type="text" class="form-control form-control-sm" id="finding_Spine"
                                            name="finding_Spine"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="eyes_squint" class="col-form-label col-form-label-sm">Eyes
                                            Squint</label>
                                        <input type="text" class="form-control form-control-sm" id="eyes_squint"
                                            name="eyes_squint"value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="finding_Others"
                                            class="col-form-label col-form-label-sm">Others</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="finding_Others" name="finding_Others"value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div class="modal fade" id="history_modal" role="dialog" aria-labelledby="history_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">HISTORY</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mt-0">
                        <div class="card-body p-2">

                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>











    <style>
        .neurologyHistory_pop_up {
            position: fixed;
            top: 90%;
            right: 30px;
            transform: translateY(-50%);
        }

        .neurology_popup,
        .history_popup {
            width: 45px;
            height: 45px;
            overflow: hidden;
            background-color: #1772ad;
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

</section>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    {{--	openPatientAutocomplete('#service_id', 'hdn_patient_id', function(item, obj){ --}}
    {{--		var patient_info_route = "{{ route('prescription.get-patient-info') }}"; --}}

    {{--		var dtls_action = "{{ route('get-prev-prescription-dtls', ":id") }}"; --}}
    {{--		var dtlsAction = dtls_action.replace(':id', item.patient_id); --}}
    {{--		prescriptionFunc.getPatientDetails(item.patient_id, patient_info_route, dtlsAction); --}}
    {{--		/* checkDepartmentID(); */ --}}
    {{--		obj.stopImmediatePropagation(); --}}
    {{--	}); --}}

    {{--	$(document).on("click", ".patapp_absent", function(e){ --}}
    {{--		var patapp_id = $(this).siblings('#patapp_hdn').val(); --}}
    {{--		if(confirm("Are you sure")) --}}
    {{--		{ --}}
    {{--			$.ajax({ --}}

    {{--				data: { patapp_id:patapp_id }, --}}
    {{--				url: "{{ route('prescription.appointment-absent') }}", --}}
    {{--				type: "get", --}}
    {{--				beforeSend:function(){ --}}
    {{--					blockUI(); --}}
    {{--				}, --}}
    {{--				success: function (data) { --}}
    {{--					var riderect_action = $("#hdn_current_url").val(); --}}
    {{--					$('.common-modal-notify').modal('show'); --}}
    {{--					$('.common-modal-notify .modal-body').html("Absent successful"); --}}
    {{--					dynamicFunc.afterSaveLoadPage(riderect_action); --}}
    {{--				}, --}}

    {{--				complete: function () { --}}
    {{--					/*$(".data-table").DataTable({ --}}
    {{--						"ordering": false, --}}
    {{--						"bPaginate": false, --}}
    {{--						"bLengthChange": false, --}}
    {{--						"bInfo": false, --}}
    {{--						"bAutoWidth": false --}}
    {{--					});*/ --}}
    {{--					$.unblockUI(); --}}
    {{--				} --}}
    {{--			}); --}}
    {{--		} --}}
    {{--		e.stopImmediatePropagation(); --}}

    {{--	}) --}}

    {{--	openDoctorAutocomplete("#doctor_name", "hdn_doctor_id", function(item, obj){ --}}
    {{--		$("#hdn_su_no").val(item.serviceunit_id); --}}
    {{--		obj.stopImmediatePropagation(); --}}
    {{--	}); --}}

    {{--	$(document).ready(function () { --}}
    {{--		var patTable = $('.data-table').DataTable({ --}}
    {{--			"ordering": false, --}}
    {{--			"bPaginate": false, --}}
    {{--			"bLengthChange": false, --}}
    {{--			"bInfo": false, --}}
    {{--			"bAutoWidth": false --}}
    {{--		}); --}}
    {{--		$(document).on("keyup",'#txtSearchPat',function(){ --}}
    {{--			patTable.search($(this).val()).draw() ; --}}
    {{--		}); --}}

    {{--		$(document).on("keypress","input", function(e){ --}}
    {{--			if(e.which == 13) { --}}
    {{--				e.preventDefault(); --}}
    {{--			} --}}
    {{--		}); --}}

    {{--		$(document).on("keyup","#template_name", function(e){ --}}
    {{--			$("#template_msg").html(""); --}}
    {{--			$(this).removeClass("is-invalid"); --}}
    {{--		}); --}}

    {{--		$(document).on("click","#btn_emr", function(e){ --}}
    {{--			var hdn_patient_id = $("#hdn_patient_id").val(); --}}
    {{--			if(hdn_patient_id == "") --}}
    {{--			{ --}}
    {{--				$('.common-modal-notify-error').modal('show'); --}}
    {{--				$('.common-modal-notify-error .modal-title').html("Validation Error"); --}}
    {{--				$('.common-modal-notify-error .modal-body').html("You did not select any Patient"); --}}
    {{--				return; --}}
    {{--			} --}}

    {{--			window.open("{{ route('emr.patient-emr') }}/"+ hdn_patient_id,"_blank"); --}}
    {{--		}); --}}

    {{--		$(document).on('show.bs.dropdown','.btn_template', function () { --}}
    {{--			var doctor_id = $("#hdn_doctor_id").val(); --}}
    {{--			var hdn_patient_id = $("#hdn_patient_id").val(); --}}
    {{--			if(hdn_patient_id == "") --}}
    {{--			{ --}}
    {{--				$('.common-modal-notify-error').modal('show'); --}}
    {{--				$('.common-modal-notify-error .modal-title').html("Validation Error"); --}}
    {{--				$('.common-modal-notify-error .modal-body').html("You did not select any Patient"); --}}
    {{--				return; --}}
    {{--			} --}}

    {{--			$("#template-container").html('<div class="d-flex justify-content-center"></div>'); --}}
    {{--			$.ajax({ --}}
    {{--				async: true, --}}
    {{--				data: { doctor_id:doctor_id }, --}}
    {{--				url: "{{ route('prescription-templates', 2) }}", --}}
    {{--				type: "get", --}}
    {{--				beforeSend:function(){ --}}
    {{--					$("#template-container div").html('<i class="spinner-border spinner-border-sm"></i>'); --}}
    {{--				}, --}}
    {{--				success: function (data) { --}}
    {{--					$("#template-container").html(data); --}}
    {{--				} --}}
    {{--			}); --}}
    {{--		}); --}}

    {{--		$(document).on("change","#cmb_type", function(e){ --}}
    {{--			var type = $(this).find(':selected').val(); --}}
    {{--			if(type == "DLRG") --}}
    {{--			{ --}}
    {{--				$('#allergy_con .twitter-typeahead').removeClass('d-none'); --}}
    {{--				$('#cmb_allergy').addClass('d-none'); --}}
    {{--			} --}}
    {{--			else --}}
    {{--			{ --}}
    {{--				$('#allergy_con .twitter-typeahead').addClass('d-none'); --}}
    {{--				$('#cmb_allergy').removeClass('d-none'); --}}
    {{--			} --}}
    {{--			//$('#medicine_item').typeahead(); --}}
    {{--		}); --}}

    {{--		$(document).on("change","#hdn_su_no", function(e){ --}}
    {{--			var hdn_su_no = $(this).val(); --}}
    {{--			$("#hdn_dental_ind").val( $(this).find(":selected").attr("data-dental-ind")*1 ); --}}
    {{--			$("#hdn_eye_ind").val( $(this).find(":selected").attr("data-eye-ind")*1 ); --}}

    {{--			var dtls_action = "{{ route('get-prev-prescription-dtls', 0) }}"; --}}
    {{--			prescriptionFunc.prescriptionDetails(hdn_su_no,dtls_action); --}}
    {{--		}); --}}

    {{--	}); --}}

    /* function checkDepartmentID(){
    	var department_id = $('#department_id').val();
    	if(department_id == ''){
    		$('.depart_id').hide();
    	}else{
    		$('.depart_id').show();
    	}
    }
    checkDepartmentID(); */






</script>
