<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Admitted Patient</h5>
            <small>IPD / Admission Cancelled Patient</small>
        </div>
        <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <button type="button" class="btn btn-outline-primary btn-md open-modal uhl_common_outline_btn" data-modal="common-modal"
                    data-title="Quick Admission" data-action="{{ route('ipd.quick-admission') }}"><i
                        class="fa fa-plus"></i> Quick Admission</button>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="referred-patient-tab"
                        href="{{ route('ipd.ipd-request-referred-patient') }}" rel="tab" role="tab"
                        aria-controls="referred-patient" aria-selected="false">Referred Patient</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link " id="referred-patient-tab" data-toggle="tab"
                        href="{{ route('ipd.admission-cancelled') }}" rel="tab" role="tab"
                        aria-controls="referred-patient" aria-selected="false">Admission Cancelled</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="" href="#referred-patient" role="tab" aria-controls=""
                        aria-selected="false">Admited Patient</a>
                </li>
            </ul>

            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="admited-patient" role="tabpanel"
                    aria-labelledby="admited-patient-tab">
                    <div class="card">
                        <!-- <div class="card-header"><h5>IPD Admission</h5></div> -->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mt-2">

                                    <div class="tab-content p-" id="myTabContent">
                                        <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel"
                                            aria-labelledby="admitted-patient-tab">
                                            {{-- <div class="card"> --}}
                                                {{-- <div class="card-header card-text">
                                                    <h5>IPD Admission</h5>
                                                </div> --}}
                                                {{-- <div class="card-body"> --}}
                                                    <form id="searchForm"
                                                        action="{{ route('ipd.search-admission-patient') }}"
                                                        method="post">
                                                        <div class="form-row justify-content-center">
                                                            <div class="form-group col-md-2">
                                                                <label class="col-form-label col-form-label-sm"
                                                                    for="service_id">UHID</label>
                                                                <input type="hidden" id="hdn_patient_id"
                                                                    name="hdn_patient_id" />
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 mb-0"
                                                                    id="service_number" name="service_number" value=""
                                                                    placeholder="UHID" />
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <label class="col-form-label col-form-label-sm"
                                                                    for="admission_id">Admission ID</label>
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0"
                                                                    id="admission_id" name="admission_id" value=""
                                                                    placeholder="Admission ID">
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label class="col-form-label col-form-label-sm"
                                                                    for="admission_date_from">Admission Date</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">From</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date-picker"
                                                                        id="admission_date_from"
                                                                        name="admission_date_from" value=""
                                                                        placeholder="dd/mm/yyyy">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date-picker"
                                                                        id="admission_date_to" name="admission_date_to"
                                                                        value="" placeholder="dd/mm/yyyy">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="btn-group btn-block mt-4" role="group">
                                                                    <button type="button" class="btn btn-md btn-success btn-md-global"
                                                                        id="btnSearch" data-action="">
                                                                        Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="form-row" id="ipd_data_search">
                                                        @include('admin.ipd.ipd_request.ipd_admission_data')
                                                    </div>
                                                {{-- </div> --}}
                                            {{-- </div> --}}
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
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function res(Element) {
        $("#hdn_patient_id").val("");
    }
    openPatientAutocomplete('#service_number', 'patient_name');
    $(document).ready(function() {
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });


    })
    var ipdAdmission = {
        SearchPatient: function (item, obj) {
            var patient_code = item.patient_code;
            $.ajax({
                url: "{{ route('patient-info-json') }}",
                type: 'post',
                data: {patient_code: patient_code},
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $("#patient_name").html(data.patient_name);
                    $("#patient_age").html(data.age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group);
                    $("#patient_ms").html(data.marital_status_txt);
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        },
    }
    // openPatientAutocomplete('#service_number', '#hdn_patient_id', ipdAdmission.SearchPatient);
    $(document).on("click", "#btnSearch", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{route ('ipd.search-admission-patient') }}",
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
