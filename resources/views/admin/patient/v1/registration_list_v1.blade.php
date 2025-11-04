<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}"> --}}
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Registered Patient List </h5>
                <small>Patient / Patient List</small>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Search Panel</h5>
                    </div>
                    <div class="card-body border-bottom-3 p-2">
                        <form action="{{ route('patient-print', 'PDF') }}" method="POST" id="patient-search" target="_blank">
                        {{-- <form action="{{ route('patientRegistration.indexV1') }}" method="GET" id="patient-search" target="_blank"> --}}
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="patient_id">Patient ID / Name </label>
                                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                                placeholder="Enter Patient ID" />
                                            <input type="hidden" class="form-control" id="hdn_patient_id"
                                                name="hdn_patient_id" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="patient_gender">Gender </label>
                                            <select class="form-control" id="patient_gender" name="patient_gender">
                                                <option value="">Select Gender</option>
                                                @if (isset($gender))
                                                    @foreach ($gender as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="patient_blood">Blood Group </label>
                                            <select class="form-control" id="patient_blood" name="patient_blood">
                                                <option value="">Select Blood Group</option>
                                                @if (isset($bloodg))
                                                    @foreach ($bloodg as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="patient_age">Age</label>
                                            <input type="text" class="form-control " id="patient_age"
                                                name="patient_age" value="" placeholder="Patient Age">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="patient_religion">Religion </label>
                                            <select class="form-control" id="patient_religion" name="patient_religion">
                                                <option value="">Select Religion</option>
                                                @if (isset($religion))
                                                    @foreach ($religion as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patient_status">Status</label>
                                                <select class="form-control" id="patient_status" name="patient_status">
                                                    <option value="">Select Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 border-left">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patient_marital_status">Marital Status</label>
                                                <select class="form-control" id="patient_marital_status"
                                                    name="patient_marital_status">
                                                    <option value="">Select Marital Status</option>
                                                    @if (isset($marital_status))
                                                        @foreach ($marital_status as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patient_nid">NID</label>
                                                <input type="text" class="form-control" id="patient_nid"
                                                    name="patient_nid" placeholder="Patient NID">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patient_type">Patient Type</label>
                                                <select class="form-control  select2" id="patient_type"
                                                    name="patient_type">
                                                    <option value="">Select patient type</option>
                                                    @if (isset($patient_type))
                                                        @foreach ($patient_type as $value)
                                                            <option value="{{ $value->patient_type_no_pk }}">
                                                                {{ $value->patient_type_code }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corporate_name ">Corporate</label>
                                                <select class="form-control select2" id="corporate_name"
                                                    name="corporate_name">
                                                    <option value="">Select Corporate</option>
                                                    @if (isset($corporate_code))
                                                        @foreach ($corporate_code as $value)
                                                            <option value="{{ $value->ccm_client_no_pk }}">
                                                                {{ $value->ccm_client_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="search_date_from">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_from" name="search_date_from"
                                                        value="" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_to" name="search_date_to"
                                                        value="" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for=""></label>
                                            {{-- <button type="button" id="searchPatient" class="btn btn-success btn-md btn-block"><i class="fa fa-search"></i> Search</button> --}}

                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" id="searchPatient"
                                                    class="btn btn-success btn-md btn-block"><i
                                                        class="fa fa-search"></i> Search</button>

                                                <button type='submit' class="btn btn-info btn-block btn-sm mt-0 "
                                                    target="_blank" value="1" id="PDF"
                                                    onclick="print(this)"> Export PDF</button>
                                                <button type='submit' class="btn btn-info btn-block btn-sm mt-0 "
                                                    target="_blank" value="2" id="EXCEL"
                                                    onclick="print(this)"> Export Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="patient-list">
            @if(Session::get('user.ses_hospital_code') != 'IMPALA')
            @include('admin.patient.v1.registration_list_table_v1')
            @else
            @include('admin.patient.v1.registration_list_table_impala_v1')
            @endif
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openPatientAutocomplete('#patient_id', 'patient_name');
    $(document).ready(function() {
        $('.select2').select2();
        $('.select3').select2();
        $('#item_wise_table').DataTable();
    });
    $(function() {
        $('.date_picker').datepicker({
            // todayHighlight: true,
            // clearBtn: true,
            // autoclose: true,
            // endDate: '+0d',
            // 'format': 'dd/mm/yyyy'

            todayHighlight: true,
			clearBtn: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
            autoclose: true,
        });
    });

    function print(element) {
        var url = "{{ route('patient-print', ':id') }}";
        var print_id = $(element).attr('id');

        // var action= $(element).parent('form').attr('action');
        if (print_id == "PDF") {
            url = url.replace(":id", 'PDF');
            $(element).parent().parent().parent().parent().parent().parent('form').attr('action', url);
        } else {

            url = url.replace(":id", 'EXCEL');
            $(element).parent().parent().parent().parent().parent().parent('form').attr('action', url);
        }
    }

    $(document).on("click", "#searchPatient", function() {
    	$.ajax({
    		data: {
                hdn_patient_id:         $('input[name="hdn_patient_id"]').val(),
                patient_gender:         $('#patient_gender').val(),
                patient_age:            $('#patient_age').val(),
                patient_nid:            $('#patient_nid').val(),
                patient_marital_status: $('#patient_marital_status').val(),
                patient_religion:       $('#patient_religion').val(),
                patient_status:         $('#patient_status').val(),
                patient_blood:          $('#patient_blood').val(),
                patient_type:           $('#patient_type').val(),
                corporate_name:         $('#corporate_name').val(),
                search_date_from:       $('#search_date_from').val(),
                search_date_to:         $('#search_date_to').val(),
            },
    		url: "{{ route('patientRegistration.filter') }}",
    		type: "POST",
    		beforeSend: function() {
    			blockUI();
    		},
    		success: function(data) {
    			$("#patient-list").html(data);
    			// $("#appointment-list").html('').append(data.html);
    		},
    		complete: function() {
    			$.unblockUI();
    		}
    	});
    });
</script>
