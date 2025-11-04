
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
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

    #examination ul {

        list-style: none;

        margin-bottom: 0px;

        padding-left: 25px;

    }



    #examination li {

        list-style: none;

        margin-bottom: 0px;

    }
</style>
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0">OPD Nurse Station</h5>
                <small>Nurse Station / OPD Nurse Station</small>
            </div>
            <div class="col-8">

            </div>
        </div>

        <form method="post" id="frm-pat-prescription" action="{{ route('opd-nurse-station-vital-save-update') }}"
            autocomplete="off" onsubmit="">
            @csrf
            <input type="hidden" id="opd_nurse_vital_redirect_action" name="opd_nurse_vital_redirect_action"
                value="" />
            <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" />
            <input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id"
                value="" />
            <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                value="" />
            <input type="hidden" id="hdn_service_id" name="hdn_service_id"
                value="" />
            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id"
                value="" />
                <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="" />
            <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                value="" />
            <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                value="" />
            <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                value="" />
            <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="" />
            <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="" />
            <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                value="" />
            <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                value="" />
            <input type="hidden" id="hdn_add_pres_favourit_url" value="" />
            <input type="hidden" id="hdn_interaction_url" value="" />
            <div class="row border-bottom-dark">
                <div class="form-row mt-1 mb-1 w-50">
                    <div class="col">
                        <input type="text" class="form-control bg-white" id="barcode" name="barcode"
                            value="" placeholder="Barcode"
                            style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                    </div>
                </div>
                    <div class="form-row mt-1 mb-1 w-100">
                        <div class="col">
                            <select class="custom-select" name="hdn_su_no" id="hdn_su_no">
                                <option value="0">Select Department</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="service_id" name="service_id"
                                value="" placeholder="Search Patient By Service ID/ Name / Phone NO."
                                data-emr-route=""
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


                <div class="col-md-12 col-lg-12 col-sm-12 p-2 bg-white">
                    <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6>
                    <div class="card mt-0">
                        <div class="card-body pl-3 pr-3">
                            <div class="row border">
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 mb-2 border-right ">
                                    <div id="patient_info">

                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name" class="pl-2"> <strong>Name :
                                                    </strong>
                                                </td>
                                                <td rowspan="2" width="30" class="p-2" id="patient_img"
                                                    data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('images/doc-1.png') }}" width="30"
                                                        alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong>Patient Code :
                                                    </strong>
                                                    <strong>Patient Type :
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong> Gender : </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong> Age : </strong></td>
                                            </tr>
                                            <tr>
                                                <td id="patient_mobile" class="pl-2"> <strong> Mobile No :
                                                    </strong><strong> Address :
                                                    </strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 border-right border-bottom">
                                    <!-- <div id="patient_info">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name_other" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="ref_patient_img" data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('img/doc-1.png') }}" width="30" alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age_other" class="pl-2"></td>
                                            </tr>
                                        </table>
                                    </div> -->
                                    <div
                                        class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-right border-bottom pl-1">
                                        <input type="hidden" id="chronic-route"
                                            value="">
                                        <input type="hidden" id="chronic-route-save"
                                            value="">
                                        <input type="hidden" id="chronic-route-delete">
                                        <strong>Chronic Disease:</strong> <span id="chronic_con">
                                                    <span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1"
                                                        style="font-size:10px;"
                                                        onclick="prescriptionFunc.addChronicItem(this)"
                                                        data-modal="common-modal-sm"
                                                        data-action="{{ route('add-chronic-disease') }}"></span>
                                       
                                        </span>
                                        <input type="hidden" class="form-control" id="chrn-items" name="chrn_items"
                                            value="" />
                                        <input type="hidden" class="form-control" id="chronic_text"
                                            name="chronic_text" value="">
                                        <span class="cursor-pointer float-right mt-1"
                                            onclick="prescriptionFunc.addChronicItem(this)"
                                            data-modal="common-modal-sm"
                                            data-action="{{ route('add-chronic-disease') }}"
                                            title="Add New Chronic Disease" style="font-size: 9px;"> <i
                                                class="fa fa-plus"></i> </span>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-bottom pl-1">
                                        <strong>Allergy:</strong>
                                        <span id="allergy_con">
                                                    <span id="allergy_data">
                                                        <span
                                                            class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal"
                                                            style="font-size:10px;" onclick=""
                                                            data-modal="common-modal-md"
                                                            data-action="{{ route('add-allergy') }}"></span>
                                                        <sup> <i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2"
                                                                data-allergyId=""></i></sup>
                                                    </span>
                                        </span>

                                        <input type="hidden" class="form-control" id="allergie-items"
                                            name="allergie_items" value="" />
                                        <span class="cursor-pointer float-right open-modal mt-1"
                                            data-modal="common-modal-md" data-action="{{ route('add-allergy') }}"
                                            title="Add New Allergy" data-title="Add New Allergy"
                                            style="font-size: 9px;"> <i class="fa fa-plus"></i> </span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                                <div class="card mt-0">
                                    <div class="card-body pb-0">
                                        <div class="table-responsive">
                                            <table class="table border-0 m-0">
                                                <thead>
                                                    <tr class="border-0">
                                                        <th class="p-0 px-1 border-0">Pulse(bpm)</th>
                                                        <th class="p-0 px-1 border-0 w-20">BP(mmHg)</th>
                                                        <th class="p-0 px-1 border-0">Temperature(°F)</th>
                                                        <th class="p-0 px-1 border-0">Height(cm)</th>
                                                        <th class="p-0 px-1 border-0">Weight(kg)</th>
                                                        <th class="p-0 px-1 border-0">BMI(kg/m <sup>2</sup> )</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-0">
                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_pulse" name="txt_pulse"
                                                                value="">
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
                                                                value="" placeholder="eg.170 cm">
                                                        </td>

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_weight" name="txt_weight"
                                                                value="" placeholder="eg. 80 kg">
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

                                            <table class="table border-0 m-0">
                                                <thead>

                                                    <tr>
                                                        <th class="p-0 px-1 border-0">Heart </th>
                                                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                            <th class="p-0 px-1 border-0">OFC</th>
                                                        @endif

                                                        <th class="p-0 px-1 border-0">SPO <sub>2</sub></th>
                                                        <th class="p-0 px-1 border-0">RR</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_heart_rate" name="txt_heart_rate"
                                                                value="">
                                                        </td>
                                                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_ofc" name="txt_ofc"
                                                                    value="">
                                                            </td>
                                                        @endif

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_spo2_value" name="txt_spo2_value"
                                                                value="">
                                                        </td>

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_rr_value" name="txt_rr_value"
                                                                value="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table border-0 m-0">
                                                <thead>

                                                    <tr>
                                                        <th class="p-0 px-1 border-0">Lung </th>

                                                        <th class="p-0 px-1 border-0">
                                                            Bowel

                                                        </th>

                                                        <th class="p-0 px-1 border-0">Bladder</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_lung" name="txt_lung"
                                                                value="">
                                                        </td>

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_bowel" name="txt_bowel"
                                                                value="">
                                                        </td>


                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_bladder" name="txt_bladder"
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


            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 bg-none">
                        <div class="card-body" id="presc_details">
                            @include('admin.cph.patient_appointment.vital_details_nurse_wise_cph')
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
                                                        <div class="col-md-1">

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
                                                        <input type="hidden" class="form-control pres_lookup_no_pk"
                                                            name="pres_lookup_no_pk[]"
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

                            <div class="modal-footer py-1">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"
                                        onclick="saveExamination()">Save</button>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available </h4>
                            </div>
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
                                                    <div class="col-md-1">

                                                    </div>
                                                <div class="col-md-4">
                                                    <p></p>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type=""
                                                        class="form-control item_dtl_val text-left"
                                                        name="item_dtl_val[]">
                                                    <input type="hidden" class="form-control item_name "
                                                        name="item_name[]" value="">
                                                    <input type="hidden" class="form-control lookup_id"
                                                        name="item_name[]"
                                                        value="">
                                                    <input type="hidden" class="form-control pres_lookup_no_pk"
                                                        name="pres_lookup_no_pk[]"
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
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>

                </div>

            </div>
        </div>
    </div>
</section>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
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


    });
</script>
