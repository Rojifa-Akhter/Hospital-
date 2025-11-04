<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Employee List</h5>
                <small>HRM / Employee Setup / Employee List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="empfrmSearchV1" method="post" action="{{ route('emp_print_v1') }}" target="_blank">
                    @csrf

                    <div class="form-row justify-content-center">
                        <div class="col-sm-1">
                            <label for="app_date">Card No.</label>
                            <input type="text" class="form-control " name="emp_name" id="emp_name"
                                placeholder="Card No." />
                            <input type="hidden" name="emp_id" id="emp_id">
                        </div>
                        <div class="col-sm-2">
                            <label for="doctor_code">Departments</label>
                            <select class="form-control form-control-sm select2" name="department" id="department" onchange="getUnits(this)">
                                <option value="">Select</option>
                                @if (!empty($departments))
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->serviceunit_no_pk }}">
                                            {{ $value->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-2" id="unit_list_container">
                            @include('admin.v1.hrm.employee_setup.unit_list')
                        </div>

                        <div class="col-sm-2">
                            <label for="patient_id">HR Attendence Type</label>
                            <select class="form-control form-control-sm select2" name="hr_type">
                                <option value="">Select</option>
                                @if (!empty($hr_type))
                                    @foreach ($hr_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="cheif_compl">Job Type</label>
                            <select class="form-control form-control-sm select2" name="job_type">
                                <option value="">Select</option>
                                @if (!empty($job_type))
                                    @foreach ($job_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-1">
                            <label for="app_priority">Roaster</label>
                            <select class="form-control font_size_12 m-auto" id="roster_type" name="roster_type">
                                <option value="" selected="selected">Select Roster Type</option>
                                <option value="General"> General </option>
                                <option value="Roster">Roster </option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label for="app_priority">Status</label>
                            <select class="form-control font_size_12 m-auto" id="status" name="status">
                                <option value="" selected="selected">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive </option>
                                <option value="4">Resigned </option>
                                <option value="5">Dismissed </option>
                            </select>
                        </div>

                        <div class="col-sm-1">
                            <input type="checkbox" name="emp_ind" value="1" id="emp_ind">
                            <label for="emp_ind">Employee</label><br>

                            <input type="checkbox" name="doc_ind" value="1" id="doc_ind">
                            <label for="doc_ind">Doctor</label> <br>

                            <input type="checkbox" name="ref_ind" value="1" id="ref_ind">
                            <label for="ref_ind">Referral</label>
                        </div>

                        {{-- <div class="col-sm-2">
                            <button type="button" class="btn btn-md btn-danger btn-block mt-4" class="reset" id="reset" onclick="Clear()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div> --}}

                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block " role="group">
                                <button type="button" class="btn btn-md btn-success btn-block mt-4" id="emp_searchV1"
                                    onclick=""> <i class="fas fa-search"></i> Search</button>
                                <button type="button" id="exportinexcel" onclick="exportPDF(this)"
                                    class="btn btn-md btn-warning btn-block mt-4 print"><i
                                        class="fa fa-file-excel"></i>
                                    Export In
                                    Excel</button>
                                <button type="button" id="IPD"
                                    class="btn btn-md btn-primary btn-block mt-4 print" target="_blank"
                                    onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                    PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header ">
                <h5>Employee List
                    <!-- 	<button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal" data-action="{{ route('doctor.create') }}" data-title="Create New Employee">Add Employee</button> -->
                </h5>
            </div>

            <div class="card-body" id="doctor-list">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped" border="1">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th scope="col">#SL </th>
                                    <th scope="col">Image</th>
                                    {{-- <th scope="col">Code</th> --}}
                                    <th scope="col">Card No</th>
                                    <th scope="col" class="text-left">Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Specialization</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Address</th>

                                    <th scope="col">Status</th>
                                    <th scope="col" style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="emp_infov1">
                                @include('admin.v1.hrm.employee_setup.employee_info_v1')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1);

    $(document).ready(function() {
        // $('.data-table').DataTable();
        $('.select2').select2();
        $('.data-table').DataTable();

    });
    $("body").addClass("sidebar-collapse");

    $(document).on("click", "#emp_searchV1", function(e) {

        var formID = $("#empfrmSearchV1").attr("id");
        var formMethod = $("#empfrmSearchV1").attr("method");
        console.log('ok');

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.employee_search_v1') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#emp_infov1").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function getUnits(thisElement) { 
        let department_id = thisElement.value;
        
        $.ajax({
            url: "{{ route('v1.hrm.employees.get-units-by-department') }}",
            type: 'POST',
            data: {
                department_id: department_id
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                let unitDropdown = $('#service_unit'); // Select the dropdown
                unitDropdown.empty(); // Clear existing options
                unitDropdown.append('<option value="">Select</option>'); // Add default option
                
                if (data.length > 0) {
                    $.each(data, function(index, unit) {
                        unitDropdown.append('<option value="' + unit.serviceunit_no_pk + '">' + unit.serviceunit_name + '</option>');
                    });
                } else {
                    unitDropdown.append('<option value="">No units found</option>'); // If no data available
                }

                // Reinitialize Select2 (if using Select2 plugin)
                unitDropdown.select2();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    };
    // search

    // $(document).on('click', '#emp_search', function() {
    //     var formID = $("#empfrmSearch").attr("id");
    //     var formMethod = $("#empfrmSearch").attr("method");
    //     var imgUrl = '{{ URL::asset('images/uploads/doctor_images') }}';
    //     var docImgName = "doc-1.png";
    //     var nurseImgName = "nurse-2.png";
    //     var defaultImgUrl = '{{ URL::asset('images') }}';
    //     //alert($('input[name="emp_id"]').val())
    //     $('#datatable').empty();
    //     $('#datatable').DataTable().destroy();
    //     $('#datatable').DataTable({
    //         "searching": false,
    //         "processing": true,
    //         "serverSide": true,
    //         "pageLength": 50,
    //         "order": [
    //             [0, "desc"]
    //         ],
    //         "ajax": {
    //             "url": "{{ url('employee_search') }}",
    //             "dataType": "json",
    //             "type": "POST",

    //             data: {
    //                 emp_id: $('input[name="emp_id"]').val(),
    //                 service_unit: $('#service_unit').val(),
    //                 hr_type: $('#hr_type').val(),
    //                 job_type: $('#job_type').val(),
    //                 roster_type: $('#roster_type').val(),
    //                 status: $('#status').val(),
    //                 emp_ind: $('#emp_ind').is(':checked') ? $('#emp_ind').val() : '',
    //                 doc_ind: $('#doc_ind').is(':checked') ? $('#doc_ind').val() : '',
    //                 ref_ind: $('#ref_ind').is(':checked') ? $('#ref_ind').val() : '',
    //             }
    //         },

    //     });
    // });

    function exportPDF(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#empfrmSearchV1").submit();
    }

    function exportPDFIPD(element) {
        $("#hdn_report_type").val("PDF");
        $("#empfrmSearchV1").submit();
    }
</script>
