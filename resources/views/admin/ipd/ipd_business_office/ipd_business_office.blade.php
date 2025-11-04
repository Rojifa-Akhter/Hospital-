<style>
    .select2-container {
        height: 35px;
    }

    .select2-container .select2-selection--single {
        height: 27px !important;

    }

    .btn-md,
    .btn-group-md>.btn {
        padding: 3px 0px !important;
        display: inline-block;
    }

    @media only screen and (min-width: 1600px) {
        .input-group-prepend {
            height: 30px !important;
        }

        .select2-container {
            height: 38px;
        }

        .select2-container .select2-selection--single {
            height: 31px !important;

        }

        .outline-link {
            outline: 1px solid red; /* Adjust style as needed */
        }
        .outline-link2 {
            outline: 1px solid green; /* Adjust style as needed */
        }

    }
</style>




<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid" id="ipdSearchResult">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Business Office</h5>
            <small>IPD / Business Office</small>
        </div>
        <div class="col-md-6 text-right">
        <a href="{{route('thirty-days-admited-patient-list')}}" class="btn btn-sm  outline-link2" target="_blank">@if(Session::get('user.ses_hospital_code') =="IMPERIAL") Todays  @else 30 Days @endif Admited Patient <strong>({{$oneMonthAdmitedPatient->thirty_days_stay}})</strong></a>    
        <a href="{{route('today-discharge-list')}}" class="btn btn-sm  outline-link" target="_blank">Today Discharge Patient <strong> ({{$today_discharge_patient->count_discharge_patient}})</strong></a>  
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            
        </div>
        <div class="card-body p-2 border-bottom">
            <form action="{{ route('ipd.ipd-business-office-search') }}" id="ipdBusinessOfficeSearch" method="post">
                @csrf
                <input type="hidden" name="patient_type" id="patient_type" value="{{$type}}">
                <div class="form-row align-items-center justify-content-center">
                    <div class="col-md-3">
                        <div class="custom-control custom-radio custom-control-inline align-items-center">
                            <input type="radio" class="custom-control-input addmited_discharged" id="admitted"
                                name="patient_status" onchange="admitDischarge(this)" value="0" checked>
                            <label class="custom-control-label" for="admitted">Admitted</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline align-items-center">
                            <input type="radio" class="custom-control-input addmited_discharged" id="dischage"
                                name="patient_status" onchange="admitDischarge(this)" value="1">
                            <label class="custom-control-label" for="dischage">Discharged</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline align-items-center">
                            <input type="radio" class="custom-control-input addmited_discharged" id="requested"
                                name="patient_status" onchange="admitDischarge(this)" value="2">
                            <label class="custom-control-label" for="requested">Requested</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="admission_date_form">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Form</div>
                                </div>
                                <input type="text" class="form-control form-control-sm mb-0 date_picker"
                                    id="admission_date_from" name="search_admission_date_from" value=""
                                    placeholder="dd-mm-yyyy">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm mb-0 date_picker"
                                    id="admission_date_to" name="search_admission_date_to" value=""
                                    placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="admission_id">IP No</label>
                            <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                name="admission_id" value="" placeholder="Enter IP No">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="select_consultant">Consultant</label>
                            <select class="form-control form-control-sm select2" id="select_consultant"
                                name="select_consultant">
                                <option value="">Select Consultant</option>
                                @if (!empty($consultant))
                                    @foreach ($consultant as $value)
                                        <option value="{{ $value->person_no_pk }}"> {{ $value->full_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="select_bed_cabin">Bed/Cabin</label>
                            <select class="form-control form-control-sm select2" id="select_bed_cabin" name="select_bed_cabin">
                                <option value="">Select Bed/Cabin</option>
                                @if (!empty($bed_info))
                                    @foreach ($bed_info as $value)
                                        <option value="{{ $value->bed_no_pk }}"> {{ $value->bed_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="select_ward">Bed Category</label>
                            <select class="form-control form-control-sm select2" id="select_ward" name="select_ward">
                                <option value="">Select Bed Category</option>
                                @if (!empty($ward_info))
                                    @foreach ($ward_info as $value)
                                        <option value="{{ $value->ward_no_pk }}"> {{ $value->ward_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm" for="select_service_unit">Service
                                Unit</label>
                            <select class="form-control form-control-sm select2" id="select_service_unit"
                                name="select_service_unit">
                                <option value="">Select Service Unit</option>
                                @if (!empty($serviceunit))
                                    @foreach ($serviceunit as $service)
                                        <option value="{{ $service->serviceunit_no_pk }}">
                                            {{ $service->serviceunit_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="hdn_admission_id" id="hdn_admission_id">
                    <input type="hidden" name="hdn_patient_id" id="hdn_patient_id">

                    <div class="col-md-3">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-md btn-success btn-block mb-1 mt-2"
                                    onclick="btnIPDSearch()"><i class="fas fa-search"></i>&nbsp;Search</button>
                            </div>
                            <div class="col-md-6">
                                <span id="" class="btn btn-md btn-danger btn-block mb-1 mt-2"
                                    onclick="btnClear(this)"><i class="fa fa-redo"></i> Clear</span>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="ipd_business_office_result">

        @include('admin.ipd.ipd_business_office.ipd_business_office_result')

    </div>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="text/javascript">


        function btnClear(Element) {
            $("#ipdBusinessOfficeSearch").find("input").not('.keep_me').val('');
            $("#ipdBusinessOfficeSearch").find("input, textarea").val("");
            //     $("#discharge_form").find("select").val("");
            $('#select_consultant').select2({
                id: '',
                a_key: 'Select Consultant'
            });
            $('#select_service_unit').select2({
                id: '',
                a_key: 'Select Service Unit'
            });

            $('#select_bed_cabin').select2({
                id: '',
                a_key: 'Select Cabin'
            });

            $('#select_ward').select2({
                id: '',
                a_key: 'Select Bed'
            });

            document.getElementById("ipdBusinessOfficeSearch").reset();
        }

        function admitDischarge(Element) {

            var data = $(Element).val();
            var patient_type = $('#patient_type').val();

            $.ajax({
                data: {
                    data: data,
                    patient_type: patient_type
                },
                url: "{{ route('ipd.ipd-business-office-search-admit') }}",
                type: 'get',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ipd_business_office_result").html(data);
                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
                }
            });
        }

        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        openAdmissionAutocomplete('#admission_id', 'patient_name', '');
        $(".select2").select2();

        function btnIPDSearch() {
            formAction = $("#ipdBusinessOfficeSearch").attr("action");
            formMethod = $("#ipdBusinessOfficeSearch").attr("method");
            $.ajax({
                data: $("#ipdBusinessOfficeSearch").serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ipd_business_office_result").html(data);
                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
                }
            });
        }
    </script>
