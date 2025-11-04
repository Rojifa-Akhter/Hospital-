@php
    $tripList = isset($tripList) && !empty($tripList) ? $tripList : '';

    $ambt_trip_no_pk = $tripList != '' ? $tripList['ambt_trip_no_pk'] : '';
    $trip_patient_type = $tripList != '' ? $tripList['trip_patient_type'] : '';
    $start_date =
        $tripList != '' && $tripList['start_time'] != ''
            ? date('d-m-Y', strtotime(explode(' ', $tripList['start_time'])[0]))
            : '';
    $start_time =
        $tripList != '' && $tripList['start_time'] != ''
            ? date('h:i a', strtotime(explode(' ', $tripList['start_time'])[1]))
            : '';
    $end_date =
        $tripList != '' && $tripList['end_time'] != ''
            ? date('d-m-Y', strtotime(explode(' ', $tripList['end_time'])[0]))
            : '';
    $end_time =
        $tripList != '' && $tripList['end_time'] != ''
            ? date('h:i a', strtotime(explode(' ', $tripList['end_time'])[1]))
            : '';
    //  dd($end_time);
    $patient_no_fk = $tripList != '' ? $tripList['patient_no_fk'] : '';
    $admission_no_fk = $tripList != '' ? $tripList['admission_no_fk'] : '';
    $patient_name = $tripList != '' ? $tripList['patient_name'] : '';
    $phone_mobile = $tripList != '' ? $tripList['phone_mobile'] : '';
    $start_from_location = $tripList != '' ? $tripList['start_from_location'] : '';
    $ended_to_location = $tripList != '' ? $tripList['ended_to_location'] : '';
    $total_bill = $tripList != '' ? $tripList['total_bill'] : '';

    $due_bill = $tripList != '' ? ($tripList['ledger_amt_sales'] - $tripList['ledger_amt_discount'] ) - $tripList['ledger_amt_payment']  : '';
    $status = $tripList != '' ? $tripList['status'] : '';
    $person_no_fk = $tripList != '' ? $tripList['person_no_fk'] : '';
    $driver_name = $tripList != '' ? $tripList['driver_name'] : '';
    $ambs_ambulance_no_fk = $tripList != '' ? $tripList['ambs_ambulance_no_fk'] : '';
    $invoice_no_fk = $tripList != '' ? $tripList['invoice_no_fk'] : '';
    $remarks = $tripList != '' ? $tripList['remarks_text'] : '';
@endphp
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('ambulance.ambulance-trip-save') }}" method="post" id="ambulanceTripSave">
        @csrf
        <input type="hidden" name="trip_id" value="{{ $ambt_trip_no_pk }}">
        <input type="hidden" name="trip_type" id="trip_type" value="{{ $trip_patient_type }}">
        <input type="hidden" name="previous_amb_id" id="previous_amb_id" value="{{  $ambs_ambulance_no_fk }}">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Ambulance Trip </h5>
                                <small>Ambulance / Ambulance Trip </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="form-row">
                            <div class="col-md-2"><span>Patient Information</span></div>
                            <div class="col-lg-8 col-md-8 col-8">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" name="trip_patient_type"
                                        id="WalkIn" value="WalkIn" onchange="ChangePtType(this)"
                                        @if ($trip_patient_type == 'WalkIn') checked @endif>
                                    <label class="custom-control-label" for="WalkIn">Walk-In</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" name="trip_patient_type"
                                        id="Registered" value="Registered" onchange="ChangePtType(this)"
                                        @if ($trip_patient_type == 'Registered') checked @endif>
                                    <label class="custom-control-label" for="Registered">Registered</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" name="trip_patient_type"
                                        id="Admitted" value="Admitted" onchange="ChangePtType(this)"
                                        @if ($trip_patient_type == 'Admitted') checked @endif>
                                    <label class="custom-control-label" for="Admitted">Admitted</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12 d-none" id="uhid_hide">
                                <div class="form-group form-row ">
                                    <label for="patient_id" class="col-sm-4 col-form-label">UHID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="patient_id"
                                            name="patient_id" placeholder="" value="" autocomplete="off" />
                                        <input type="hidden" class="form-control" id="hdn_patient_id"
                                            name="hdn_patient_id" value="{{ $patient_no_fk }}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-md-3 col-12 d-none" id="admission_id_hide">
                                <div class="form-group form-row ">
                                    <label for="admission_id" class="col-sm-4 col-form-label">Admission Id</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="admission_id"
                                            name="admission_id" placeholder="" value="{{ $admission_no_fk }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group form-row">
                                    <label for="patient_name" class="col-sm-4 col-form-label">Patient Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="patient_name"
                                            name="patient_name" placeholder="" value="{{ $patient_name }}"
                                            autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group form-row">
                                    <label for="mobile_no" class="col-sm-4 col-form-label">Mobile</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="mobile_no"
                                            name="mobile_no" placeholder="" autocomplete="off"
                                            value="{{ $phone_mobile }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span>Trip Information</span>

                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="ambulance_name"
                                                class="col-sm-4 col-form-label">Ambulance</label>
                                            <div class="col-sm-8">   
                                                                                      
                                                <select class="form-control form-control-sm" id="ambulance_name"
                                                    name="ambulance_name" required>
                                                    <option value="0">Select</option>
                                                    @if (!empty($ambulance_info))
                                                        @foreach ($ambulance_info as $record)
                                                            <option value="{{ $record['ambs_ambulance_no_pk'] }}"
                                                                @if ($ambs_ambulance_no_fk == $record['ambs_ambulance_no_pk']) selected @endif>
                                                                {{ $record['ambs_ambulance_name'] }}(  {{ $record['no_plate'] }})</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="driver" class="col-sm-4 col-form-label">Driver Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="driver" name="driver" placeholder="Enter Name"
                                                    value="{{ $driver_name }}" autocomplete="off" required />
                                                <input type="hidden" name="emp_id" id="emp_id"
                                                    value="{{ $person_no_fk }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="from_location" class="col-sm-4 col-form-label">From
                                                Location</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="from_location" name="from_location" placeholder=""
                                                    value="{{ $start_from_location }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="to_location" class="col-sm-4 col-form-label">To
                                                Location</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="to_location" name="to_location" placeholder=""
                                                    value="{{ $ended_to_location }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="start_date" class="col-sm-4 col-form-label">Start Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="start_date" name="start_date" placeholder="dd-mm-YYYY"
                                                    value="{{ $start_date }}" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="start_time" class="col-sm-4 col-form-label">Start Time</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm timepicker"
                                                    id="start_time" name="start_time" placeholder="Start Time"
                                                    value="<?php echo htmlspecialchars($start_time); ?>" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($invoice_no_fk != '' &&  $due_bill <= 0 )
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="end_date" class="col-sm-4 col-form-label">End Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="end_date" name="end_date" placeholder="dd-mm-YYYY"
                                                        value="{{ $end_date }}" autocomplete="off" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="end_time" class="col-sm-4 col-form-label">End Time</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control form-control-sm timepicker" id="end_time"
                                                        name="end_time" placeholder="End Time"
                                                        value="<?php echo htmlspecialchars($end_time); ?>" autocomplete="off" required />
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="bill_amt" class="col-sm-4 col-form-label">Bill Amount</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control form-control-sm "
                                                    id="bill_amt" name="bill_amt" placeholder=""
                                                    value="{{ $total_bill }}" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                                            <div class="col-sm-8">
                                                <textarea name="remarks" id="remarks" class="form-control" cols="3" rows="2">{{$remarks}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right mt-3">
                                        @php
                                            $response_action = route('ambulance.ambulance-trip-list');
                                        @endphp
                                        <button class="btn btn-secondary uhl_save_btn"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                            Save</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#driver', 'emp_id', "employee_ind", 1,'','DRIVER');
    openPatientAutocompleteForBilling('#patient_id', 'patient_name', patientInfo);
    $(function() {
        if ($('#trip_type').val() != '') {
            let tripType = $('#trip_type').val();
            ChangePtType($('#' + tripType));
        } else {
            $('#WalkIn').prop('checked', true);
        }
    })

    function patientInfo(item, obj) {
        let pt_name = item.patient_name != null ? item.patient_name : '';
        let phone_no = item.phone_mobile != null ? item.phone_mobile : '';
        $('#patient_name').val(pt_name);
        $('#mobile_no').val(phone_no);
        console.log(item);
    }

    $(document).on('keypress', '#admission_id', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Prevent default form submission behavior
            admissionId($(this).val(), admissionPatientInfo);
            $(this).focus();

            e.stopImmediatePropagation();
        }
    });


    function admissionId(query, callback) {
        $.ajax({
            url: "{{ route('admission-info-get-data') }}",
            type: 'POST',
            data: {
                search_data: query
            },
            dataType: 'json',
            success: function(item, obj) {
                callback(item, obj);
                console.log(item + '________result')
            }
        });
    }

    function admissionPatientInfo(item, obj) {
        let pt_name = item.patient_name != null ? item.patient_name : '';
        let phone_no = item.phone_mobile != null ? item.phone_mobile : '';
        let patient_id = item.patient_id != null ? item.patient_id : '';
        $('#patient_name').val(pt_name);
        $('#mobile_no').val(phone_no);
        $('#hdn_patient_id').val(patient_id);
        console.log(item);
    }
    $('.timepicker').timepicker({
        defaultTime: ''
    });
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    function resetDate() {
        $('#patient_id').val('');
        $('#admission_id').val('');
        $('#patient_name').val('');
        $('#hdn_patient_id').val('');
        $('#mobile_no').val('');
    }

    function ChangePtType(element) {
        let type = $(element).attr('id');
        if ($('#trip_type').val() == '') {
            resetDate();
        }
        if (type == "WalkIn") {
            $('#uhid_hide').addClass('d-none');
            $('#admission_id_hide').addClass('d-none');


        } else if (type == "Registered") {
            $('#uhid_hide').removeClass('d-none');
            $('#admission_id_hide').addClass('d-none');

        } else if (type == "Admitted") {
            $('#uhid_hide').addClass('d-none');
            $('#admission_id_hide').removeClass('d-none');

        }
    }
</script>
