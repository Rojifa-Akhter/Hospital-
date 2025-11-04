<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

{{-- {{ route('ipd.store-medicine-clinical-info') }} --}}
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Supporting Form</h5>
            <small>IPD / Nurse Station / Supporting Form</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">

            @include('admin.components.patient_info')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-capsules"></i>&nbsp; Supporting Chart Information</h5>
                        </div>

                        <div class="card-body">
                            <form id="nurse-station-medicine-details"
                                action="{{ route('ipd.ipd-supproting-store') }}" method="post">@csrf
                                <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
                                    value="{{ $patient_info->patient_no_pk }}">
                                <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
                                    value="{{ $patient_info->admission_no_pk }}">
                                <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
                                    value="{{ $patient_info->admission_uid }}">
                                <div class="d-flex justify-content-center border-bottom pb-2">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission No:
                                        @if (!empty($patient_info->admission_uid))
                                            {{ $patient_info->admission_uid }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        @if (!empty($patient_info->admission_date))
                                            {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department:
                                        @if (!empty($patient_info->admitted_department))
                                            {{ $patient_info->admitted_department }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Ward Name:
                                        @if (!empty($patient_info->ward_name))
                                            {{ $patient_info->ward_name }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Name:
                                        @if (!empty($patient_info->bed_name))
                                            {{ $patient_info->bed_name }}
                                        @endif
                                    </span>
                                </div>
                                <div class="form-row border-bottom pb-3">
                                    <div class="col-md-2">
                                        <label for="start_supporting_date" class="col-form-label col-form-label-sm">Start Time
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="timepicker form-control"
                                                name="start_supporting_time" id="start_supporting_time">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="end_supporting_date" class="col-form-label col-form-label-sm">End Time
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="timepicker form-control"
                                                name="end_supporting_time" id="end_supporting_time">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label for="instrument_id" class="col-form-label col-form-label-sm">Instruments</label>
                                            <select class="form-control form-control-sm select2 m-0 p-0"
                                                id="instrument_id" name="instrument_id">
                                                <option value="0">Select</option>
                                                @if (!empty($instrument_data))

                                                    @foreach ($instrument_data as $key=>$item)

                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3 mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="instrument_status" checked>
                                            <label class="form-check-label" for="instrument_status">
                                              On
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="instrument_status" >
                                            <label class="form-check-label" for="instrument_status">
                                             Off
                                            </label>
                                          </div>
                                    </div> --}}
                                </div>
                                <div class="form-row border-bottom ">
                                    <div class="m-0 mt-3 mb-2 mr-2 ">
                                        @php
                                            $patient_no_pk = $patient_info->patient_no_pk;
                                            $admission_no_pk = $patient_info->admission_no_pk;
                                            $response_url_page = route('ipd.ipd-supporting-form', [$patient_no_pk, $admission_no_pk]);

                                        @endphp

                                        <button
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url_page }}')"
                                            type="button" class="btn btn-success btn-sm"><i class="fa fa-save"></i>
                                            Save</button>
                                        <button type="reset" class="btn btn-info btn-sm"
                                            title="Click here to Clear form data">Clear</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <div class="form-row mt-2" id="patient-details-list">

                                    @include('admin.ipd.supporting.supporting_list_table')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                "ordering": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bAutoWidth": false,
                "searching": false,
                "bInfo": false,
            });

            $(".timepicker").timepicker({
                defaultTime: "",
                // interval: "5",
            });

            $(".date_picker").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });
            // $(".date_picker").datepicker("setDate", new Date());

        });
    </script>
