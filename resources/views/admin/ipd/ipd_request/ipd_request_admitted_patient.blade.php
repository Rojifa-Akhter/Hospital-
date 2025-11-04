<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Admitted Patient List</h5>
            <small>IPD / Admitted Patient List</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" rel="tab" href="{{ route('ipd.quick-admission') }}"><i
                        class="fa fa-plus"></i> Quick Admission</a>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                {{-- <li class="nav-item" role="presentation"> --}}
                {{-- <a class="nav-link active" id="referred-patient-tab" href="#" rel="tab" role="tab" aria-controls="referred-patient" aria-selected="false">Admission Patient</a> --}}
                {{-- </li> --}}

                {{-- <li class="nav-item" role="presentation"> --}}
                {{-- <a class="nav-link " id="admitted-patient-tab" data-toggle="tab" href="#" role="tab" aria-controls="admitted-patient" aria-selected="false">Discharge Patient</a> --}}
                {{-- </li> --}}
            </ul>

            <div class="tab-content p-" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel"
                    aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-header card-text">
                            <h5>IPD Admission</h5>
                        </div>
                        <div class="card-body">
                            <form id="searchForm" action="{{ route('ipd.search-admission-patient') }}" method="post">
                                <div class="form-row justify-content-center">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="service_id">
                                            @if(Session::get('user.ses_hospital_code') == 'KPJ')
                                                MRN
                                            @else
                                                UHID
                                            @endif
                                        </label>
                                        <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                        <input type="text" class="form-control form-control-sm m-0 mb-0"
                                            id="service_number" name="service_number" value=""
                                            placeholder="{{ Session::get('user.ses_hospital_code') == 'KPJ' ? 'MRN' : 'UHID' }}" />
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="admission_id">IP No</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                            name="admission_id" value="" placeholder="IP No">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="col-form-label col-form-label-sm"
                                            for="admission_date_from">Admission Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="admission_date_from" name="admission_date_from" value=""
                                                placeholder="dd/mm/yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="admission_date_to" name="admission_date_to" value=""
                                                placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="patient_type"> @if(Session::get('user.ses_hospital_code')=="UNICO") Nurse Station @else Department @endif</label>
                                        <select class="form-control form-control-sm m-0" id="patient_type" name="patient_type">
                                            <option value="">Select patient Department</option>
                                            @if (!empty($requestDepts))
                                                @foreach ($requestDepts as $rd)
                                                    <option value="{{ $rd->serviceunit_no_pk }}">
                                                        {{ $rd->serviceunit_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="btn-group btn-block mt-4" role="group">
                                            <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearch"
                                                data-action="">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="form-row" id="ipd_data_search">
                                @include('admin.ipd.ipd_request.ipd_admission_data')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });
    var ipdAdmission = {
        SearchPatient: function(item, obj) {
            var patient_code = item.patient_code;
            $.ajax({
                url: "{{ route('patient-info-json') }}",
                type: 'post',
                data: {
                    patient_code: patient_code
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#patient_name").html(data.patient_name);
                    $("#patient_age").html(data.age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group);
                    $("#patient_ms").html(data.marital_status_txt);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
    }
    // openPatientAutocomplete('#service_number', '#hdn_patient_id', ipdAdmission.SearchPatient);
    openPatientAutocomplete('#service_number', 'patient_name');
    $(document).on("click", "#btnSearch", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('ipd.search-admission-patient') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#ipd_data_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
