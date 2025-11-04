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
    }

    /* Soft top and bottom borders */
    .soft-border {
        border-top: 2px solid rgba(0, 0, 0, 0.1);
        /* Light gray top border */
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        /* Light gray bottom border */
        border-radius: 8px;
        /* Rounded corners */
        padding: 10px;
        /* Inner spacing */
        margin: 10px 0;
        /* Vertical spacing */
    }
</style>
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                {{-- <h5 class="mt-2 mb-0"> Prescription Entry {{ $department_id == '' ? ' - External Hospital' : '' }}</h5> --}}
                <small>Prescription / Prescription Entry</small>
            </div>
            <div class="col-8">

            </div>
        </div>

        <form method="post" id="frm-pat-prescription-uhl" action="{{ route('pres-opd-save-update-uhl') }}"
            autocomplete="off" onsubmit="">
            @csrf
            <input type="hidden" id="hidden_appoint_id" name="hidden_appoint_id" value="{{ $appoint_id }}">
            <input type="hidden" id="hidden_patient_code" name="hidden_patient_code" value="{{ $patient_code }}">
            <input type="hidden" id="hidden_patient_no_pk" name="hidden_patient_no_pk" value="{{ $patient_no_pk }}">
            <input type="hidden" id="hidden_prescription_no_pk" name="hidden_prescription_no_pk"
                value="{{ $prescription_no_pk }}">

            <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" />
            <input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id" />
            <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
            <input type="hidden" id="hdn_service_id" name="hdn_service_id" />
            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id" />

            @if ($department_id != '')
                <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="{{ $department_id->serviceunit_no_pk }}" />
            @endif
            <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                value="{{ $department_id == '' ? 1 : 0 }}" />
            <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                value="{{ !empty($su_info) ? $su_info->dental_ind : 0 }}" />
            <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                value="{{ !empty($su_info) ? $su_info->eye_ind : 0 }}" />
            <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="{{ $room_id }}" />

            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" />
            @else
                <input type="hidden" id="hdn_current_url" name="hdn_current_url"
                    value="{{ route('prescription.appointment-list') }}" />
            @endif

            <!--  -->
            <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                value="{{ route('physiotherapy.load-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                value="{{ route('lookup-pres-data-autocomplete') }}" />
            <input type="hidden" id="hdn_add_pres_favourit_url" value="{{ route('add-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_interaction_url" value="{{ route('presc-interaction') }}" />
            <input type="hidden" name="hospital_code" id="hospital_code"
                value="{{ Session::get('user.ses_hospital_code') }}">

            <div class="row border-bottom-dark">

                <div class="col-md-6 col-lg-6 col-sm-12 p-1 bg-white border-right">
                    <table width="100%" class="ml-2">
                        <tr>
                            <th>UHID</th>
                            <th> : {{ $patient_information->patient_code }}</th>
                            <th>Patient Name</th>
                            <th> : {{ $patient_information->patient_name }}</th>
                            <th rowspan="3">

                                @if ($patient_information->patient_photo != '')
                                    <img class="rounded"
                                        src="{{ asset('images/uploads/patient_images/thumb/' . $patient_information->patient_photo) }}"
                                        style="display: block; margin-left: auto; margin-right: 0;">
                                @else
                                    @if ($patient_information->gender_txt == 'Male')
                                        <img class="rounded w-30" src="{{ asset('images/pt-patient.png') }}"
                                            style="width:60px;height:60px;">
                                    @else
                                        <img class="rounded w-30" src="{{ asset('images/female.jpg') }}"
                                            style="width:60px;height:60px;">
                                    @endif
                                @endif

                            </th>
                        </tr>
                        <tr>
                            <th>Sex</th>
                            <th> : {{ $patient_information->gender_txt }}</th>
                            <th>Age</th>
                            <th> : {{ $patient_information->age }}</th>
                        </tr>
                        <tr>
                            <th>Pt. Type</th>
                            <th> : {{ $patient_information->patient_type_code }}</th>
                            <th>Appoint. Type</th>
                            <th> : {{ $patient_information->appoint_typename }}</th>
                        </tr>
                    </table>

                    <div class="card">

                        <div class="card-body">

                            <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-right border-bottom pl-1">
                                <input type="hidden" id="chronic-route" value="{{ route('add-chronic-disease') }}">
                                <input type="hidden" id="chronic-route-save"
                                    value="{{ route('store-chronic-disease') }}">
                                <input type="hidden" id="chronic-route-delete"
                                    value="{{ route('delete-chronic-disease') }}">
                                <strong>Chronic Disease:</strong> <span id="chronic_con">


                                    @if (!empty($chronicItems) && count($chronicItems) > 0)
                                        @foreach ($chronicItems as $item)
                                            <span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1"
                                                style="font-size:10px;"
                                                onclick="prescriptionFunc.addChronicItem(this)"
                                                data-modal="common-modal-sm"
                                                data-action="{{ route('add-chronic-disease') }}">
                                                {{ $item->chronic_dis_name }}
                                            </span>
                                        @endforeach
                                    @endif






                                </span>
                                <input type="hidden" class="form-control" id="chrn-items" name="chrn_items" />
                                <input type="hidden" class="form-control" id="chronic_text" name="chronic_text" />


                                <span class="cursor-pointer float-right mt-1 ml-4"
                                    onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm"
                                    data-action="{{ route('add-chronic-disease') }}" title="Select Chronic Disease"
                                    style="font-size: 9px;"> <i class="fa fa-plus"></i> </span>


                                {{-- <button class="cursor-pointer mt-1 mb-1 pl-2 pr-2 border border-info open-modal"
                                    data-modal="common-modal-sm"
                                    data-action="{{ route('add-new-chronic-deasease') }}"
                                title="Add New Chronic Disease" style="font-size: 9px;" id="c_diesease">
                                <strong> Add New
                                </strong></button> --}}


                            </div>
                            <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-bottom pl-1">
                                <strong>Allergy:</strong> <span id="allergy_con">


                                    @if (!empty($allergies) && count($allergies) > 0)
                                        @foreach ($allergies as $item)
                                            <span>
                                                <span
                                                    class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal"
                                                    style="font-size:10px;" data-modal="common-modal-md"
                                                    data-action="{{ route('add-allergy-uhl') }}">
                                                    {{ $item->allergies_name }}
                                                </span>
                                                <sup>
                                                    <i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2"
                                                        data-allergyid="{{ $item->pat_allergies_no_pk }}"></i>
                                                </sup>
                                            </span>
                                        @endforeach
                                    @endif



                                </span>
                                <span class="cursor-pointer float-right open-modal mt-1" data-modal="common-modal-md"
                                    data-action="{{ route('add-allergy-uhl') }}" title="Add New Allergy"
                                    data-title="Add New Allergy" style="font-size: 9px;">
                                    <i class="fa fa-plus"></i> </span>
                            </div>






                            <table class="m-0">
                                <thead>
                                    <tr class="border-0">
                                        <th class="p-0 px-1 border-0 w-5">Pulse(bpm)</th>
                                        <th class="p-0 px-1 border-0 w-15">BP (mmHg)</th>
                                        <th class="p-0 px-1 border-0 w-10">Temperature (°F)</th>
                                        <th class="p-0 px-1 border-0 w-6">Spo2</th>
                                        <th class="p-0 px-1 border-0 w-6">Respiration</th>
                                        <th class="p-0 px-1 border-0 w-6">Height (cm)</th>
                                        <th class="p-0 px-1 border-0 w-6">Weight (kg)</th>
                                        <th class="p-0 px-1 border-0 w-10">BMI (kg/m <sup>2</sup>)</th>
                                        {{-- <th class="p-0 px-1 border-0">OFC</th> --}}
                                        {{-- <th class="p-0 px-1 border-0 w-10">Assesment</th> --}}
                                        <th class="p-0 px-1 border-0 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-0">
                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="txt_pulse" name="txt_pulse"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pulse_val : '' }}"
                                                maxlength="5">
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 p-0 number_only"
                                                    id="txt_bp_sys" name="txt_bp_sys"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_sys : '' }}"
                                                    maxlength="5">
                                                &nbsp; / &nbsp;
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 p-0 number_only"
                                                    id="txt_bp_dia" name="txt_bp_dia"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bp_val_dia : '' }}"
                                                    maxlength="5">
                                            </div>
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="txt_temperature" name="txt_temperature"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->temp_val : '' }}"
                                                maxlength="5">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="spo2_value" name="spo2_value"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->spo2_value : '' }}"
                                                maxlength="5">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="respiration" name="respiration"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->respiration : '' }}"
                                                maxlength="5">
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="txt_height" name="txt_height"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->height_val : '' }}"
                                                maxlength="5">
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="txt_weight" name="txt_weight"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->weight_val : '' }}"
                                                maxlength="5">
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                id="txt_bmi" name="txt_bmi"
                                                value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bmi : '' }}"
                                                maxlength="5">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            @if (Session::get('user.serviceunit') == 'GYNAE & OBSTETRICS' ||
                                    Session::get('user.serviceunit') == 'Obstetrics & Gynaecology' ||
                                    $patient_information->gender_txt == 'Female')
                                <table class="table border-0 m-0">

                                    <thead>
                                        {{-- <strong class="mt-2">P/A/E :</strong> --}}
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
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="sfh" name="sfh"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->sfh : '' }}">
                                            </td>

                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="fm" name="fm"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->fm : '' }}">
                                            </td>
                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="fhs" name="fhs"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->fhs : '' }}">
                                            </td>

                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="pr" name="pr"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pr : '' }}">
                                            </td>

                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="hq" name="hq"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->hq : '' }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table border-0 m-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="p-0 px-1 border-0">Swelling</th>
                                            <th class="p-0 px-1 border-0 w-20">Scar Work</th>
                                            <th class="p-0 px-1 border-0">Tenderness</th>
                                            <th class="p-0 px-1 border-0">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-0">
                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="swelling" name="swelling"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->swelling : '' }}">
                                            </td>

                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="scar_work" name="scar_work"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->scar_work : '' }}">
                                            </td>
                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="tenderness" name="tenderness"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->tenderness : '' }}">
                                            </td>

                                            <td class="p-0 px-1 border-0">
                                                <input type="text" class="form-control form-control-sm m-0 p-0"
                                                    id="pae_note" name="pae_note"
                                                    value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->pae_note : '' }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-sm-12 bg-white">
                    {{-- <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6> --}}
                    {{-- <div class="card mt-0"> --}}
                    {{-- <div class="card-body pl-3 pr-3"> --}}
                    {{-- <div class="row border">
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 bg-navy border-right border-bottom">
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

                <input type="hidden" class="form-control" id="chronic_text"
                    name="chronic_text" />

                <span class="cursor-pointer float-right mt-1 ml-4"
                    onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm"
                    data-action="{{ route('add-chronic-disease') }}"
                    title="Select Chronic Disease" style="font-size: 9px;"> <i
                        class="fa fa-plus"></i>
                </span>
                <button class="cursor-pointer mt-1 mb-1 pl-2 pr-2 border border-info open-modal"
                    data-modal="common-modal-sm"
                    data-action="{{ route('add-new-chronic-deasease') }}"
                    title="Add New Chronic Disease" style="font-size: 9px;" id="c_diesease">
                    <strong> Add New
                    </strong>
                </button>
            </div>
            <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-bottom pl-1">
                <strong>Allergy:</strong> <span id="allergy_con"></span>
                <span class="cursor-pointer float-right open-modal mt-1"
                    data-modal="common-modal-md" data-action="{{ route('add-allergy') }}"
                    title="Add New Allergy" data-title="Add New Allergy" style="font-size: 9px;">
                    <i class="fa fa-plus"></i> </span>
            </div> --}}

                    <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                        <div class="card mt-0">
                            <div class="card-body pb-2">
                                <div class="table-responsive">
                                    {{-- <table class="table border-0 m-0">
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
                            </table> --}}


                                    <table class="table border-0 m-0 mb-2" hidden>
                                        <thead>
                                            <tr class="border-0">
                                                <th class="p-0 px-1 border-0">Heart </th>
                                                <th class="p-0 px-1 border-0">Lung Condition </th>
                                                @if (Session::get('user.ses_hospital_code') == 'SSG')
                                                    <th class="p-0 px-1 border-0">Per abdominal examination
                                                    </th>
                                                    <th class="p-0 px-1 border-0">CNS</th>
                                                @else
                                                    <th class="p-0 px-1 border-0">Bowel Condition</th>
                                                    <th class="p-0 px-1 border-0">Bladder Condition</th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-0">
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control form-control-sm m-0 p-0"
                                                        id="txt_heart_rate" name="txt_heart_rate"
                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->heart_rate : '' }}">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control form-control-sm m-0 p-0"
                                                        id="txt_lung_condition" name="txt_lung_condition"
                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->lung_condition : '' }}">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 p-0"
                                                            id="txt_bowel_condition" name="txt_bowel_condition"
                                                            value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bowel_condition : '' }}">
                                                    </div>
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control form-control-sm m-0 p-0"
                                                        id="txt_bladder_condition" name="txt_bladder_condition"
                                                        value="{{ !empty($pat_vitals_rs) ? $pat_vitals_rs->bladder_condition : '' }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 p-1 bg-white border-right">
                        <div>
                            <div>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab"
                                            href="#idpconsultaionhistory" role="tab" aria-controls="home"
                                            aria-selected="true">
                                            OPD Consultaion History &nbsp;
                                        </a>
                                        {{-- <a class="nav-link" id="home-tab" data-toggle="tab"
                                                        href="#dischargehistory" role="tab" aria-controls="home"
                                                        aria-selected="true">
                                                        Discharge History &nbsp;
                                                    </a> --}}
                                        {{-- id="btn_emr" --}}
                                        <span id="btn_emr_uhl"
                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer float-right mx-1"><i
                                                class="fa fa-laptop-medical"></i> EMR</span>
                                        {{-- {{ route('pacs.show', 1) }} --}}
                                        {{-- target="_blank" --}}
                                        <a href="#"
                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer float-right mx-1"><i
                                                class="fa fa-laptop-medical"></i> PACS</a>

                                        {{-- <div class="col-md-12 mt-1">
                                                     --}}
                                        <div class="form-group">
                                            @php
                                                $prescription_id = '';
                                                // $riderect_action = route('prescription.create-doctor-wise');

                                                if (Session::get('user.ses_hospital_code') == 'UNICO') {
                                                    //$response_url = route('v2.op_summary_pdf_uhl', $prescription_id);
                                                    $riderect_action = route('prescription.create-doctor-wise-uhl', [
                                                        $appoint_id,
                                                        $patient_code,
                                                        $patient_no_pk,
                                                        $prescription_no_pk,
                                                    ]);

                                                    $response_url = route(
                                                        'opd_prescription_print_uhl',
                                                        $prescription_id,
                                                    );
                                                } else {
                                                    $riderect_action = route('prescription.appointment-list');
                                                    $response_url = route(
                                                        'opd_prescription_print_pdf_uhl',
                                                        $prescription_id,
                                                    );
                                                }
                                            @endphp
                                            <span class="btn btn-md btn-success"
                                                data-response_action="{{ $response_url }}"
                                                onclick="prescriptionFunc.savePrescriptionUhlv2(this);"
                                                data-riderect_action="{{ $riderect_action }}"
                                                title="Click here to save Prescription"><i class="fa fa-save"></i>
                                                Save</span>
                                            <span class="btn btn-md btn-success"
                                                data-action="{{ route('pres-opd-save-update-template') }}"
                                                data-response_action="{{ $response_url }}"
                                                onclick="prescriptionFunc.savePrescriptionAsTemplateV2(this);"
                                                data-riderect_action="{{ $riderect_action }}"
                                                title="Click here to save this Prescription as Tempalte"><i
                                                    class="fa fa-save"></i> Save As Template
                                            </span>
                                            <button type="reset" class="btn btn-info btn-md"
                                                title="Click here to Clear form data">Clear</button>
                                            {{-- <a href="" class="btn btn-danger btn-md" rel="tab"
                                                                    title="Click here to go back to Dashboard">Exit</a> --}}
                                            <a href="{{ route('prescription.appointment-list') }}"
                                                class="btn btn-danger btn-md" rel="tab"
                                                title="Click here to go back to Appointment List" id="back"> <i
                                                    class="fa fa-arrow-left" aria-hidden="true">Exit</i></a>
                                        </div>
                                        {{-- </div> --}}

                                    </div>
                                </nav>
                            </div>

                            <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent"
                                style="max-height: 204px; overflow-y: auto;">
                                <div class="tab-pane fade show active border-bottom" id="idpconsultaionhistory"
                                    role="tabpanel" aria-labelledby="pending-tab">
                                    <table class="table data-table table-hover m-0 text-center">
                                        <thead>
                                            <tr class="border-0">
                                                <th class="p-0 px-1 border-0">Prescription ID</th>
                                                <th class="p-0 px-1 border-0">Date</th>
                                                <th class="p-0 px-1 border-0">Visit Type</th>
                                                <th class="p-0 px-1 border-0 w-20">Department</th>
                                                <th class="p-0 px-1 border-0">Doctor</th>
                                                <th class="p-0 px-1 border-0" style="width: 16%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($pat_pres_list))
                                                @foreach ($pat_pres_list as $pat_pres_uid => $pat_pres_date_app)
                                                    <tr>
                                                        <?php
                                                        $date_app = explode('_', $pat_pres_date_app);

                                                        $patient_code = $date_app[5];
                                                        ?>

                                                        <td>{{ $pat_pres_uid }}</td>

                                                        <td>{{ isset($date_app[0]) ? date('d/m/Y', strtotime($date_app[0])) : '' }}
                                                        </td>
                                                        <td>{{ $date_app[11] }}</td>
                                                        <td>{{ $date_app[7] }}</td>
                                                        <td>{{ $date_app[6] }}</td>
                                                        {{-- <td>
                                                                    <strong
                                                                        @if ($date_app[3] == 1) title="Dental Prescription" @elseif ($date_app[4] == 1) title="Eye Prescription" @endif>{{ $pat_pres_uid }}
                                                            @if ($date_app[3] == 1)
                                                            <i class="fas fa-tooth"></i>
                                                            @endif @if ($date_app[4] == 1)
                                                            <i class="far fa-eye"></i>
                                                            @endif
                                                            </strong>
                                                            </td> --}}
                                                        <td>

                                                            @if ($date_app[9] == Session::get('user.ses_person_no_fk'))
                                                                <span
                                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                    data-presc="" data-presc-type="pre"
                                                                    data-dtls-action="{{ route('get-prescription-dtls-uhl', [$pat_pres_uid, $date_app[5]]) }}"
                                                                    data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2]]) }}"
                                                                    onclick="prescriptionV2.patientPrescriptionDetailsV3(this)"
                                                                    title="Edit Prescription" data-temp="TEMP">
                                                                    <i class="fa fa-prescription"></i>
                                                                </span>
                                                            @endif

                                                            {{-- <span
                                                                    class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                                    data-presc="" data-presc-type="pre"
                                                                    data-dtls-action="{{ route('get-prescription-dtls', [$pat_pres_uid, $date_app[5]]) }}"
                                            data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2]]) }}"
                                            data-disease_action = "{{ route('add-chronic-disease') }}"
                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                            title="Edit Prescription" data-temp="TEMP">
                                            <i class="fa fa-prescription"></i>
                                            </span> --}}
                                                            {{-- @if (Session::get('user.ses_hospital_code') != 'UNICO') --}}
                                                            {{-- <a href="{{ route('opd_prescription_print_pdf_uhl', $pat_pres_uid) }}"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                            target="_blank" data-id="{{ $pat_pres_uid }}"
                                            title="Print Prescription"><i
                                                class="fa fa-file-pdf"></i>
                                            </a> --}}

                                                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                                                {{-- <a href="{{ route('opd_prescription_print_pdf_uhl', $row->prescription_no_pk) }}"
                                            class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank"
                                            data-id="{{ $row->prescription_no_pk }}" title="Print Prescription"><i
                                                class="fas fa-print"></i> Print</a> --}}
                                                                <a href="{{ route('v2.op_summary_pdf_uhl', $pat_pres_uid) }}"
                                                                    class="badge badge-md badge-primary p-1 mb-1 cursor-pointer"
                                                                    target="_blank" data-id="{{ $pat_pres_uid }}"
                                                                    title="OP Summary"><i class="fas fa-print"></i>
                                                                    Print</a>
                                                            @else
                                                                <a href="{{ route('opd_prescription_print_pdf', $pat_pres_uid) }}"
                                                                    class="badge badge-md badge-primary p-1 mb-1 cursor-pointer"
                                                                    target="_blank" data-id="{{ $pat_pres_uid }}"
                                                                    title="Print Prescription"><i
                                                                        class="fas fa-print"></i> Print</a>
                                                            @endif

                                                            {{-- @else
                                                                <a href="{{ route('op_summary_pdf_uhl', $pat_pres_uid) }}"
                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                            target="_blank" data-id="{{ $pat_pres_uid }}"
                                            title="Print Prescription"><i
                                                class="fa fa-file-pdf"></i>
                                            </a>
                                            @endif --}}
                                                            {{-- <span class="btn btn-sm open-modal" style="background-color: #770CCB"
                                                                    data-id="{{ $pat_pres_uid }}"
                                            data-action="{{ route('opd_prescription_print_uhl', $pat_pres_uid) }}" data-modal="common-modal-md"
                                            data-title="Preview Prescription" title="Preview Prescription"><i
                                                class="fa fa-eye text-white"></i> --}}
                                                            {{-- </span> --}}
                                                            {{-- <span class="btn btn-sm"
                                                                onclick="getPresPreviewData(this)"
                                                                style="background-color: #770CCB"
                                                                data-id="{{ $pat_pres_uid }}"
                                            data-title="Preview Prescription"
                                            title="Preview Prescription"><i
                                                class="fa fa-eye text-white"></i>
                                            </span> --}}
                                                            {{-- For Medicine  --}}
                                                            {{-- @if ($date_app[9] == Session::get('user.ses_person_no_fk'))
                                                                <span
                                                                    class="btn btn-outline-info btn-sm bg-none cursor-pointer"
                                                                    data-presc="" data-presc-type="pre"
                                                                    data-dtls-action="{{ route('get-prescription-medicine-dtls-uhl', [$pat_pres_uid, $date_app[5]]) }}"
                                            data-action="{{ route('get-prescription-mst', [$date_app[1], $date_app[2]]) }}"
                                            onclick="prescriptionV2.patientPrescriptionMedicineDetails(this)"
                                            title="Edit Medicine Only" data-temp="TEMP">
                                            <i class="fa fa-pills"></i>
                                            </span>
                                            @endif --}}

                                                            @if ($date_app[10] != '')
                                                                @if (Session::get('user.serviceunit') != 'Anesthesiology')
                                                                    <a href="{{ route('ipd.anaesthetic-refferral-form-pdf', $date_app[10]) }}"
                                                                        class="btn btn-sm btn-warning"
                                                                        target="_blank">
                                                                        <i class="fa fa-stethoscope"></i>

                                                                        {{-- PAC (Anaesthetic Reply) --}}
                                                                    </a>

                                                                    <a href="{{ route('ipd.pre-anesthetic-patient-checkup-pdf', [$date_app[2], $date_app[10]]) }}"
                                                                        class="btn btn-sm btn-warning"
                                                                        target="_blank">
                                                                        <i class="fa fa-file-medical"></i>
                                                                        {{-- Pre‑Anesthesia PDF --}}
                                                                    </a>
                                                                @endif
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 bg-none">
                        <div class="card-body" id="presc_details_uhl">
                            @include('admin.prescription.uhl.prescription_details_doctor_wise2')
                        </div>
                    </div>
                </div>
            </div>
        </form>


        {{-- Obstetrical History Modal --}}
        <div class="modal fade" id="ObstetricalHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="ObstetricalHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Obstetrical History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="obstetricalhistory_data">
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="marrid_for_div" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="married_for"
                                                name="married_for" placeholder="Married For "
                                                value="{{ isset($lmp->married_for) ? $lmp->married_for : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="para_div" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="para"
                                                name="para" placeholder="Para "
                                                value="{{ isset($lmp->para) ? $lmp->para : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="gravida"
                                                name="gravida" placeholder="GRAVIDA "
                                                value="{{ isset($lmp->gravida) ? $lmp->gravida : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="alc"
                                                name="alc" placeholder="ALC"
                                                value="{{ isset($lmp->alc) ? $lmp->alc : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="ObstetricalHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menstrual History Modal --}}
        <div class="modal fade" id="MenstrualHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="MenstrualHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Menstrual History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="menstrualhistory_data">
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="menstrual_cycle"
                                                name="menstrual_cycle" placeholder="Menstrual Cycle"
                                                value="{{ isset($lmp->menstrual_cycle) ? $lmp->menstrual_cycle : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="mp"
                                                name="mp" placeholder="MP"
                                                value="{{ isset($lmp->mp) ? $lmp->mp : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="mf"
                                                name="mf" placeholder="MF"
                                                value="{{ isset($lmp->mf) ? $lmp->mf : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="dysmenorrhoea"
                                                name="dysmenorrhoea" placeholder="Dysmenorrhoea"
                                                value="{{ isset($lmp->dysmenorrhoea) ? $lmp->dysmenorrhoea : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0 date_picker"
                                                id="lmp" name="lmp" placeholder="LMP"
                                                value="{{ isset($lmp->lmp) ? $lmp->lmp : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0 date_picker_1"
                                                id="edd" name="edd" placeholder="Enter EDD "
                                                value="{{ isset($lmp->edd) ? $lmp->edd : '' }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="MenstrualHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contraceptive History Modal --}}
        <div class="modal fade" id="ContraceptiveHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="ContraceptiveHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contraceptive History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="contraceptive_data">
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0"
                                                id="contraceptive_history" name="contraceptive_history"
                                                placeholder="Contraceptive History"
                                                value="{{ isset($lmp->contraceptive_history) ? $lmp->contraceptive_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="ContraceptiveHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Drug History Modal --}}
        <div class="modal fade" id="DrugHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="DrugHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Drug History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="drug_data">
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="drug_history"
                                                name="drug_history" placeholder="Drug History"
                                                value="{{ isset($lmp->drug_history) ? $lmp->drug_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="DrugHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Surgical History Modal --}}
        <div class="modal fade" id="SurgicalHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="SurgicalHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Surgical History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="surgical_data">
                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 100%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="surgical_history"
                                                name="surgical_history" placeholder="Surgical History"
                                                value="{{ isset($lmp->surgical_history) ? $lmp->surgical_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="SurgicalHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Medical History Modal --}}
        <div class="modal fade" id="MedicalHistoryModal" tabindex="-1" role="dialog"
            aria-labelledby="MedicalHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Medical History
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="medical_data">

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="medical_history"
                                                name="medical_history" placeholder="Medical History"
                                                value="{{ isset($lmp->medical_history) ? $lmp->medical_history : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="MedicalHistoryBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Clinical Examination Modal --}}
        <div class="modal fade" id="ClinicalExaminationModal" tabindex="-1" role="dialog"
            aria-labelledby="ClinicalExaminationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Clinical Examination
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="clinicalexamination_data">

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">Pelvic
                                            Examination</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="perineum_and_vulva"
                                                name="perineum_and_vulva" placeholder="Perineum and Vulva"
                                                value="{{ isset($lmp->perineum_and_vulva) ? date('d-m-Y', strtotime($lmp->perineum_and_vulva)) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">P/S/E</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="cx"
                                                name="cx" placeholder="CX"
                                                value="{{ isset($lmp->cx) ? date('d-m-Y', strtotime($lmp->cx)) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="vaginal_wall"
                                                name="vaginal_wall" placeholder="Vaginal wall"
                                                value="{{ isset($lmp->vaginal_wall) ? date('d-m-Y', strtotime($lmp->vaginal_wall)) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="discharge"
                                                name="discharge" placeholder="Discharge"
                                                value="{{ isset($lmp->discharge) ? $lmp->discharge : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="">B/M/E</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="uterus"
                                                name="uterus" placeholder="Uterus"
                                                value="{{ isset($lmp->uterus) ? $lmp->uterus : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="adnexa"
                                                name="adnexa" placeholder="Adnexa"
                                                value="{{ isset($lmp->adnexa) ? $lmp->adnexa : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="obs" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body border-bottom pt-1 pb-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="bme_note"
                                                name="bme_note" placeholder="Note"
                                                value="{{ isset($lmp->bme_note) ? $lmp->bme_note : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="border:none">D/R/E</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="d_r_e"
                                                name="d_r_e" placeholder="D/R/E"
                                                value="{{ isset($lmp->d_r_e) ? $lmp->d_r_e : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 p-0" id="married_for" style="max-width: 93%;">
                                <div class="card my-0">
                                    <div class="card-body pt-1 pb-0">
                                        <span class="card-header" style="border:none">Breast
                                            Examination</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-0" id="breast_examination"
                                                name="breast_examination" placeholder="Breast Examination"
                                                value="{{ isset($lmp->breast_examination) ? $lmp->breast_examination : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" onclick="ClinicalExaminationBtn(this)"
                            class="btn btn-md btn-success">Set</button>
                    </div>
                </div>
            </div>
        </div>
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
                                                        name="item_name[]"
                                                        value="{{ $history_item->detail_name }}">
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
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
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
                            <input type="text" class="form-control" id="new_dropdown_opt"
                                name="new_dropdown_opt" value="" placeholder="Enter new option" required>
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
<script src="{{ asset('js/custom_v2.js') }}"></script>
<script type="text/javascript">
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    window.routes = {
        storeChiefComplain: "{{ route('prescription-lookup.storeprescriptionlookupitemdoctor-chiefcomplain') }}"
    };

    $(document).on("change", "#option_for_wb", function(e) {
        var option_for_wb_val = $(this).find(':selected').val();
        if (option_for_wb_val == 'yes') {
            $("#oxygen").closest('td').removeClass('d-none');
        } else {
            $("#oxygen").closest('td').addClass('d-none');
        }
    });

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

        $(document).on("click", "#btn_emr_uhl", function(e) {
            var hdn_patient_id = $("#hdn_patient_id").val();
            console.log(hdn_patient_id);
            if (hdn_patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                return;
            } else {
                var hdn_patient_id = $("#hdn_patient_id").val();
                window.open("{{ route('emr.patient-emr-uhl') }}/" + hdn_patient_id, "_blank");
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
                url: "{{ route('prescription-templates-uhl', 2) }}",
                type: "get",
                beforeSend: function() {
                    $("#template-container div").html(
                        '<i class="spinner-border spinner"></i>');
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

    $(document).ready(function() {
        var a = $("#hidden_appoint_id").val();
        var b = $("#hidden_patient_code").val();
        var c = $("#hidden_patient_no_pk").val();
        var d = $("#hidden_prescription_no_pk").val();
        // prescriptionFunc.patientPrescriptionDetailsUHL(c, b, a, d);
        var action = "{{ route('get-prescription-mst', [':appointment_no', ':patien_id']) }}";
        action = action.replace(':appointment_no', a);
        action = action.replace(':patien_id', c);
        //  action =action.replace(':prescription_no',prescription_no);
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hidden_appoint_id").val();
        var temp = '';
        $.ajax({
            url: action,
            type: "get",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // var chronic = data["chronic_disease"];
                // var allergy = data["allergie_data"];
                // var investigation = data["investigation_data"];
                // var chro_dis = "";
                // var chor_hdn = "";
                // var chor_text = "";
                // var chor_hdn_text = "";
                // var allergy_text = "";

                // chronic.forEach(function (item) {
                //     var chor_text =
                //         item.chronic_dis_description != null
                //             ? item.chronic_dis_description
                //             : "";
                //     $("#chronic_con").append(
                //         `<span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1" style="font-size:10px;" onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm" data-action="route(add-chronic-disease)">${item.chronic_dis_name}</span>`
                //     );
                //     chor_hdn +=
                //         item.chronic_dis_item_pk_no_fk +
                //         "_" +
                //         item.chronic_dis_name +
                //         "*";
                //     chor_hdn_text +=
                //         item.chronic_dis_item_pk_no_fk + "_" + chor_text + "*";
                // });
                // allergy.forEach(function (aller) {
                //     $("#allergy_con").append(
                //         `<span><span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal" style="font-size:10px;" data-modal="common-modal-md" data-action=" route('add-allergy') ">${aller.allergies_name}</span> <sup><i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2" data-allergyid="${aller.pat_allergies_no_pk}"></i></sup></span></span>`
                //     );
                // });

                // investigation start
                // investigation.forEach(function (item) {
                //     $("#investigation").append(
                //         `<span><span >${item.prescrition_data}</span></span>`
                //     );
                // });

                // console.log(data["vitals"].sfh)
                // Investigation end

                // $("#chrn-items").val(chor_hdn);
                // $("#chronic_text").val(chor_hdn_text);

                // //$("#patient_name").html('');
                // var mobile = data["appointments"].mobile1 ?? "";
                // var occupation = data["appointments"].occupation ?? "";
                $("#hdn_appointment_id").val(
                    data["appointments"].appoint_no_pk
                );
                $("#hdn_patient_id").val(data["appointments"].patient_no_pk);
                $("#hdn_patient_code").val(data["appointments"].patient_code);
                $("#patient_name").html(
                    "Name :" + data["appointments"].patient_name
                );
                // $("#patient_age").html("Age :" + data["appointments"].age);
                // $("#maritial_status").html("Marritial Status :" + data["appointments"].marital_status_txt);
                // $("#patient_mobile").html("Mobile :" + mobile);
                // $("#patient_occupation").html("Occupation :" + occupation);
                console.log(data['vitals']);

                $("#txt_pulse").val(data["vitals"].pulse_val);
                $("#txt_bp").val(data["vitals"].bp_val_sys);
                $("#txt_temperature").val(data["vitals"].temp_val);
                $("#txt_height").val(data["vitals"].height_val);
                $("#txt_weight").val(data["vitals"].weight_val);
                $("#txt_ofc").val(data["vitals"].ofc);
                $("#txt_bmi").val(data["vitals"].bmi);
                $("#txt_heart_rate").val(data["vitals"].bmi);
                $("#txt_bp_sys").val(data["vitals"].bp_val_sys);
                $("#txt_bp_dia").val(data["vitals"].bp_val_dia);
                $("#txt_heart_rate").val(data["vitals"].heart_condition);
                $("#txt_lung_condition").val(data["vitals"].lung_condition);
                $("#txt_bowel_condition").val(data["vitals"].bowel_condition);
                $("#sfh").val(data["vitals"].sfh);
                $("#fm").val(data["vitals"].fm);
                $("#fhs").val(data["vitals"].fhs);
                $("#pr").val(data["vitals"].pr);
                $("#hq").val(data["vitals"].hq);
                $("#swelling").val(data["vitals"].swelling);
                $("#scar_work").val(data["vitals"].scar_work);
                $("#tenderness").val(data["vitals"].tenderness);
                $("#pae_note").val(data["vitals"].pae_note);
                if (data["vitals"].oxygen != 0 && data["vitals"].oxygen != null) {
                    $("#oxygen").closest('td').removeClass('d-none');
                    $("#oxygen").val(data["vitals"].oxygen);
                    $("#option_for_wb").val('yes')
                } else {
                    $("#option_for_wb").val('no')
                    $("#oxygen").closest('td').addClass('d-none');
                }
                $("#spo2_value").val(data["vitals"].spo2_value);
                $("#respiration").val(data["vitals"].respiration);

                // $("#txt_bladder_condition").val(
                //     data["vitals"].bladder_condition
                // );

                // chronic hide show
                // $('#c_diesease').hide();

                if (temp == 'TEMP') {
                    $("#hdn_prescription_id").val('');
                    $("#hdn_appointment_id").val(app_id);
                } else {
                    $("#hdn_prescription_id").val(
                        data["vitals"].prescription_no_fk
                    );
                }

            },
            complete: function(data) {
                // $(thisElement)
                //     .parents("tr")
                //     .addClass("bg-success");
                // var prescription_id = $(thisElement).attr("data-presc");
                // var dtls_action ="{{ route('get-prev-prescription-dtls', [':patien_id', ':patient_code']) }}"; //$(thisElement).attr("data-dtls-action");
                //  dtls_action =dtls_action.replace(':patien_id',c); //$(thisElement).attr("data-dtls-action");
                //  dtls_action =dtls_action.replace(':patient_code',b); //$(thisElement).attr("data-dtls-action");
                // var hdn_appointment_id = $("#hdn_appointment_id").val();
                previewTab();
                $.unblockUI();
                // $.ajax({
                //     data: {
                //         hdn_su_no: hdn_su_no,
                //         hdn_appointment_id: a
                //     },
                //     url: dtls_action,
                //     type: "get",
                //     beforeSend: function () {
                //         blockUI();
                //     },
                //     success: function (data) {
                //         $("#presc_details").html("");
                //         $("#presc_details").html(data);
                //     },
                //     complete: function (data) {
                //         $.unblockUI();
                //     }
                // });

            }
        });
    })

    function getPresPreviewData(element) {
        var dataId = $(element).data('id');
        $.ajax({
            url: "{{ route('opd_prescription_preview_uhl') }}",
            type: "GET",
            data: {
                prescription_id: dataId
            },
            success: function(data) {
                var inv_cc_find = data[0];
                var past_medicine = data[2];
                var current_medicine = data[3];
                var relevent_history = data[4];

                $('#prescriptionPreview').removeClass('hidden_cc');
                $('#prescriptionAdvicePreview').removeClass('hidden_advice');
                $('#prescriptionReleventPreview').removeClass('hidden_relevent');
                $('#prescriptionInvestigationPreview').removeClass('hidden_investigation');
                $('#prescriptionMedichinePreview').removeClass('hidden_medichine');
                $('#currentMedichinePreview').removeClass('hidden_current_medichine');
                var tbody = $('#cc_preview tbody');
                tbody.empty();

                var tbody_advice = $('#advice_preview tbody');
                tbody_advice.empty();

                var tbody_relevent = $('#relevent_preview tbody');
                tbody_relevent.empty();

                var tbody_investigation = $('#investigation_preview tbody');
                tbody_investigation.empty();

                var tbody_medichine = $('#medichine_prev tbody');
                tbody_medichine.empty();

                var tbody_current_medichine = $('#current_medichine_prev tbody');
                tbody_current_medichine.empty();

                inv_cc_find.forEach(function(inv_cc_find) {
                    if (inv_cc_find.lookup_uid === 'CHIEFCOM' || inv_cc_find.lookup_uid ===
                        'CLINICHIST' || inv_cc_find.lookup_uid === 'ICD') {
                        var row = '<tr><td><strong>*</strong> ' + inv_cc_find.prescrition_data +
                            '</td></tr>';
                        tbody.append(row);
                    }
                });

                inv_cc_find.forEach(function(inv_cc_find) {
                    if (inv_cc_find.lookup_uid === 'FINDINGS' || inv_cc_find.lookup_uid ===
                        'INVFIND') {
                        var row = '<tr><td><strong>*</strong> ' + inv_cc_find.prescrition_data +
                            '</td></tr>';
                        tbody_investigation.append(row);
                    }
                });

                inv_cc_find.forEach(function(inv_cc_find) {
                    if (inv_cc_find.lookup_uid === 'ADVICE' || inv_cc_find.lookup_uid ===
                        'ADVICE') {
                        var row = '<tr><td><strong>*</strong> ' + inv_cc_find.prescrition_data +
                            '</td></tr>';
                        tbody_advice.append(row);
                    }
                });

                if (relevent_history.medical_history) {
                    var row = '<tr><td><strong>*</strong> ' + relevent_history.medical_history +
                        '</td></tr>';
                    tbody_relevent.append(row);
                }

                if (relevent_history.past_history) {
                    var row = '<tr><td><strong>*</strong> ' + relevent_history.past_history + '</td></tr>';
                    tbody_relevent.append(row);
                }

                if (relevent_history.family_history) {
                    var row = '<tr><td><strong>*</strong> ' + relevent_history.family_history +
                        '</td></tr>';
                    tbody_relevent.append(row);
                }

                if (relevent_history.complaints_history) {
                    var row = '<tr><td><strong>*</strong> ' + relevent_history.complaints_history +
                        '</td></tr>';
                    tbody_relevent.append(row);
                }

                past_medicine.forEach(function(past_medicine, index) {
                    if (past_medicine.item_type === 'MED') {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td style="text-align: left";>' + past_medicine.item_name + '</td>' +
                            '</tr>';
                        tbody_medichine.append(row);
                    }
                });


                current_medicine.forEach(function(current_medicine, index) {
                    if (current_medicine.item_type === 'MED') {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td style="text-align: left";>' + current_medicine.item_name +
                            '</td>' + '</tr>';
                        tbody_current_medichine.append(row);
                    }
                });

            },
            error: function(error) {}
        });
    }

    function previewTab() {


        var $favouritListTitle = $("#favourit_list_title");
        if ($favouritListTitle.length) {
            var append_to = $favouritListTitle.attr("data-append-to");
            console.log("append_to:", append_to);
        } else {
            console.warn("#favourit_list_title element not found.");
        }


        var othersValues = $(
            '#ipd_referred_advice, #ipd_referred_date, #reffered_reason,#medical_history, #family_history, #past_history,#txt_referred_doctor,#note,#global_hidden_note,#investigation_findings_txt'
        ).map(function() {
            return $(this).val();
        }).get();





        var lookup = '';
        var checkedLook = [];
        var cc_preview = `<ul>`;
        // Cheif complaint
        $('input[name="item_name[]"]').each(function(index) {
            lookup = $('input[name="lookup_code[]"]').eq(index).attr('value');
            if (lookup == 'CHIEFCOM' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Chief Complaint</b></li>`;
            }
            if (lookup == 'CLINICHIST' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Clinical Examination</b></li>`;
            }
            if (lookup == 'ICD' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Provisional Diagnosis</b></li>`;
            }
            if (lookup == 'INVFIND' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Investigation / Procedure</b></li>`;
            }
            if (lookup == 'FINDINGS' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Investigation Findings</b></li>`;
            }
            if (lookup == 'ADVICE' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Advice</b></li>`;
            }

            if (lookup == 'PROCEDURE' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Management Plan</b></li>`;
            }

            if (lookup == 'ACUP' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>TCM</b></li>`;
            }

            if (lookup == 'PTET' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Electro Therapy</b></li>`;
            }

            if (lookup == 'PTTE' && $.inArray(lookup, checkedLook) == -1) {
                cc_preview += `<li><b>Therapeutic Exercise</b></li>`;
            }

            cc_preview += `<li>${$(this).val()}</li>`;

            checkedLook.push(lookup)
        });
        cc_preview += `</ul>`;

        $("#chief_complaint_preview").html(cc_preview);

        // var othersValueHtml = '<b>Others</b><ol>';
        // othersValues.forEach(function(value, index) {
        //     othersValueHtml += '<li>' + value + '</li>';
        // });
        // othersValueHtml += '</ol>';

        // Initialize the HTML string with a title
        var othersValueHtml = '<b>Others</b><ol>';
        othersValues.forEach(function(value) {
            var formattedValue = nl2br(value);
            othersValueHtml += '<li>' + formattedValue + '</li>';
        });

        // Close the ordered list tag
        othersValueHtml += '</ol>';

        $('#others_preview').html(othersValueHtml);

        var med_prev = `
                <table style="width: 100%;">
                <tr>
                    <td></td>
                    <td><h5 class="mb-0"><strong>R<sub>x</sub></strong></h5></td>
                </tr>
                <tr>
                <td width="10%" valign="top" style="border-right: 1px solid; padding: 10px;"></td>
                    <td class="text-left pl-2" valign="top">
                        <div class="mb-2">
                        <div class="mt-10">
                <table>`;

        var hasData = false;
        var itemCount = 0;



        var medicineCounts = {}; // Object to track the count of each medicine item
        var groupedMedicines = {}; // Object to group medicines by name

        $('input[name="medicine_item[]"]').each(function(index) {
            var medicineValue = $(this).val();
            // var generic_name = $('input[name="hdn_genetic_id[]"]').eq(index).val();
            // var key = "<strong>" + generic_name.toUpperCase() + "</strong>" + " (" + medicineValue + ")";
            var generic_name = $('input[name="hdn_genetic_id[]"]').eq(index).val() || '';
            var key = "<strong>" + generic_name.toUpperCase() + "</strong>" + " (" + medicineValue + ")";
            var selectedDose = $('select[name="medicine_dose[]"]').eq(index).val();
            var selectedDoseText = $('select[name="medicine_dose[]"]').eq(index).find('option:selected').text();
            var selectedRoute = $('select[name="medicine_route[]"]').eq(index).val();
            var selectedRouteText = $('select[name="medicine_route[]"]').eq(index).find('option:selected')
                .text();
            var instructionValue = $('select[name="instruction[]"]').eq(index).val();
            var durationValue = $('input[name="medicine_duration_type[]"]').eq(index).val();
            var selectedduration_mu = $('select[name="medicine_duration_mu[]"]').eq(index).val();
            var selectedduration_muText = $('select[name="medicine_duration_mu[]"]').eq(index).find(
                'option:selected').text();

            if (medicineValue != '' && selectedDose) {
                // Initialize the medicine group if not already
                if (!groupedMedicines[key]) {
                    groupedMedicines[key] = [];
                }

                // Add the current dose to the group's list
                groupedMedicines[key].push({
                    dose: selectedDoseText,
                    route: selectedRouteText,
                    instruction: instructionValue,
                    duration: durationValue,
                    duration_mu: selectedduration_muText
                });
            }
        });
        console.log(groupedMedicines)
        // Generate the HTML content based on groupedMedicines
        var med_prev = '';
        var itemCount = 0;
        for (var medicineName in groupedMedicines) {
            if (groupedMedicines.hasOwnProperty(medicineName)) {
                itemCount++;
                med_prev += `<tr>
                        <td valign="top"><strong>${itemCount}.</strong></td>
                        <td valign="top">
                            <div>
                            ${medicineName}
                            </div>
                            <div class="mt-10">
                                <table>`;
                groupedMedicines[medicineName].forEach(function(med, index) {
                    med_prev += `<tr>
                            <td valign="top">
                                <div class="mb-2">
                                    <strong>

                                        ${med.dose ? ' - ' + med.dose : ''}
                                        ${med.route ? ' - ' + med.route : ''}
                                        ${med.instruction ? ' (' + med.instruction + ')' : ''}

                                        ${med.duration === '' ? '' :
                                        med.duration && med.duration_mu !== 'CONTINUE' && med.duration !== 'Continue' ?
                                            ` --- [${med.duration} ${med.duration_mu}]` :
                                            ' --- [Continue]'
                                        }
                                    </strong>
                                </div>
                            </td>
                          </tr>`;
                });
                med_prev += `    </table>
                        </div>
                      </td>
                    </tr>`;
            }
        }


        if (hasData) {
            med_prev += `
                            </table>
                                </div>
                                </div>
                            </td>
                            </tr>
                            </table>`;
        }

        $("#medichine_preview").html(med_prev);

    }

    $('#back').on('click', function(e) {
        e.preventDefault();
        if (!confirm('Do you want to go back?')) return false;
    });

    function nl2br(str) {
        return str.replace(/\n/g, '<br>');
    }
</script>
