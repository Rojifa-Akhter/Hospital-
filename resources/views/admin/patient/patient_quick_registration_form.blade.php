@php
    $hospital = DB::table('wsec_hospital')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="form-group row">
    <label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">Patient Name <span
            class="text-danger">*</span></label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="input-group-prepend">
                <select class="form-control font_size_12 m-auto" id="pat_salutation" name="pat_salutation">
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
            <input type="text" class="form-control form-control-sm pat_info" id="pat_f_name" name="pat_f_name"
                value="" placeholder="First Name" required>
            <input type="text" class="form-control form-control-sm pat_info" id="pat_l_name" name="pat_l_name"
                value="" placeholder="Last Name">
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="mobile_no" class="col-sm-2 col-form-label col-form-label-sm pat_info">Phone <span
            class="text-danger">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm number_only pat_info" id="mobile_no" name="phone_no"
            value="" minlength="10" maxlength="15" placeholder="Enter Phone Number" required>
    </div>
    <label for="pat_gender" class="col-sm-2 col-form-label col-form-label-sm">Sex <span
            class="text-danger">*</span></label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto " id="pat_gender" name="pat_gender" required>
            <option value="">Select Gender</option>
            @if (isset($gender))
                @foreach ($gender as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="patient_age_dd" class="col-sm-2 col-form-label col-form-label-sm">Age <span
            class="text-danger">*</span></label>
    <div class="col-sm-4">
        <div class="input-group">
            <div class="input-group-prepend w-100">
                <input type="number" class="form-control form-control-sm pat_info" id="pat_age_y" name="pat_age_y"
                    value="" placeholder="YY" style="width: 35%;" required>
                <input type="number" class="form-control form-control-sm pat_info" id="pat_age_m" name="pat_age_m"
                    value="" placeholder="MM" style="width: 33%;" max="12">
                <input type="number" class="form-control form-control-sm pat_info" id="pat_age_d" name="pat_age_d"
                    value="" placeholder="DD" style="width: 32%;" max="31">
            </div>
        </div>
    </div>
    <label for="pat_dob" class="col-sm-2 col-form-label col-form-label-sm ">DOB</label>
    <div class="col-sm-4">
        @if ($hospital->hospital_code == 'EWMCH' )
            <input type="text" class="form-control form-control-sm date_picker pat_info" id="patient_dob"
                name="pat_dob" value="" autocomplete="off" placeholder="mm/dd/yyyy">
            {{-- <div id="label_dob"></div> --}}
        @elseif ($hospital->hospital_code == 'AMCSH')
            <input type="text" class="form-control form-control-sm date_picker pat_info" id="patient_dob"
                name="pat_dob" value="" autocomplete="off" placeholder="mm/dd/yyyy">
        @elseif ($hospital->hospital_code == 'DIGILAB')
            <input type="text" class="form-control form-control-sm date_picker pat_info" id="patient_dob"
                name="pat_dob" value="" autocomplete="off" placeholder="mm/dd/yyyy">
        @else
            <input type="hidden" class="form-control form-control-sm date_picker pat_info" id="patient_dob"
                name="pat_dob" value="" autocomplete="off" placeholder="mm/dd/yyyy">
            <div id="label_dob"></div>
        @endif
        {{-- <input type="hidden" class="form-control form-control-sm date_picker pat_info" id="patient_dob" name="pat_dob"
            value="" autocomplete="off" placeholder="mm/dd/yyyy">
        <div id="label_dob"></div> --}}
        {{-- onclick="dob(event,this)" --}}
    </div>
    <label for="pat_marital_status" class="col-sm-2 col-form-label col-form-label-sm" title="Marital Status">Marital Status</label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="pat_marital_status" name="pat_marital_status">
            <option value="0">Select Marital Status</option>
            @if (isset($marital_status))
                @foreach ($marital_status as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            @endif

        </select>
    </div>
    <label for="pat_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group</label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="pat_blood_group" name="pat_blood_group">
            <option value="0">Select Blood Group</option>
            @if (isset($bloodg))
                @foreach ($bloodg as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            @endif
        </select>
    </div>


    @if ($hospital->hospital_code == 'EWMCH')
        <label for="pat_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Religion </label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto" id="pat_religion" name="pat_religion">
                <option value="">Select Religion</option>
                @if (isset($religion))
                    @foreach ($religion as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @else
        <label for="pat_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Religion <span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto" id="pat_religion" name="pat_religion" required>
                <option value="">Select Religion</option>
                @if (isset($religion))
                    @foreach ($religion as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @endif
    {{-- </div>

<div class="form-group row"> --}}
    <label for="pat_email" class="col-sm-2 col-form-label col-form-label-sm ">Email</label>
    <div class="col-sm-4">
        <input type="email" class="form-control form-control-sm pat_info" maxlength="50" id="pat_email"
            name="pat_email" value="" placeholder="Enter Patient Emal ID">
    </div>


    @if (Session::get('user.ses_hospital_code') == 'EWMCH')
        <label for="pat_address" class="col-sm-2 col-form-label col-form-label-sm ">Address <span
                class="text-danger">*</span></label>
    @else
        <label for="pat_address" class="col-sm-2 col-form-label col-form-label-sm ">Address</label>
    @endif


    <div class="col-sm-4">
        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
            <input type="text" class="form-control form-control-sm pat_info" id="pat_address" maxlength="100"
                name="pat_address" value="" placeholder="Enter Patient Address" required>
        @else
            <input type="text" class="form-control form-control-sm pat_info" id="pat_address" maxlength="100"
                name="pat_address" value="" placeholder="Enter Patient Address">
        @endif

    </div>



    <label for="inform" class="col-sm-2 col-form-label col-form-label-sm">Where You Heard About Us ? </label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="inform" name="inform">
            {{-- <option value="">Select Where You Heard About Us ?</option> --}}
            @if (isset($inform))
                @foreach ($inform as $key => $value)
                    <option value="{{ $value }}" @if ($value == 'Self') selected @endif>
                        {{ $value }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="passport_no" class="col-sm-2 col-form-label col-form-label-sm ">Passport No</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info" maxlength="50" id="passport_no"
            name="passport_no" value="" placeholder="Enter Passport No">
    </div>

    @if ($hospital->hospital_code == 'GMC' || $hospital->hospital_code == 'EWMCH')
        <label for="passport_no" class="col-sm-2 col-form-label col-form-label-sm ">Patient Area <span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm pat_info" id="search_data" name="patient_area"
                value="" placeholder="Enter Patient Area" maxlength="100 " required>
            <input type="hidden" id="hdn_area_code" name="hdn_area_code">
            <input type="hidden" id="hdn_area_name" name="hdn_area_name">
        </div>
    @endif


    {{-- <div id="agent_id" style="display: none";"> --}}
    <label for="agent_id" class="col-sm-2 col-form-label col-form-label-sm agent_id" style="display: none;">Agent
        ID</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info agent_id" maxlength="50" id="agent_id"
            name="agent" value="" placeholder="Enter Agent ID" style="display: none;">
        <input type="hidden" name="agent_id_hdn" id="agent_id_hdn">
    </div>

    <label for="staff__id" class="col-sm-2 col-form-label col-form-label-sm staff__id" style="display: none;">Staff
        ID</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info staff__id" maxlength="50" id="staff__id"
            name="agent" value="" placeholder="Enter Staff ID" style="display: none;">
        <input type="hidden" name="hdn_staff__id" id="hdn_staff__id">
    </div>

    <label for="campaign" class="col-sm-2 col-form-label col-form-label-sm campaign" style="display: none;">Campaign
        Name</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info campaign" maxlength="50" id="campaign"
            name="campaign" value="" placeholder="Enter Campaign Name" style="display: none;">
    </div>

    <label for="others" class="col-sm-2 col-form-label col-form-label-sm others" style="display: none;">Others
        Name</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info others" maxlength="50" id="others"
            name="others" value="" placeholder="Enter Others Info" style="display: none;">
    </div>
    {{-- </div> --}}

</div>

<div class="form-group row">
    <label for="patienttype" class="col-sm-2 col-form-label col-form-label-sm ">Patient Category</label>
    <!--   <input type="text" class="form-control form-control-sm text-capitalize" id="patient_nationality" name="pat_nationality" value="" placeholder="Enter Patient Nationality" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"> -->

    <div class="col-sm-4">
        <select class="form-control form-control-sm text-capitalize" id="patienttype" name="patienttype"
            value="" onchange="corporate(this)">
            @if (!empty($patient_type))
                @foreach ($patient_type as $data)
                    <option data-type_code="{{ $data->patient_type_code }}" value="{{ $data->patient_type_no_pk }}"
                        {{-- {{ $data->patient_type_no_pk == $patient_type_data ? 'selected' : '' }} --}}>
                        {{ $data->patient_type_code }}
                    </option>
                @endforeach
            @endif

        </select>
    </div>



    <label for="patient_nid" class="col-sm-2 col-form-label col-form-label-sm ">NID</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm pat_info" id="patient_nid" name="pat_nid"
            value="" placeholder="Enter Patient NID" onkeypress="return /^[0-9]+$/.test(event.key)"
            maxlength="17">
    </div>

    <label for="corporate_name" class="col-sm-2 col-form-label col-form-label-sm d-none corporate_name">Corporate
        <span class="text-danger">*</span></label>
    <div class="col-sm-4 d-none corporate_name">
        <select class="form-control font_size_12 m-auto select2" id="corporate_name" name="corporate_name">
            <option value="">Select Corporate</option>
            @if (isset($corporate_info))
                @foreach ($corporate_info as $value)
                    <option value="{{ $value->ccm_client_no_pk }}">{{ $value->ccm_client_name }}</option>
                @endforeach
            @endif
        </select>
    </div>


    <label for="corporate_id" class="col-sm-2 col-form-label col-form-label-sm d-none corporate_id">Corporate
        ID</label>
    <div class="col-sm-4 d-none corporate_id">
        <input type="text" class="form-control form-control-sm d-none corportate_id" maxlength="50"
            id="corporate_id" name="corporate_id" value="" placeholder="Enter Corporate ID">
    </div>

    <label for="paymode" class="col-sm-2 d-none col-form-label col-form-label-sm ">Paymode <span
            class="text-danger">*</span></label>
    <div class="col-sm-4 ">
        <select class="form-control font_size_12 m-auto d-none" id="paymode" name="paymode">
            <option value="">Select Paymode</option>
            @if (!empty($paymodes))
                @foreach ($paymodes as $key => $data)
                    <option value="{{ $key }}">
                        {{ $data }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

@if (Route::currentRouteName() != 'ipd.quick-admission')
    <div class="form-group row">
        <label class="col-sm-6 col-form-label col-form-label-sm ">Registration Fee :
            {{ isset($registration_fee->sales_price) ? $registration_fee->sales_price : 0 }} BDT</label>
        <input type="hidden" class="keep_me" name="item_name"
            value="{{ isset($registration_fee->item_name) ? $registration_fee->item_name : 0 }} ">
        <input type="hidden" class="keep_me" name="item_no_pk"
            value="{{ isset($registration_fee->item_no_pk) ? $registration_fee->item_no_pk : 0 }} ">
        <input type="hidden" class="keep_me" name="sales_price"
            value="{{ isset($registration_fee->sales_price) ? $registration_fee->sales_price : 0 }} ">
    </div>
@endif
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    $(document).ready(function() {
        $(".date_picker").datepicker({}).on("change", function() {
            $.ajax({
                url: "{{ route('registration.calculateagebydate') }}",
                method: "post",
                data: {
                    patient_dob: $('#patient_dob').val()
                },
                success: function(res) {
                    //alert(res.new_year + "," +res.new_month +",")
                    $('#pat_age_m').val(res.new_month);
                    $('#pat_age_y').val(res.new_year)
                    $('#pat_age_d').val(res.new_day)
                }
            })
        });

        var timer;

        $('body').on('keyup', '#pat_age_y', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: _this.val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                })
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_m', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: _this.val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_d', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: _this.val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })
    })

    function removeRequired() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();

        if ((pat_age_d != '' && pat_age_d > 0) || (pat_age_m != '' && pat_age_m > 0) || (pat_age_d != '' && pat_age_d >
                0)) {
            $('#pat_age_y').removeAttr('required')
        } else {
            $('#pat_age_y').attr('required', true)
        }
    }

    // $(document).on('keyup focus blur', '#patient_dob', function() {

    //     $('.date_picker').datepicker({
    //         format: 'dd-mm-yyyy',
    //         autoclose: true,
    //         clearBtn: true,
    //         todayHighlight: true,
    //     });
    // })



    function datepic(element) {
        // $('.date_picker').datepicker({
        //     format: 'dd-mm-yyyy',
        //     autoclose: true,
        //     clearBtn: true,
        // });
    }



    function get_dob_by_agee() {
        // var pat_age_y = $('#pat_age_y').val();
        // var pat_age_m = $('#pat_age_m').val();
        // var pat_age_d = $('#pat_age_d').val();

        // var cur_date = new Date();
        // var cur_y = cur_date.getFullYear();

        //     var dob = pat_age_d + "-" +  (pat_age_m  )+ "-" + (cur_y - pat_age_y);
        //     var dob_year = cur_y - pat_age_y;
        //     if((pat_age_m.length && pat_age_d.length) > 0){
        //         $("#patient_dob").val(dob);
        //     }else{
        //         $("#patient_dob").val(dob_year);
        //     }

        //     $('.date_picker').datepicker({
        //         format: 'dd-mm-yyyy',
        //         autoclose: true,
        //         todayHighlight: true,
        //         clearBtn: true,
        //     });
    }
    // $('.date_picker').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    //     todayHighlight: true,
    //     clearBtn: true,
    // });
    function convertTZ(date, tzString) {
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
            timeZone: tzString
        }));
    }

    function get_dob_by_age() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();



        var date = new Date();
        var today = convertTZ(date, "Asia/Dhaka");

        var pat_age_year = 0;
        var pat_age_month = pat_age_m;
        var pat_age_days = pat_age_d;

        if ((pat_age_m > 0) && pat_age_d == '' && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30)) / 365);
        } else if (pat_age_m == '' && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365)) / 365);
        } else if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d > 0 && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30) + parseInt(pat_age_days)) / 365)
        } else if (pat_age_m == '' && pat_age_d > 0 && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30)) / 365);
        } else if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30) + parseInt(pat_age_d)) / 365);
        } else {
            pat_age_year = pat_age_y;
        }

        console.log('patient age year 2 ', pat_age_year);

        var age = today.getFullYear() -
            pat_age_year; //today.getFullYear() - Math.round((parseInt(pat_age_y*365)+(parseInt(pat_age_m)*30)+parseInt(pat_age_d))/365);
        var m = (today.getMonth() + 1) - pat_age_m;
        var d = today.getDate() - pat_age_d;
        var month = 0;
        var date = 0;
        var pre_month = (today.getMonth());
        var add_days = 0;
        if (pre_month == 1) {
            add_days = 31;
        } else if (pre_month == 2) {
            add_days = 28;
        } else if (pre_month == 3) {
            add_days = 31;
        } else if (pre_month == 4) {
            add_days = 30;
        } else if (pre_month == 5) {
            add_days = 31;
        } else if (pre_month == 6) {
            add_days = 30;
        } else if (pre_month == 7) {
            add_days = 31;
        } else if (pre_month == 8) {
            add_days = 31;
        } else if (pre_month == 9) {
            add_days = 30;
        } else if (pre_month == 10) {
            add_days = 31;
        } else if (pre_month == 11) {
            add_days = 30;
        } else if (pre_month == 12) {
            add_days = 31;
        }
        if (today.getDate() < pat_age_d) {
            date = (today.getDate() + add_days) - pat_age_d;
        } else {
            var dates = today.getDate() - pat_age_d;
            if (dates == 0) {
                date = ((today.getDate() + add_days) - pat_age_d);
            } else {
                date = (today.getDate() - pat_age_d);
            }
        }

        console.log('patient age date ', date);

        if ((today.getMonth() + 1) < pat_age_m) {
            months = (today.getMonth() + 12 + 1) - pat_age_m;
            if (date == 0) {
                month = (today.getMonth() + 12 + 1) - (pat_age_m);
                if (month == 0) {
                    month += 1;
                }
            } else {
                month = (today.getMonth() + 12 + 1) - pat_age_m;
                if (month == 0) {
                    month += 1;
                }
            }
        } else {
            if (date == 0) {
                month = (today.getMonth() + 1) - (pat_age_m);
                if ((today.getMonth() + 1) > pat_age_m) {
                    month = (today.getMonth() + 12 + 1) - pat_age_m;
                }
                if (month == 0) {
                    month += 1;
                }
            } else {
                month = (today.getMonth() + 1) - pat_age_m;
                if ((today.getMonth() + 1) > pat_age_m) {
                    month = (today.getMonth() + 1) - pat_age_m;
                }
                if (month == 0) {
                    month = (today.getMonth() + 1 + 12) - pat_age_m;
                }
            }
        }
        if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
            age--;
        }
        if (month != 0 && today.getDate() < pat_age_d) {
            month--;
        }

        var age_year = today.getFullYear() - pat_age_year;

        if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear();
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y == '' && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if ((pat_age_y.length || pat_age_m.length || pat_age_d.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //$("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);
        }
        if ((pat_age_y.length && pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_y.length) > 0) {

            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
        }
        if ((pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_d.length) > 0) {
            if (pat_age_d == 30 && (pre_month == 4 || pre_month == 6 || pre_month == 9 || pre_month == 11)) {
                date = 01;
            }
            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }


        /************************************ PREVIOUS ****************************************************/
        // if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }
        // if ((pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }

        /************************************** previous *******************************************/

        $("#patient_dob").datepicker("destroy");

        /************************************ PREVIOUS ****************************************************/
        // if ((pat_age_y.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        /************************************ PREVIOUS ****************************************************/



    }



    function dob(event, element) {
        var code = event.keyCode || event.which;

        if (code != '9') {

            $('.date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            var dateString = $(element).val();
            if (dateString.indexOf('.')) {
                var dob = dateString.split(".");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            }
            if (dateString.indexOf('/')) {
                var dob = dateString.split("/");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            } else {
                dateString = $(element).val();
            }


            var dob = dateString.split("-");
            var date = new Date();
            var now = convertTZ(date, "Asia/Jakarta");
            var today = new Date(now.getYear(), now.getMonth(), now.getDate());
            var yearNow = now.getFullYear();
            var monthNow = 1 + now.getMonth();
            var dateNow = now.getDate();
            var yearDob = dob[2];
            var monthDob = dob[1];
            var dateDob = dob[0];
            var age = {};
            var ageString = "";
            var yearString = "";
            var monthString = "";
            var dayString = "";
            yearAge = yearNow - yearDob;

            if ((parseFloat(monthNow)) > monthDob) {
                var monthAge = (parseFloat(monthNow)) - monthDob;

            } else if ((parseFloat(monthNow)) == monthDob && yearNow == yearDob) {
                yearAge--;
                var monthAge = null; //(parseFloat(monthNow)) - monthDob;
            } else {
                yearAge--;
                var monthAge = (12 + parseFloat(monthNow)) - monthDob;

            }
            if (dateNow > dateDob) {
                var dateAge = dateNow - dateDob;
            } else {
                monthAge--;

                var pre_month = parseFloat(monthNow);
                var add_days = 0;
                if (pre_month == 1) {
                    add_days = 31;
                } else if (pre_month == 2) {
                    add_days = 28;
                } else if (pre_month == 3) {
                    add_days = 31;
                } else if (pre_month == 4) {
                    add_days = 30;
                } else if (pre_month == 5) {
                    add_days = 31;
                } else if (pre_month == 6) {
                    add_days = 30;
                } else if (pre_month == 7) {
                    add_days = 31;
                } else if (pre_month == 8) {
                    add_days = 31;
                } else if (pre_month == 9) {
                    add_days = 30;
                } else if (pre_month == 10) {
                    add_days = 31;
                } else if (pre_month == 11) {
                    add_days = 30;
                } else if (pre_month == 12) {
                    add_days = 31;
                }
                var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;
            }
            age = {
                years: yearAge,
                months: monthAge,
                days: dateAge
            };


            var m = now.getMonth() - monthDob;
            if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
                yearAge--;
            }


            if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
                ageString = age.years + "-" + age.months + "-" + age.days;
        }
        console.log('date picker age ', age)
        if ((age.years < 0) && (age.months >= 0) && (age.days >= 0)) {

            ageString = null + "-" + age.months + "-" + age.days;
        }

        if ((age.years == 0) && (age.months == 11) && (age.days == 31)) {

            ageString = 1 + "-" + null + "-" + null;
        }

        if ((age.months == 12)) {

            ageString = 1 + "-" + null + "-" + age.days;
        }
        var pieces = ageString.split("-");
        $("#pat_age_y").val(pieces[0]);
        $("#pat_age_m").val(pieces[1]);
        $("#pat_age_d").val(pieces[2]);
    }

    function corporate(element) {
        var corp_val = $(element).find(":selected").attr('data-type_code'); //$(element).text();
        if (corp_val == 'CORPORATE') {

            $('.corporate_name').removeClass('d-none');
            $('#corporate_name').attr('required', 'required');


            $('.corporate_id').removeClass('d-none');
            $('#corporate_id').removeClass('d-none');
        } else {
            $('.corporate_name').addClass('d-none');
            $('#corporate_name').attr('required', '');

            $('.corporate_id').addClass('d-none');
            $('#corporate_id').addClass('d-none');
        }
    }


    // agent hide show
    $("select#inform").change(function() {
        var heard_us = $(this).children("option:selected").val();
        var heard_us_attr = $(this).children("option:selected").html().toUpperCase();
        if (heard_us_attr.trim() == 'MARKETING AGENT') {

            $('.agent_id').show();
        } else {
            $('.agent_id').hide();
        }
        if (heard_us_attr.trim() == 'STAFF') {
            $('.staff__id').show();
        } else {
            $('.staff__id').hide();
        }
        if (heard_us_attr.trim() == 'CAMPAIGN') {
            $('.campaign').show();
        } else {
            $('.campaign').hide();
        }
        if (heard_us_attr.trim() == 'OTHERS') {
            $('.others').show();
        } else {
            $('.others').hide();
        }
    });
    openDoctorAutocomplete('#agent_id', 'agent_id_hdn');
    openDoctorAutocomplete('#staff__id', 'hdn_staff__id');
</script>
