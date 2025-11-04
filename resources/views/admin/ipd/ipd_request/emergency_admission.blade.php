@php
    $ipd_admission = isset($ipd) && !empty($ipd) ? $ipd : [];
    $admission_no_pk = $ipd_admission ? $ipd_admission->admission_no_pk : '';
    $admission_uid = $ipd_admission ? $ipd_admission->admission_uid : '';
    $admission_date = $ipd_admission ? $ipd_admission->admission_date : '';
    $primary_doctor_no_fk = $ipd_admission ? $ipd_admission->primary_doctor_no_fk : '';
    $duty_doc_person_no_fk = $ipd_admission ? $ipd_admission->duty_doc_person_no_fk : '';
    $initial_bed_no_fk = $ipd_admission ? $ipd_admission->initial_bed_no_fk : '';
    $curr_bed_no_fk = $ipd_admission ? $ipd_admission->curr_bed_no_fk : '';
    $old_bed_no_fk = $ipd_admission ? $ipd_admission->old_bed_no_fk : '';
    $curr_ward_no_fk = $ipd_admission ? $ipd_admission->curr_ward_no_fk : '';
    $reg_type_no_fk = $ipd_admission ? $ipd_admission->reg_type_no_fk : '';
    $su_no_fk = $ipd_admission ? $ipd_admission->su_no_fk : '';
    $prescription_no_fk = $ipd_admission ? $ipd_admission->prescription_no_fk : '';
    $prescription_uid = $ipd_admission ? $ipd_admission->prescription_uid : '';
    $appointment_no_fk = $ipd_admission ? $ipd_admission->appointment_no_fk : '';
    $opd_department_su_no_fk = $ipd_admission ? $ipd_admission->opd_department_su_no_fk : '';
    $opd_department_name = $ipd_admission ? $ipd_admission->opd_department_name : '';
    $status = $ipd_admission ? $ipd_admission->status : '';
    $covid_vaccinated_ind = $ipd_admission ? $ipd_admission->covid_vaccinated_ind : '';
    $first_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->first_ref_doc_person_no_fk : '';
    $second_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->second_ref_doc_person_no_fk : '';
    $ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->ref_doc_person_no_fk : '';
    $patient_no_fk = $ipd_admission ? $ipd_admission->patient_no_fk : '';
    $doctor_name = isset($ipd_admission) && isset($ipd_admission->full_name) ? $ipd_admission->full_name : '';

    $admitted_dept = $ipd_admission ? $ipd_admission->admitted_dept : '';
    $ref_from_emr_ind = $ipd_admission ? $ipd_admission->ref_from_emr_ind : '';
    $ref_from_opd_dept = $ipd_admission ? $ipd_admission->ref_from_opd_dept : '';
    $ref_from_external = $ipd_admission ? $ipd_admission->ref_from_external : '';
    $pkg_patient_ind = $ipd_admission ? $ipd_admission->pkg_patient_ind : '';
    $pkg_item_no_fk = $ipd_admission ? $ipd_admission->pkg_item_no_fk : '';
    $item_name = $ipd_admission ? $ipd_admission->item_name : '';

    $IpdAdmissionDetails = isset($IpdAdmissionDetails) && !empty($IpdAdmissionDetails) ? $IpdAdmissionDetails : [];

    $pat_condition = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_condition : '';
    $arrival_mode = $IpdAdmissionDetails ? $IpdAdmissionDetails->arrival_mode : '';
    $accompanied_by = $IpdAdmissionDetails ? $IpdAdmissionDetails->accompanied_by : '';
    $cause_of_admission = $IpdAdmissionDetails ? $IpdAdmissionDetails->cause_of_admission : '';
    $contact_person = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person : '';
    $contact_person_mobile = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person_mobile : '';
    $contact_relaion = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_relaion : '';
    $ward_no_fk = $IpdAdmissionDetails ? $IpdAdmissionDetails->ward_no_fk : '';
    $remarks = $IpdAdmissionDetails ? $IpdAdmissionDetails->remarks : '';
    $pat_valuable_accessories = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_valuable_accessories : '';

    $father_name = $IpdAdmissionDetails ? $IpdAdmissionDetails->father_name : '';
    $mother_name = $IpdAdmissionDetails ? $IpdAdmissionDetails->mother_name : '';
    $address = $IpdAdmissionDetails ? $IpdAdmissionDetails->address : '';
    $external_hospital = $IpdAdmissionDetails ? $IpdAdmissionDetails->external_hospital : '';
    $co = $IpdAdmissionDetails ? $IpdAdmissionDetails->accompanied_by : '';

    $admission_data = isset($admission_data) && !empty($admission_data) ? $admission_data : [];
    $primary_doctor_name = $admission_data ? $admission_data->primary_doctor_name : '';
    $refrral_doctor_name = $admission_data ? $admission_data->refrral_doctor_name : '';
    $first_ref_doctor_name = $admission_data ? $admission_data->first_ref_doctor_name : '';
    $second_ref_doctor_name = $admission_data ? $admission_data->second_ref_doctor_name : '';
    $patient_name = $admission_data ? $admission_data->patient_name : '';
    $su_no_fk = $admission_data ? $admission_data->new_su_no_fk : '';
    // dd( $su_no_fk);
@endphp
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_ipd_admission">
    <div class="container-fluid">
      
        @if ($admission_no_pk == '')
            <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
                <div class="col-md-6">
                    <h5 class="mt-2 mb-0">Emergency Admission</h5>
                    <small>Emergency / Emergency Admission</small>
                </div>
                <div class="col-md-6 text-right">
                    <div id="top-action" class="mt-2">
                        <a class="btn btn-outline-primary btn-md" rel="tab"
                            href="{{ route('ipd.emergency-admission-list') }}"><i class="fa fa-hospital"></i> Admitted Patient
                            List</a>
                    </div>
                </div>
            </div>
        @endif

        <form id="quick_admission_form" action="{{ route('ipd.store-emergency-admission') }}" method="post">
            <input type="hidden" value="{{ $admission_no_pk }}" id="admission_no_pk" name="admission_no_pk">
            <input type="hidden" value="{{ $curr_bed_no_fk }}" name="">
            <input type="hidden" id='bed_id' name="bed_id" value="{{ $curr_bed_no_fk }}">
            <input type="hidden" id='ward_id' name="ward_id" value="">
            <input type="hidden" id='su_id' name="su_id" value="">
            <input type="hidden" id='' class="keep_me" name="initial_bed_no_fk" value="{{ $curr_bed_no_fk }}">
            <div class="form-row">
                <div class="col-md-7">
                    <div class="card ml-2">
                        <div class="card-header">
                            <h5>Emergency Admission Form</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="form-group form-row border-bottom">
                                <div class="col-md-8 d-none">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input " onchange="bedViewer.patientType(this)"
                                            type="radio" name="patient_type" id="patient_type1" value="1"
                                            checked />
                                        <label class="form-check-label" for="patient_type1">Registered</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="registered_patient">
                                        <div class="form-group">
                                         
                                            <input type="hidden" class="ref_ind" id="ref_from_opd_dept"
                                                name="ref_from_opd_dept"  value="{{$admission_no_pk ==''? (isset($ref_ind) ? $ref_ind :'') : '' }}" />

                                            <input type="hidden" class="hdn_patient_id" id="hdn_patient_id"
                                                name="hdn_patient_id"  value="{{$admission_no_pk ==''? (isset($patient_id) ? $patient_id :'') : $patient_no_fk }}" />

                                            <input type="hidden" class="" id="hdn_patient_id2"
                                                name=""  value="{{$admission_no_pk ==''? (isset($patient_id) ? $patient_id :'') : $patient_no_fk }}" />
                                            <input type="text" class="form-control form-control-sm m-0 mb-0"
                                                id="service_number" name="service_number" value="{{ $admission_no_pk ==''? (isset($patientName)? $patientName :'')  : $patient_name }}"
                                                placeholder="Search Patient" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="form-row">
                                <div class="registered_patient col-md-12">
                                    <div class="mt-2 pat_data patient_details d-none" id="patient_details">
                                        @include('admin.components.patient_info_min')
                                    </div>
                                </div>
                            </div>
                          
                            {{-- ******************** Non Register ********************************************** --}}
                            <div class="non_registered_patient d-none mb-3 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fa fa-user"></i>&nbsp; Patient Quick Registration
                                        </h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        @include('admin.patient.patient_quick_registration_form')
                                    </div>
                                </div>
                            </div>
                            {{-- *********** non register form end ************** --}}

                            <div class="form-row mt-2">
                                @if(Session::get('user.ses_hospital_code')!="UNICO")
                                    <div class="col-md-4">
                                        <label class="col-form-label col-form-label-sm"
                                            for="admission_department">Department</label>

                                        <select class="form-control form-control-sm select2" name="admission_department">
                                            <option value="">Select Department</option>
                                            @if (!empty($requestDepts))
                                                @foreach ($requestDepts as $rd)
                                                    <option value="{{ $rd->serviceunit_no_pk }}"
                                                        {{ $rd->serviceunit_no_pk == $admitted_dept ? 'selected' : '' }}>
                                                        {{ $rd->serviceunit_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="request_department">@if(Session::get('user.ses_hospital_code')=="UNICO") Nurse Station @else Service Unit @endif<span class="text-danger">*</span></label>
                                    {{-- onchange="bedViewer.getWard(this)" --}}
                                    <select class="form-control form-control-sm select2" id="request_department" name="request_department" >
                                        
                                        @if(!empty($requestDepts))
                                            @foreach($requestDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}" >
                                                    {{ $rd->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="request_department_id" value="{{ $requestDepts[0]->serviceunit_no_pk ?? '' }}">
                                </div>
                                <div class="col-md-4" id="ward_container">
                                    @include('admin.ipd.ipd_request.emergency_bed_new')
                                </div>
                                 
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="primary_doctor">Admitting Consultant  <span class="text-danger">*</span></label>
                                    {{-- <span class="badge badge-primary cursor-pointer open-modal"
                                        data-modal="common-modal-sm" data-id="1"
                                        data-action="{{ route('doctor.createquickregistration', 1) }}"
                                        data-title="Add new Doctor (Referral)">
                                        +</span> --}}
                                    <input type="hidden" id="hdn_doctor_id" name="doctor_id"
                                        value="{{ $primary_doctor_no_fk ==""? (isset($doctor_no) ? $doctor_no :''): $primary_doctor_no_fk }}" />
                                    
                                    <input type="text" class="form-control form-control-sm m-0" id="doctor_code"
                                        name="primary_doctor" value="{{ $primary_doctor_name =="" ? (isset($request_doctor_name) ? $request_doctor_name :'') :$primary_doctor_name }}"
                                        placeholder="Search doctor" required />
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm"
                                        for="accompanied_Guardian by">Gurdian</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="accompanied_Guardian" name="accompanied_by" placeholder="Ex: Bellal Hossain"
                                        value="{{ $co }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="relation">Relation</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="relation"
                                        name="relation" placeholder="Father/Mother/Sister/Brother..."
                                        value="{{ $contact_relaion }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="phone_number by">Phone
                                        Number</label>
                                    <input type="text" class="form-control form-control-sm m-0 number_only"
                                        id="contact_number" name="contact_number" minlength="10" maxlength="15"
                                        placeholder="Ex:017********" value="{{ $contact_person_mobile }}" />
                                </div>
                                {{-- New Requirement From Marina APU(ED)  --}}
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="father_name by">Father's
                                        Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="father_name"
                                        name="father_name" placeholder=""
                                        value="{{ $father_name }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="mother_name by">Mother's
                                        Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="mother_name"
                                        name="mother_name" placeholder=""
                                        value="{{ $mother_name }}" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="address by">Address</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="address"
                                        name="address" placeholder="" value="{{ $address }}" />
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label col-form-label-sm"
                                        for="admission_remarks">Admitting Note</label>
                                    {{-- <input type="text" class="form-control form-control-sm m-0"
                                        id="admission_remarks" name="admission_remarks" value="{{ $remarks }}"
                                        placeholder="Remarks Here" /> --}}
                                        <textarea name="admission_remarks" id="admission_remarks" cols="30" rows="5" class="form-control form-control-sm m-0">{{ $remarks !="" ? ($remarks) :(isset($requestNote) ? $requestNote :'') }}</textarea>
                                </div>
                               
                                <input type="hidden" value="{{ Session::get('user.ses_hospital_code') }}"
                                    id="hospital_code">

                            </div>
                            @php $response_action = route('ipd.ipd-admission'); @endphp

                            <div class="mt-2 modal-inline">

                                <button type="button" class="btn btn-md btn-success" onclick="saveIpd(this)">
                                    Save
                                </button>
                                {{-- <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data"> --}}
                                {{-- Clear --}}
                                {{-- </button> --}}
                                {{-- <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal"> --}}
                                {{-- Exit --}}
                                {{-- </button> --}}
                                <button type="reset" class="btn btn-md btn-info">Reset</button>
                                <a href="{{ route('ipd.ipd-admission') }}" class="btn btn-danger btn-md"
                                    rel="tab" title="Click here to go back to Dashboard">Exit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="Bed_data">
                        <div class="card">
                            <div class="card-header">
                                <strong>Bed Viewer</strong>
                            </div>
                            <div class="card-body" id="Bed_data">
                                @include('admin.ipd.ipd_request.ipd_bed_viewer_v2')
                            </div>
                        </div>
                        <div class="mt-2 bed_data d-none" id="bedAndPatientData">
                            @include('admin.ipd.ipd_request.bed_data_view_v2')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    openItemAutocomplete($("#package_item_no"),
        'GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT', "#package_item_id");
    // $(document).on("change", ".patient_type	", function(e) {
    //     var value = $(this).val();
    //     if (value == 1) {

    //         $('.pat_info').val("");
    //         $("#pat_gender").val("");
    //         $("#pat_blood_group").val(0);
    //         $("#pat_marital_status").val(0);

    //     } else {
    //         $('#service_number').val("");
    //         $('#hdn_patient_id').val("");
    //     }
    // });

    function saveIpd(thisElement) {
        if ($('#destination_ward').val() == "") {
            alert("Please Select Ward");
            return;
        }

        if ($('#hospital_code').val() == "AMCSH") {
            if ($('#cause_of_admission').val() == "") {
                alert("Please Add Cause Of Admission");
                return;
            }
        }
        if ($('#bed_id').val() != "") {
            var url = '{{ route('ipd.ipd-admission') }}'
            btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, url);
        } else {
            alert("Please Select Bed");
            return;
        }
    }
    $(function(){ 
        let patientId = $('#hdn_patient_id2').val();
        let admissionNo = $('#admission_no_pk').val();
        
        if (patientId !== '' && admissionNo === '') {
            bedViewer.selectPatient({ patient_id: patientId }, {});
        }        
    })

   

   
  

    $('.select2').select2();
    var bedViewer = {
        patientType: function(thisElement) {
            var checkValue = $('input[name=patient_type]:checked').val();
            if (checkValue == "2") {
                $('.non_registered_patient').removeClass("d-none");
                $('.registered_patient').addClass("d-none");
                $("#patient_details").addClass('d-none');
                $('#service_number').val("");
                $('#hdn_patient_id').val("");
            } else {
                $('.registered_patient').removeClass("d-none");
                $('.non_registered_patient').addClass("d-none");
                $('.pat_info').val("");
                $("#pat_gender").val(0);
                $("#pat_blood_group").val(0);
                $("#pat_marital_status").val(0);
            }
        },
        selectPatient: function(item, obj) {
           
            $("#patient_details").removeClass('d-none');
            var patient_id = item.patient_id;
            $.ajax({
                url: "{{ route('patient-info-json') }}",
                type: 'post',
                data: {
                    patient_id: patient_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    
                    var corporate_name=data.ccm_client_name !=null ? ' ( '+ data.ccm_client_name + ' ) ' :'';
                    var pt_category=`${data.patient_type_code} ${corporate_name} `
                    console.log(data,pt_category);
                    $("#patient_name").html(data.patient_name);
                    $("#patient_code").html(data.patient_code);
                    $("#patient_age").html(data.pat_age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group_txt);
                    $("#patient_ms").html(data.marital_status_txt);
                    $("#phone_number").html(data.contact);
                    $("#hdn_patient_id").val(data.patient_id);
                    $("#accompanied_Guardian").val(data.emergency_contact_name);
                    $("#relation").val(data.emergency_contact_relation);
                    $("#contact_number").val(data.emergency_contact_contact);
                    $("#father_name").val(data.father_name);
                    $("#mother_name").val(data.mother_name);
                    $("#address").val(data.permanent_addr);
                    $("#patient_category").html(pt_category);
                    
                    var publicPath = "{{ asset('') }}";
                    $("#pt_photo").attr('src', publicPath+'images/uploads/patient_images/thumb/' + data.patient_photo);
                    console.log(publicPath)
                    // $("#pt_photo").attr('src',data.patient_photo);
                    
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedByWard: function(thisElement) {
            var bed_value = $(thisElement).val();
            var bed_data = $(thisElement).val();
            var su_no = $(thisElement).find(':selected').data("su_no");
            // alert(su_no)

            $.ajax({
                url: "{{ route('ipd.get-bed-by-ward') }}",
                type: 'POST',
                data: {
                    bed_value: bed_value,
                    bed_data: bed_data
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#bed_container").html(data);
                    $("#request_department").val(su_no).trigger('change');

                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        filterBed: function(thisElement) {
            var bed_status = $(thisElement).attr("value");
            var ward_id = $("#destination_ward").val();

            //for bed data
            if (bed_status == 1) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 2) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 3) {
                $('#bedAndPatientData').addClass('d-none');
            }
            // alert(bed_value)
            $.ajax({
                url: "{{ route('get_bed_data') }}",
                type: 'GET',
                data: {
                    bed_status: bed_status,
                    ward_id: ward_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedDetails: function(thisElement) {

            var bed_id = $(thisElement).attr("id");
            var ward_id = $(thisElement).attr("data-ward");
            var su_id = $(thisElement).attr("data-su");
            var bed_status = $(thisElement).attr('data-status');
            if (bed_status == 1) {
                $('#bedAndPatientData').removeClass('d-none');
            } else if (bed_status == 2) {
                alert('This Bed Is Unavailable');
                return;
                // $('#bedAndPatientData').removeClass('d-none');
            } else if (bed_status == 3) {
                alert('This Bed Is Not Ready');
                return;
                // $('#bedAndPatientData').removeClass('d-none');
            }

            $("#bed_id").val(bed_id);
            $("#ward_id").val(ward_id);
            $("#su_id").val(su_id);
            $.ajax({
                url: "{{ route('ipd.get-patient-bed-info') }}",
                type: 'GET',
                data: {
                    bed_id: bed_id,
                    bed_status: bed_status
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    // $('#request_department').val("");
                    $('#request_department').select2({
                        id: '',
                        a_key: 'select department'
                    });

                    $("#bedAndPatientData").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getIdforStore: function(thisElement) {
            var bed_id = $('#bed_id').attr("id");
            $.ajax({
                url: "{{ route('ipd.store-quick-admission') }}",
                type: 'POST',
                data: {
                    bed_id: bed_id
                },
                beforeSend: function() {
                    blockUI();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getWard: function(thisElement) {
            var ward_data = $('#request_department').val();
            //alert(ward_data)
            $.ajax({
                url: "{{ route('ipd.get-ward') }}",
                type: 'POST',
                data: {
                    ward_data: ward_data
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ward_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
    };
    openPatientAutocomplete('#service_number', 'patient_name', bedViewer.selectPatient);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#referral_doctor', 'ref_doc');
    openDoctorAutocomplete('#first_referral', 'first_ref');
    openDoctorAutocomplete('#second_referral', 'second_ref');
    openPatientAreaInfoAutocomplete('#search_data');
</script>
