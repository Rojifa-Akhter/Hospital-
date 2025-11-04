<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form id="frmCreateAppointment" method="POST" action="{{ route('pabxAppointment.store') }}">
    <div class="form-row">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="card-body p-2">
                <div>
                    <div class="form-group form-row border-bottom">
                        <label class="col-md-3 col-form-label col-form-label-sm patient_id" for="patient_id"></label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input patient_type" type="radio" name="patient_type"
                                    id="patient_type1" value="1" checked>
                                <label class="form-check-label" for="patient_type1">Registered</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input patient_type" type="radio" name="patient_type"
                                    id="patient_type2" value="2">
                                <label class="form-check-label" for="patient_type2">Non-Registered</label>
                            </div>
                        </div>
                    </div>
                    <div class="registered_patient mt-2">
                        <div class="form-group border-bottom form-row">
                            <label class="col-sm-3 col-form-label col-form-label-sm patient_id"
                                for="patient_code">Patient ID <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm patient_id" id="patient_code"
                                    name="patient_code" placeholder="Search Patient by Patient Code, Name and Phone Number"
                                    required="required" />
                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="non_registered_patient d-none mt-2">
                        <div class="form-group row">
                            <label for="patient_name" class="col-sm-3 col-form-label col-form-label-sm">Patient Name
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="form-control font_size_12 m-auto" id="patient_salutation"
                                            name="patient_salutation">
                                            <option value="">Select </option>
                                            @if (isset($name_prefix))
                                                @foreach ($name_prefix as $key => $value)
                                                    <option value="{{ $value }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_first_name" name="patient_first_name" value=""
                                        placeholder="First Name" maxlength="50" required>
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_last_name" name="patient_last_name" value=""
                                        placeholder="Last Name" maxlength="50">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Common Fields --}}
                    <div class="form-group form-row">
                        <label for="appoint_date" class="col-sm-3 col-form-label col-form-label-sm">Appointment Date <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" 
                                placeholder="Enter Appointment Date" name="appoint_date" id="appoint_date" autocomplete="off" required />
                        </div>
                        
                        <label for="doctor_no_fk" class="col-sm-1 col-form-label col-form-label-sm">Doctor <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control font_size_12 m-auto select2" id="doctor_no_fk" name="doctor_no_fk" required>
                                <option value="">Select Doctor</option>
                                @if (isset($doctor_info))
                                    @foreach ($doctor_info as $key => $value)
                                        <option value="{{ $value->person_no_pk }}">{{ $value->full_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label for="sex" class="col-sm-3 col-form-label col-form-label-sm">Sex <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control font_size_12 m-auto " id="sex" name="sex" required>
                                <option value="">Select Patient Sex</option>
                                @if (isset($gender))
                                    @foreach ($gender as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label for="mobile_no" class="col-sm-1 col-form-label col-form-label-sm">Mobile <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm number_only pat_info"
                                id="mobile_no" name="mobile_no" value="" placeholder="Enter Mobile Number"
                                maxlength="14" required />
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label for="dob" class="col-sm-3 col-form-label col-form-label-sm">Date of Birth
                            <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" 
                                placeholder="Date of Birth" name="dob" id="dob" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group row border-bottom"></div>
                    </div>

                    <div class="form-group form-row">
                        <div class="col-md-7" id="sales_price"></div>
                        <div class="col-md-5 text-red text-center" id="appoint_date"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-1 col-lg-12">
            @php
                $response_action = route('pabxAppointment.index');;
            @endphp
            <button type="button" class="btn btn-md btn-success float-left"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>

            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    $(document).on("change", ".patient_type	", function(e) {
        var value = $(this).val();
        if (value == 1) {
            $('.pat_info').val("");
            $("#patient_gender").val("");
            $("#patient_blood_group").val(0);
            $("#patient_marital_status").val(0);
        } else {
            $('#patient_code').val("");
            $('#hdn_patient_id').val("");
        }
    });
</script>

<script type="text/javascript">
    $('#dob').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });

    $('#appoint_date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });
</script>
