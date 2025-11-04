<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Employee List</h5>
                <small>Settings / Employee Setup / Employee List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="empfrmSearch" method="post" action="{{ route('emp_print') }}" target="_blank">
                    @csrf

                    <div class="form-row justify-content-center">
                        <div class="col-sm-2">
                            <label for="app_date">Card Number</label>
                            <input type="text" class="form-control " name="emp_name" id="emp_name"
                                placeholder="Card Number" />
                            <input type="hidden" name="emp_id" id="emp_id">
                        </div>

                        <div class="col-sm-2">
                            <label for="doctor_code">Service Unit</label>
                            <select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
                                <option value="">Select</option>

                                @if (!empty($service_unit))
                                    @foreach ($service_unit as $value)
                                        <option value="{{ $value->serviceunit_no_pk }}">
                                            {{ $value->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="patient_id">HR Attendence Type</label>
                            <select class="form-control form-control-sm select2" name="hr_type" id="hr_type">
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
                            <select class="form-control form-control-sm select2" name="job_type" id="job_type">
                                <option value="">Select</option>
                                @if (!empty($job_type))
                                    @foreach ($job_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="app_priority">Roaster Setup</label>
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
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block " role="group">
                                <button type="button" class="btn btn-md btn-success btn-block mt-4" id="emp_search"
                                    onclick=""> <i class="fas fa-search"></i> Search</button>
                                {{-- <button type='submit' class="btn btn-primary btn-block btn-md mt-0"> Export
                                    PDF</button> --}}


                                    <button type="button" id="IPD" class="btn btn-md btn-primary btn-block mt-4 print"
                                    target="_blank" onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                    PDF</button>

                                <button type="button" id="exportinexcel" onclick="exportPDF(this)"
                                    class="btn btn-md btn-warning btn-block mt-4 print"><i
                                        class="fa
                                                 fa-file-excel"></i>
                                    Export In
                                    Excel</button>
                                <a href="{{route('emp-card-back-print')}}" target="_blank" class="btn btn-md btn-primary btn-block mt-4 print"> <i class="fa fa-print"></i> Back of ID Card</a>


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
                                    <th scope="col">Code</th>
                                    <th scope="col">Card No</th>
                                    <th scope="col" class="text-left">Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Specialization</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Address</th>

                                    <th scope="col">Status</th>
                                    <th scope="col" style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="emp_info">
                                {{-- @include('admin.hrm.employee.emp_info') --}}
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
    $("body").addClass("sidebar-collapse");


    // $(document).on("click", "#emp_search", function(e) {
    //     // alert('ok');
    //     var formID = $("#empfrmSearch").attr("id");

    //     var formMethod = $("#empfrmSearch").attr("method");

    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url: "{{ url('employee_search') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();

    //         },
    //         success: function(data) {
    //             $("#emp_info").html(data);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });




    $(document).ready(function() {
        // $('.data-table').DataTable();
        $('.select2').select2();
        // $('.data-table').DataTable();

        var imgUrl = '{{ URL::asset('images/uploads/doctor_images') }}';
        var defaultImgUrl = '{{ URL::asset('images') }}';
        ') }}';
        var docImgName = "doc-1.png";
        var nurseImgName = "nurse-2.png";

        var datatable = $('#datatable').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('get-employee-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        if (row[1] != null) {
                            return '<img style="width:50px" src="' + imgUrl + "/" +
                                row[1] + '" >';
                        } else {
                            if (row[6] == 'Male') {
                                // return '<img src="../public/images/doc-1.png" width="50" >';

                                return '<img style="width:50px" src="' + defaultImgUrl + "/" +
                                    docImgName + '" >';
                            } else {
                                return '<img style="width:50px" src="' + defaultImgUrl + "/" +
                                    nurseImgName + '" >';
                            }
                        }
                    }
                },

                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const mobile_no = row[10];
                        if (mobile_no !== null) {
                            const mobileNumbers = mobile_no.split(",");
                            var mobile = '';
                            mobileNumbers.forEach(function(number) {
                                mobile += number + '<br>';
                            });
                            return `${mobile}`;
                        } else {
                            return '';
                        }
                    }
                },

                 // {
                //     "targets": 9,
                //     "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var phone = row[9] != null ? "<br> Phone : " + row[9] : "";
                //         var email = row[10] != null ? "<br> Email : " + row[10] : "";

                //         return phone + '<br>' + email;
                //     }
                // },
                // {
                //     "targets": 10,
                //     // "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var address = row[11] != null ? row[11] : "";
                //         return address;
                //     }
                // },
                // {
                //     "targets": 3,
                //     // "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var card_no = row[14] != null ? row[14] : "";
                //         return card_no;
                //     }
                // },
                {
                    "targets": -2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        if (row[13] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";

                        } else {

                            if (row[15] == 4) {
                                return "<span class='btn btn-sm btn-danger'>Resigned </span>";
                            }else if(row[15] == 5){
                                return "<span class='btn btn-sm btn-danger'>Dismissed</span>";
                            }else{
                                return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                            }

                        }

                    }
                },
                {

                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var doctor_schedule = '{{ route('doctor-schedule', ':id') }}';
                        doctor_schedule = doctor_schedule.replace(':id', row[14]);

                        var show_action = '{{ route('doctor.show', ':id') }}';
                        show_action = show_action.replace(':id', row[14]);

                        var edit_action = '{{ route('doctor.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[14]);

                        var card_action = '{{ route('referral-card-print', ':id') }}';
                        card_action = card_action.replace(':id', row[14]);

                        var doctor_fee_setup = '{{ route('doctor-fee-setup', ':id') }}';
                        doctor_fee_setup = doctor_fee_setup.replace(':id', row[14]);

                        var promotion_history = '{{ route('promotion-history', ':id') }}';
                        promotion_history = promotion_history.replace(':id', row[14]);

                        var increment_history = '{{ route('increment-history', ':id') }}';
                        increment_history = increment_history.replace(':id', row[14]);

                        return '<span Class="btn btn-sm open-modal" style="background-color: #770CCB"  data-id="' +
                            row[14] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Employee Information" title="View Employee Information"><i class="fa fa-eye text-white"></i></span>&nbsp;<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
                            '" data-modal="common-modal" data-title="Edit Employee Information" title="Edit Employee Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<a  data-id="' +
                            row[14] + '" href="' + card_action +
                            '"  target="_blank" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></a>&nbsp;<span Class="btn btn-sm open-modal" style="background-color: rgb(249, 72, 125)" data-id="' +
                            row[14] + '" data-action="' + doctor_schedule +
                            '" data-modal="common-modal" data-title="Create Schedule" title="Create Schedule"><i class="fa fa-calendar-plus text-white"></i></span>&nbsp;<span  Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Billing Setup" data-modal="common-modal-sm" data-title="Employee Fee" data-action="' +
                            doctor_fee_setup +
                            '"><i class="fa fa-money-bill text-white"></i></span>&nbsp;<span Class="btn btn-sm open-modal mt-2" style="background-color: #0c7fcb"  data-id="' +
                            row[14] + '" data-action="' + promotion_history +
                            '" data-modal="common-modal" data-title="Promotion History" title="View Promotion History"><i class="fa fa-eye text-success"></i></span>&nbsp;<span Class="btn btn-sm open-modal mt-2" style="background-color: #0c7fcb"  data-id="' +
                            row[14] + '" data-action="' + increment_history +
                            '" data-modal="common-modal" data-title="Increment History" title="View Increment History"><i class="fa fa-eye text-info"></i></span>';
                    }
                }
            ]
        });


    });




    // search

    $(document).on('click', '#emp_search', function() {
        var formID = $("#empfrmSearch").attr("id");
        var formMethod = $("#empfrmSearch").attr("method");
        var imgUrl = '{{ URL::asset('images/uploads/doctor_images') }}';
        var docImgName = "doc-1.png";
        var nurseImgName = "nurse-2.png";
        var defaultImgUrl = '{{ URL::asset('images') }}';
        //alert($('input[name="emp_id"]').val())
        $('#datatable').empty();
        $('#datatable').DataTable().destroy();
        $('#datatable').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ url('employee_search') }}",
                "dataType": "json",
                "type": "POST",

                data: {
                    emp_id: $('input[name="emp_id"]').val(),
                    service_unit: $('#service_unit').val(),
                    hr_type: $('#hr_type').val(),
                    job_type: $('#job_type').val(),
                    roster_type: $('#roster_type').val(),
                    status: $('#status').val(),
                    emp_ind: $('#emp_ind').is(':checked') ? $('#emp_ind').val() : '',
                    doc_ind: $('#doc_ind').is(':checked') ? $('#doc_ind').val() : '',
                    ref_ind: $('#ref_ind').is(':checked') ? $('#ref_ind').val() : '',
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        // if (row[1] != null) {
                        //     return '<img src="../public/images/uploads/doctor_images/thumb/' +
                        //         row[1] + '" >';
                        // } else {
                        //     if (row[5] == 'Male') {
                        //         return '<img src="../public/images/doc-1.png" width="50" >';
                        //     } else {
                        //         return '<img src="../public/images/nurse-2.png" width="50" >';
                        //     }
                        // }

                        if (row[1] != null) {
                            return '<img style="width:50px" src="' + imgUrl + "/" +
                                row[1] + '" >';
                        } else {
                            if (row[6] == 'Male') {
                                // return '<img src="../public/images/doc-1.png" width="50" >';

                                return '<img style="width:50px" src="' + defaultImgUrl + "/" +
                                    docImgName + '" >';
                            } else {
                                return '<img style="width:50px" src="' + defaultImgUrl + "/" +
                                    nurseImgName + '" >';
                            }
                        }
                    }
                },
                // {
                //     "targets": 9,
                //     "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var phone = row[9] != null ? "<br> Phone : " + row[9] : "";
                //         var email = row[10] != null ? "<br> Email : " + row[10] : "";

                //         return phone + '<br>' + email;
                //     }
                // },
                // {
                //     "targets": 10,
                //     // "data": "Edit",
                //     "render": function(data, type, row, meta) {
                //         var address = row[11] != null ? row[11] : "";
                //         return address;
                //     }
                // },

                {
                    "targets": -2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[13] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";

                        } else {

                            if (row[15] == 4) {
                                return "<span class='btn btn-sm btn-danger'>Resigned </span>";
                            }else if(row[15] == 5){
                                return "<span class='btn btn-sm btn-danger'>Dismissed</span>";
                            }else{
                                return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                            }

                        }
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var doctor_schedule = '{{ route('doctor-schedule', ':id') }}';
                        doctor_schedule = doctor_schedule.replace(':id', row[14]);

                        var show_action = '{{ route('doctor.show', ':id') }}';
                        show_action = show_action.replace(':id', row[14]);

                        var edit_action = '{{ route('doctor.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[14]);

                        var doctor_fee_setup = '{{ route('doctor-fee-setup', ':id') }}';
                        doctor_fee_setup = doctor_fee_setup.replace(':id', row[14]);

                        var promotion_history = '{{ route('promotion-history', ':id') }}';
                        promotion_history = promotion_history.replace(':id', row[14]);

                        var increment_history = '{{ route('increment-history', ':id') }}';
                        increment_history = increment_history.replace(':id', row[14]);

                        return '<span Class="btn btn-sm open-modal" style="background-color: #770CCB"  data-id="' +
                            row[14] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Employee Information" title="View Employee Information"><i class="fa fa-eye text-white"></i></span>&nbsp;<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
                            '" data-modal="common-modal" data-title="Edit Employee Information" title="Edit Employee Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  data-id="' +
                            row[14] +
                            '" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></span>&nbsp;<span Class="btn btn-sm open-modal" style="background-color: rgb(249, 72, 125)" data-id="' +
                            row[14] + '" data-action="' + doctor_schedule +
                            '" data-modal="common-modal" data-title="Create Schedule" title="Create Schedule"><i class="fa fa-calendar-plus text-white"></i></span>&nbsp;<span  Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Billing Setup" data-modal="common-modal-sm" data-title="Employee Fee" data-action="' +
                            doctor_fee_setup +
                            '"><i class="fa fa-money-bill text-white"></i></span>&nbsp;<span Class="btn btn-sm open-modal mt-2" style="background-color: #0c7fcb"  data-id="' +
                            row[14] + '" data-action="' + promotion_history +
                            '" data-modal="common-modal" data-title="View Promotion History" title="View Promotion History"><i class="fa fa-eye text-yellow"></i></span>&nbsp;<span Class="btn btn-sm open-modal mt-2" style="background-color: #0c7fcb"  data-id="' +
                            row[14] + '" data-action="' + increment_history +
                            '" data-modal="common-modal" data-title="Increment History" title="View Increment History"><i class="fa fa-eye text-yellow"></i></span>';
                    }
                }
            ]

        });
    });

    function exportPDF(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#empfrmSearch").submit();
    }

    function exportPDFIPD(element) {
        $("#hdn_report_type").val("PDF");
        $("#empfrmSearch").submit();
    }
</script>
