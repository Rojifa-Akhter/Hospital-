<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">


<style>
    .redactor_box {
        margin-bottom: 0px;
    }



    .card {
        border: 1px solid rgb(164 224 255);
    }

    .pat_hospital_info {
        margin-right: 20px;
    }

    .discharge_template_list .card-body {
        height: 100px;
        overflow-y: auto;
    }


    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */
    }
    .select2-selection__rendered{
        text-align: left !important;
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .prescription-table>thead>tr>th{
        font-size: 12px !important;
        white-space: nowrap;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden;
        width: 120px;
    }

</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-10">
            <h5 class="mt-2 mb-0">Discharge Summary</h5>
            <small>IPD / Discharge Summary</small>
        </div>
        <div class="col-md-2">
            <a class="btn btn-md btn-warning" target="_blank"
                href="{{route('report.new-discharge',[$admission_info->admission_no_pk])}}">PDF
                Export</a>
        </div>
        
    </div>

    {{-- patient information --}}
    <form action="{{ route('ipd.store-discharge-summary') }}" method="post" id="dischargeForm">@csrf
        <div class="form-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-user"></i>&nbsp; Patient information</h5>
                    </div>
                    <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
                        <div class="patient-infos" style="width: 85%">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="text-left">Patient ID</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}
                                        </td>
                                        <th class="text-left">Name</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Age</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->age) && $paitent_info->age != 0 ? $paitent_info->age : '' }}
                                        </td>
                                        <th class="text-left">Gender</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Blood Group</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->blood_group_txt) ? $paitent_info->blood_group_txt : '' }}
                                        </td>
                                        {{-- <th class="text-left">Marital Status</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->marital_status_txt) ? $paitent_info->marital_status_txt : '' }}
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        {{-- <th class="text-left">Contact</th>
                                        <td class="text-left">
                                            {{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}
                                        </td> --}}
                                        {{-- <th class="text-left">Address</th>
                                        <td colspan="3" class="text-left">
                                            {{ isset($paitent_info->present_addr) ? $paitent_info->present_addr : '' }}
                                        </td> --}}
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="patient-img text-center" style="width: 15%;">
                            <img class="w-100" src="{{ asset('images/boy.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-user"></i>&nbsp;Admission information</h5>
                    </div>
                    <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
                        <div class="patient-infos">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="text-left">Admission ID </th>
                                        <td colspan="3" class="text-left">
                                            {{ isset($admission_info->admission_uid) ? $admission_info->admission_uid : '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Admission Date</th>
                                        <td class="text-left">
                                            {{ isset($admission_info->admission_date) ? date('d/m/Y H:i:s', strtotime($admission_info->admission_date)) : '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-left">Bed/Cabin</th>
                                        <td colspan="3" class="text-left">
                                            {{ isset($admission_info->new_bed_name) ? $admission_info->new_bed_name : '' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th class="text-left">Ward Name</th>
                                        <td class="text-left">
                                            {{ isset($admission_info->new_ward_name) ? $admission_info->new_ward_name : '' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-body p-2">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="discharge_doctor">Discharge
                                        Doctor</label>
                                    <input type="text" id="doctor_code" name="doctor_name" class="form-control"
                                        value="{{ $admission_info->discharge_doc_name }}">
                                    <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id"
                                        value="{{ $admission_info->discharge_doc_person_no_fk }}"
                                        class="form-control">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id"
                                        value="{{ $admission_info->admission_no_pk }}" class="form-control">
                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                                        value="{{ $admission_info->patient_no_fk }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="referral_doctor_name">Referral
                                        Doctor</label>
                                    <input type="text" id="doctor_code1" name="referral_doctor_name" class="form-control"
                                        value="{{ $admission_details->referral_doctor_name ?? '' }}">

                                    <input type="hidden" id="hdn_ref_doctor_id" name="hdn_ref_doctor_id"
                                        value="{{ $admission_details->referral_doc_person_no_fk ?? '' }}"
                                        class="form-control">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id"
                                        value="{{ $admission_details->admission_no_pk }}" class="form-control">
                                    {{-- <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                                        value="{{ $admission_details->patient_no_fk }}" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="prepare_doctor_name">Prepare
                                        Doctor</label>
                                    <input type="text" id="doctor_code3" name="prepare_doctor_name" class="form-control"
                                        value="{{ $admission_details->prepare_doctor_name ?? '' }}">

                                    <input type="hidden" id="hdn_pre_doctor_id" name="hdn_pre_doctor_id"
                                        value="{{ $admission_details->prepare_doc_person_no_fk ?? '' }}"
                                        class="form-control">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id"
                                        value="{{ $admission_details->admission_no_pk }}" class="form-control">
                                    {{-- <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                                        value="{{ $admission_details->patient_no_fk }}" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="verified_doctor_name">Verified
                                        Doctor</label>
                                    <input type="text" id="doctor_code4" name="verified_doctor_name" class="form-control"
                                        value="{{ $admission_details->verified_doctor_name ?? '' }}">

                                    <input type="hidden" id="hdn_verify_doctor_id" name="hdn_verify_doctor_id"
                                    value="{{ $discharge_data->verified_doc_person_no_fk ?? '' }}"
                                        class="form-control">
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id"
                                        value="{{ $admission_details->admission_no_pk }}" class="form-control">
                                    {{-- <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                                        value="{{ $admission_info->patient_no_fk }}" class="form-control"> --}}
                                </div>
                            </div>
 

                            {{-- <div class="col-md-4">
                                <h6><strong>Control Type</strong></h6>
                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="was_under_control" name="control_type"
                                        class="custom-control-input" value="1"
                                        {{ $admission_details->control_type_ind == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="was_under_control">Was Under
                                        Control</label>
                                </div>

                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="wasnt_under_control" name="control_type"
                                        class="custom-control-input" value="0"
                                        {{ $admission_details->control_type_ind == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="wasnt_under_control">Wasn't Under
                                        Control</label>
                                </div>
                            </div> --}}

                            {{-- TODO --}}
                            {{-- Diagnosis --}}
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="diagnosis">Diagnosis</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="diagnosis" autocomplete="off" name="diagnosis"
                                        value="{{ isset($admission_details->diagnosis) ? $admission_details->diagnosis : ''}}"
                                        placeholder="Diagnosis">
                                </div>
                            </div> --}}

                            {{-- Status during Discharge --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="status_during_discharge">Condition at the time of discharge</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="status_during_discharge" autocomplete="off" name="status_during_discharge"
                                        value="{{ isset($admission_details->status_during_discharge) ? $admission_details->status_during_discharge : '' }}"
                                        placeholder="Status during Discharge">
                                </div>
                            </div>

                            {{-- Discharge Type --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="discharge_type">Discharge Type</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="discharge_type" autocomplete="off" name="discharge_type"
                                        value="{{ isset($admission_details->discharge_type) ? $admission_details->discharge_type : '' }}"
                                        placeholder="Discharge Type">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="adm_form_allergies">Allergies</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="adm_form_allergies" autocomplete="off" name="adm_form_allergies"
                                        value="{{ isset($admission_details->adm_form_allergies) ? $admission_details->adm_form_allergies : '' }}"
                                        placeholder="Allergies">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="dis_date">Discharge Date</label>
                                    <input type="date" class="form-control form-control-sm m-0" 
                                        id="dis_date" autocomplete="off" name="dis_date"
                                        value="{{ isset($admission_details->dis_date) ? \Carbon\Carbon::parse($admission_details->dis_date)->format('Y-m-d') : '' }}"
                                        min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="diagnosis">Diagnosis</label>
                                    <textarea style="width: 550px!important;" id="diagnosis" name="diagnosis" class="form-control" rows="3">{{ $admission_details->diagnosis }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- for female patient --}}
                @if(isset($admission_info->gender_txt) && $admission_info->gender_txt === 'Female')
                <div class="card">
                    <div class="card-body p-2">
                        <div class="form-row">
                            <!-- Menstrual Cycle -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="cycle">Menstrual Cycle</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="cycle" name="cycle"
                                        value="{{ isset($admission_details->cycle) ? $admission_details->cycle : '' }}"
                                        placeholder="Cycle">
                                </div>
                            </div>
                            <!-- Flow & Duration -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="flow_duration">Flow & Duration</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="flow_duration" name="flow_duration"
                                        value="{{ isset($admission_details->flow_duration) ? $admission_details->flow_duration : '' }}"
                                        placeholder="Flow & Duration">
                                </div>
                            </div>
                            <!-- LMP -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="lmp">LMP</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="lmp" name="lmp"
                                        value="{{ $admission_details->lmp ? \Carbon\Carbon::parse($admission_details->lmp)->format('d-m-Y') : '' }}"
                                        placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                            <!-- EDD -->
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="edd">EDD</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="edd" name="edd"
                                        value="{{ $admission_details->edd ? \Carbon\Carbon::parse($admission_details->edd)->format('d-m-Y') : '' }}"
                                        placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="married_for">Married for</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="married_for" name="married_for"
                                        value="{{ isset($admission_details->married_for) ? $admission_details->married_for : '' }}"
                                        placeholder="Married for">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="gravida">Gravida</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="gravida" name="gravida"
                                        value="{{ $admission_details->gravida ?? '' }}"
                                        placeholder="Gravida">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="para">Para</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="para" name="para"
                                        value="{{ $admission_details->para ?? '' }}"
                                        placeholder="Para">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="obs_hist_alc">ALC</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="alc" name="alc"
                                        value="{{ $admission_details->alc ?? '' }}"
                                        placeholder="ALC">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- <div class="text-center mt-3">
                    <button type="button" class="btn btn-primary btn-md" onclick="getDetailsFromIPDPrescription()">Get
                        Details From IPD Prescription</button>
                </div> --}}
            </div>
            <div class="col-md-4">
                <div class="card discharge_template_list">
                    <div class="card-header">
                        <h5>Discharge Template List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table bg-white mb-0 mt-2">
                            <thead>
                                <!-- <tr>
                                <td></td>
                                    <td class="text-left p-0 border-0" colspan="2">
                                        <input type="text" class="form-control form-control-sm mb-0" id="item_search" name="item_search" value="" placeholder="Search Item Here" style="margin-bottom: 0px;">
                                    </td>
                                </tr> -->
                            </thead>
                            <tbody>
                                @if (!empty($dis_template))
                                    @php
                                        $sl = 1;
                                    @endphp
                                    @foreach ($dis_template as $value)
                                        <tr class=" cursor-pointer" onclick="template(this)"
                                            data-tempId="{{ $value->dis_template_no_pk }}"
                                            data-appId="{{ $admission_info->admission_no_pk }}">
                                            <td width='5px'>{{ $sl++ }}</td>
                                            <td class="text-left">
                                                <span>{{ $value->dis_template_name }}</span>
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

        <div id="summary_data">
            @include('admin.ipd.discharge.discharge_summary_data')
        </div>

        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Template Name</h5>
                    </div>
                    <div class="card-body p-2">
                        <input type="text" class="form-control" id="template_name" name="template_name">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            @php
                $response_action = route('ipd.ipd-discharge-summary', $admission_info->admission_no_pk);
            @endphp
            <div class="card-body p-2 text-right">
                <button type="button" class="btn btn-primary btn-sm"
                    onclick="disBtnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                    value="1"><i class="fa fa-save"></i> Save</button>

                <button type="button" class="btn btn-success btn-sm"
                    onclick="disBtnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"><i
                        class="fa fa-save"></i> Save as
                    Template</button>

                <button type="button" class="btn btn-info btn-sm" title="Click here to Clear form data"
                    onclick="resetDisForm()">Clear</button>
                <a href="#" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard">Exit</a>
            </div>
        </div>
    </form>

</div>



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

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>

  $(document).ready(function(){
      $('.select2').select2();
   });

    function resetDisForm() {
        // $("#frmBilling").find("textarea").not('.keep_me').val("");
        // $("#frmBilling").find("select").not('.keep_me').val("0");
        // $("#net_payable").html("00.00");
        // $("#total_due_con").html("00.00");
        // $("#total_due_data").html("00.00");
        // $("#item_total").html("00.00");
        $("p").html("");
        $("#summary_data").find("textarea, input, select").val("");

        //$("#frmBilling").find("input").val('');
        //$("#frmBilling").find("select").val(0);
        $("tfoot").html('');

        // $("#data-append").find("tr").not('.keep_me').html('');
        // $("#data-append-to").find("tr").not('.keep_me').html('');
    }

    function template(Element) {
        let id = $(Element).attr("data-tempId");
        let app_id = $(Element).attr("data-appId");
        $(".cursor-pointer").removeClass("bg-success");
        $(Element).addClass("bg-success");

        $.ajax({

            data: {
                id: id,
                app_id: app_id
            },
            url: "{{ route('ipd.ipd-discharge-summary-temp') }}",
            type: "post",

            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $("#summary_data").html(data);
                loadEditor("discharge_note");
                loadEditor("pre_ot");
                loadEditor("post_ot");
                loadEditor("advice");
                loadEditor("first_baby_note");
                loadEditor("second_baby_note");
                loadEditor("case_summary_remarks");
                openBillingItemAutocomplete(".item_typehead", "MED,GENERIC", "", selectMedItem);
                openBillingItemAutocomplete(".item_investigation_typehead", item_type = "", item_type_void =
                    "MED,GENERIC",
                    selectInvestigationItem);

                // openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_surgeon', 'hdn_pre_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_assis', 'hdn_pre_ot_assis', 'employee_ind', '1');
                openDoctorAutocomplete('#pre_ot_anaesthetist', 'hdn_pre_ot_anaesthetist', 'doctor_ind',
                    '1');
                openDoctorAutocomplete('#post_ot_anaesthesia', 'hdn_post_ot_anaesthesia', 'doctor_ind',
                    '1');
                openDoctorAutocomplete('#post_ot_surgeon', 'hdn_post_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#post_ot_anaesthetist', 'hdn_post_ot_anaesthetist', 'doctor_ind',
                    '1');
                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });
                $('body').on('focus', ".timepicker", function() {
                    $(this).timepicker({
                        // showInputs: false,
                        // showMeridian: false,
                        // setTime: null

                    });
                });


            },
            complete: function() {
                $.unblockUI();
            },
        })
        event.stopImmediatePropagation();

    }

    $('body').on('focus', ".timepicker", function() {
        $(this).timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });
    });

    function disBtnSaveUpdate(thisElement, customFunc = '', responesUrl = '', modalClass = '', modalTitle = '',
        callback = "", callbackparam = "") {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var seve_temp = $(thisElement).val();
        var template_name = seve_temp ? "" : $('#template_name').val();
        if (seve_temp == "") {
            $('#template_name').attr("required", "required");
        } else {
            $('#template_name').removeAttr("required");
        }
        var route_data = "";
        if (seve_temp) {
            route_data = "{{ route('ipd.store-discharge-summary') }}";
        } else {
            var route_data = "{{ route('ipd.store-discharge-summary-temp') }}";
        }



        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: route_data,
                // url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function() {
                    if (customFunc == "") {
                        if (isAModalOpen)
                            $('.modal').modal('hide');


                    }
                    blockUI();
                },
                success: function(data) {
                    if (customFunc == "") {
                        if (data.title == 'Success') {
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg);
                        } else {
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html(data.title);
                            $('.common-modal-notify-error .modal-body').html(data.msg);
                        }
                    } else {

                        var response_url = responesUrl + "/" + data.insert_id;
                        if (typeof data.sl != 'undefined') {
                            var response_url = responesUrl + "/" + data.insert_id + "/" + data.sl;
                        }
                        dynamicFunc[customFunc](response_url, modalClass, modalTitle);
                    }

                    // $("#" + formID).find("input, textarea").not('.keep_me').val("");
                    // $("#" + formID).find("select").not('.keep_me').val("0");
                    // $('#doctor_info').html('');
                    // $('#doctor_ref1_info').html('');
                    // $('#doctor_ref2_info').html('');


                    // billingEngine.resetBillForm();

                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();

                if (callback != "")
                    callback(callbackparam);
            });
        }

        event.stopImmediatePropagation();

    }
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    openBillingItemAutocomplete(".item_typehead", "MED,GENERIC", "", selectMedItem);
    // openItemAutocompleteDischarge(".item_typehead", "MED,GENERIC", "", selectMedItem);
    openBillingItemAutocomplete(".item_investigation_typehead", item_type = "LAB,RAD", item_type_void = "MED,GENERIC",
        selectInvestigationItem);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1');
    openDoctorAutocomplete('#doctor_code1', 'hdn_ref_doctor_id', 'doctor_ind', '1');
    openDoctorAutocomplete('#doctor_code3', 'hdn_pre_doctor_id', 'doctor_ind', '1');
    openDoctorAutocomplete('#doctor_code4', 'hdn_verify_doctor_id ', 'doctor_ind', '1');

    // openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
    openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
    openDoctorAutocomplete('#pre_ot_surgeon', 'hdn_pre_ot_surgeon', 'doctor_ind', '1');
    openDoctorAutocomplete('#pre_ot_assis', 'hdn_pre_ot_assis', 'employee_ind', '1');
    openDoctorAutocomplete('#pre_ot_anaesthetist', 'hdn_pre_ot_anaesthetist', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_anaesthesia', 'hdn_post_ot_anaesthesia', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_surgeon', 'hdn_post_ot_surgeon', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_anaesthetist', 'hdn_post_ot_anaesthetist', 'doctor_ind', '1');
    openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CHIEFCOM");

    function selectInvestigationItem(item, obj) {
        $('#hdn_investigation_id_1').val(item.item_id);
        $('#hdn_investigation_name_1').val(item.item_name);
        $('#hdn_investigation_type_1').val(item.item_type);

    }


    function selectMedItem(item, obj) {
        $('#hdn_item_id_1').val(item.item_id);
        $('#hdn_item_name_1').val(item.item_name);
        $('#hdn_item_type_1').val(item.item_type);


    }

    function addRow(thisElement) {
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);

        row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
        row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
        row.find('#hdn_item_type_' + oldId).attr('id', 'hdn_item_type_' + newId);
        var item_id = $('#hdn_item_id_' + oldId).val();


        row.find('#hdn_report_serial_med_' + oldId).attr('id', 'hdn_report_serial_med_' + newId);
        row.find('#hdn_medicine_item_id_' + oldId).attr('id', 'hdn_medicine_item_id_' + newId);
        row.find('#medicine_item_' + oldId).attr('id', 'medicine_item_' + newId);
        // for route
        row.find('#medicine_route_' + oldId).attr('id', 'medicine_route_' + newId);

        row.find('#medicine_dose_' + oldId).attr('id', 'medicine_dose_' + newId);
        row.find('#medicine_duration_mu_' + oldId).attr('id', 'medicine_duration_mu_' + newId);
        row.find('#medicine_duration_type_' + oldId).attr('id', 'medicine_duration_type_' + newId);
        row.find('#medicine_quantity_' + oldId).attr('id', 'medicine_quantity_' + newId);
        row.find('#instruction_' + oldId).attr('id', 'instruction_' + newId);
        row.find('#is_continue_' + oldId).attr('id', 'is_continue_' + newId);
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        row.find('#is_continue_' + newId).attr('name', 'is_continue_' + item_id);

        row.find('#hdn_report_serial_med_' + newId).val($(thisElement).parents('tbody').find('#hdn_report_serial_med_' +
            oldId).val());
        //for route
        row.find('#medicine_route_' + newId).val($(thisElement).parents('tbody').find('#medicine_route_' + oldId).val());
        row.find('#medicine_dose_' + newId).val($(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val());
        row.find('#instruction_' + newId).val($(thisElement).parents('tbody').find('#instruction_' + oldId).val());
        row.find('#medicine_duration_mu_' + newId).val($(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val());

        $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_item_type_' + oldId).val('');



        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_route_' + oldId).val('0');
        // $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
        $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#is_continue_' + oldId).prop('checked', false);

        console.log(newId);


        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function addRowForInvestigation(thisElement) {
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);



        row.find('#hdn_investigation_id_' + oldId).attr('id', 'hdn_investigation_id_' + newId);
        row.find('#hdn_investigation_name_' + oldId).attr('id', 'hdn_investigation_name_' + newId);
        row.find('#hdn_investigation_type_' + oldId).attr('id', 'hdn_investigation_type_' + newId);
        row.find('#investigation_' + oldId).attr('id', 'investigation_' + newId);
        row.find('#investigation_findings_' + oldId).attr('id', 'investigation_findings_' + newId);
        row.find('#investigation_note_' + oldId).attr('id', 'investigation_note_' + newId);
        row.find('#med_fin_td_action_' + oldId).attr('id', 'med_fin_td_action_' + newId);



        $(thisElement).parents('tbody').find('#hdn_investigation_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_investigation_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_investigation_type_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_findings_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_note_' + oldId).val('');

        console.log(newId);


        $(thisElement).parents("#data-append").append(row);

        $('#med_fin_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function getDetailsFromIPDPrescription() {
        var admissionId  = $("#hdn_admission_id").val();
        $.ajax({
            data: {
                admissionId: admissionId
            },
            url: "{{ route('ipd.ipd-previous-details') }}",
            type: "post",

            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $("#summary_data").html(data);
                loadEditor("discharge_note");
                loadEditor("pre_ot");
                loadEditor("post_ot");
                loadEditor("advice");
                loadEditor("first_baby_note");
                loadEditor("second_baby_note");
                loadEditor("case_summary_remarks");
                openBillingItemAutocomplete(".item_typehead", "MED,GENERIC", "", selectMedItem);
                openBillingItemAutocomplete(".item_investigation_typehead", item_type = "", item_type_void =
                    "MED,GENERIC",
                    selectInvestigationItem);

                // openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_surgeon', 'hdn_pre_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_assis', 'hdn_pre_ot_assis', 'employee_ind', '1');
                openDoctorAutocomplete('#pre_ot_anaesthetist', 'hdn_pre_ot_anaesthetist', 'doctor_ind',
                    '1');
                openDoctorAutocomplete('#post_ot_anaesthesia', 'hdn_post_ot_anaesthesia', 'doctor_ind',
                    '1');
                openDoctorAutocomplete('#post_ot_surgeon', 'hdn_post_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#post_ot_anaesthetist', 'hdn_post_ot_anaesthetist', 'doctor_ind',
                    '1');
                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });
                $('body').on('focus', ".timepicker", function() {
                    $(this).timepicker({
                        // showInputs: false,
                        // showMeridian: false,
                        // setTime: null

                    });
                });


            },
            complete: function() {
                $.unblockUI();
            },
        })
        event.stopImmediatePropagation();
    }



    loadEditor("discharge_note");
    loadEditor("pre_ot");
    loadEditor("post_ot");
    loadEditor("advice");
    loadEditor("first_baby_note");
    loadEditor("second_baby_note");
    loadEditor("case_summary_remarks");

</script>
