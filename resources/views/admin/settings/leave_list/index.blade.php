<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Leave Entry Work List</h5>
                <small>Settings / Leave Entry/ Work List</small>
            </div>
        </div>
    </div>
    {{-- Search Panel Start --}}
   <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="search_dep_form_admin" method="post" action="" target="_blank">
                    @csrf
                    <div class="d-flex align-items-center mb-2" >
                                <div class="col-md-4">
                                    <label for="" class="col-form-label col-form-label-sm">Department</label>
                                    <select name="dep_name_admin" id="dep_name_admin" class="select2">
                                        <option value="">Select Department</option>
                                        @foreach ($dep as $d)
                                            <option value="{{ $d->serviceunit_no_pk }}">{{ $d->serviceunit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-md-2">
                                    <label for="" class="col-form-label col-form-label-sm">From
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_from"
                                        name="date_from" value="{{date('d-m-Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="focus_input"></span>
                                </div>

                                <div class=" col-md-2">
                                    <label for="" class="col-form-label col-form-label-sm">To
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_to"
                                        name="date_to" value="{{date('d-m-Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="focus_input"></span>
                                </div>
                        <div>
                            <button type="button" id="search_dep_admin" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
    {{-- Search Panel end --}}
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th style="width: 180px" class="text-center">Emp.Name</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Designation </th>
                                    <th class="text-center">Leave Reason</th>
                                    <th class="text-center">Days From</th>
                                    <th class="text-center">Days To</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Leave Request</th>
                                    <th class="text-center">Available Leave</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width:15%">Approval </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>

<script>
     $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });
    $(function() {
        $('.date_picker2').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });
    $(document).ready(function() {
                $('body').on('click', '#search_dep_admin', function() {

                    $(".data-table").dataTable().fnDestroy()
                    var i = 1;
                    var datatable = $('.data-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "order": [
                            [0, "desc"]
                        ],
                        "ajax": {
                            "url": "{{ route('leavelist.search') }}",
                            "dataType": "json",
                            "type": "POST",
                            "data": {
                                _token: "{{ csrf_token() }}",
                                dep_name:$('#dep_name_admin').val(),
                                date_from:$('#date_from').val(),
                                date_to:$('#date_to').val(),
                            }
                        },
                        "pageLength": 25,
                        "aLengthMenu": [
                            [25, 50, 70, 100, -1],
                            [25, 50, 70, 100, "All"]
                        ],
                        "columnDefs": [{
                                "targets": -1,
                                "data": "Edit",
                                "className": "text-left",
                                "render": function(data, type, row, meta) {

                                    var edit_dep =
                                        '{{ route('leavelist.create.dep', [':id', 'leavelist']) }}';
                                    edit_dep = edit_dep.replace(':id', row[0]);

                                    var edit_hr =
                                        '{{ route('leavelist.create.hr', [':id', 'leavelist']) }}';
                                    edit_hr = edit_hr.replace(':id', row[0]);

                                    var edit_emp =
                                    '{{ route('leavelist.view.emp', ':id') }}';
                                    edit_emp = edit_emp.replace(':id', row[0]);

                                    var edit_emp_leave =
                                    '{{ route('leavelist.edit.emp', ':id') }}';
                                    edit_emp_leave = edit_emp_leave.replace(':id', row[0]);

                                    if (row[10] == null) {
                                        var approveByDep =
                                            '<button Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] + '" data-action="' + edit_dep +
                                            '" data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By Dep.</button>';
                                        var approveByHr =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal"  title="Approved">Approve By HR &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                    } else if (row[10] == '2') {
                                        var approveByDep =
                                            '<button disabled Class="btn btn-sm btn-danger open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Rejected">Rejected By Dep.</button>';
                                        var approveByHr =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By HR &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                    } else if (row[10] == '1') {
                                        var approveByDep =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By Dep.</button>';

                                        if (row[11] == null) {
                                            var approveByHr =
                                                '<button  Class="btn btn-sm btn-primary open-modal" data-id="' +
                                                row[0] + '" data-action="' + edit_hr +
                                                '" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Approve By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        } else if (row[11] == "1") {
                                            var approveByHr =
                                                '<button disabled Class="btn btn-sm btn-primary" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Approve By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        } else if (row[11] == "2") {
                                            var approveByHr =
                                                '<button disabled Class="btn btn-sm btn-danger" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Rejected By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        }
                                    }

                                    var viewform =
                                        '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                                        row[0] + '" data-action="' + edit_emp +
                                        '" data-modal="common-modal-xl" data-title="Employee Leave Information" title="Employee Leave Information"><i class="fa fa-eye"></i></button>';
                                    var editForm =
                                        '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                                        row[0] + '" data-action="' + edit_emp_leave +
                                        '" data-modal="common-modal-md" data-title="Edit Employee Leave" title="Edit Employee Leave "><i class="fa fa-edit"></i></button>';

                                    return ` ${approveByDep} ${approveByHr} ${viewform}  ${editForm}`;
                                }
                            },
                            {
                                "targets": 2,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[2]);



                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 5,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[5]);



                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 6,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[6]);
                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 10,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {

                                    if (row[11] == null && row[10] == null) {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    } else if (row[10] == '2') {
                                        var approved =
                                            '<span class="btn-danger btn-sm">Rejected</span>';
                                    } else if (row[11] == '2') {
                                        var approved =
                                            '<span class="btn-danger btn-sm">Rejected</span>';
                                    } else if (row[11] == '1') {
                                        var approved =
                                            '<span class="btn-success btn-sm">Approved</span>';
                                    } else if (row[10] == null) {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    } else if (row[10] == '1') {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    }

                                    return `${approved}`;

                                }

                            },
                            {
                                "targets": 0,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[0]);

                                    return `${i++}`;

                                }
                            },
                        ]
                    });

                });
                });
</script>


<script>
    $(document).ready(function() {
                    var i = 1;
                    var datatable = $('.data-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "order": [
                            [0, "desc"]
                        ],
                        "ajax": {
                            "url": "{{ route('current.leavelist') }}",
                            "dataType": "json",
                            "type": "POST",
                            "data": {
                                _token: "{{ csrf_token() }}",
                            }
                        },
                        "pageLength": 25,
                        "aLengthMenu": [
                            [25, 50, 70, 100, -1],
                            [25, 50, 70, 100, "All"]
                        ],
                        "columnDefs": [{
                                "targets": -1,
                                "data": "Edit",
                                "className": "text-left",
                                "render": function(data, type, row, meta) {

                                    var edit_dep =
                                        '{{ route('leavelist.create.dep', [':id', 'leavelist']) }}';
                                    edit_dep = edit_dep.replace(':id', row[0]);

                                    var edit_hr =
                                        '{{ route('leavelist.create.hr', [':id', 'leavelist']) }}';
                                    edit_hr = edit_hr.replace(':id', row[0]);

                                    var edit_emp =
                                    '{{ route('leavelist.view.emp', ':id') }}';
                                    edit_emp = edit_emp.replace(':id', row[0]);
                                    var edit_emp_leave =
                                    '{{ route('leavelist.edit.emp', ':id') }}';
                                    edit_emp_leave = edit_emp_leave.replace(':id', row[0]);

                                    if (row[10] == null) {
                                        var approveByDep =
                                            '<button Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] + '" data-action="' + edit_dep +
                                            '" data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By Dep.</button>';
                                        var approveByHr =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal"  title="Approved">Approve By HR &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                    } else if (row[10] == '2') {
                                        var approveByDep =
                                            '<button disabled Class="btn btn-sm btn-danger open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Rejected">Rejected By Dep.</button>';
                                        var approveByHr =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By HR &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                    } else if (row[10] == '1') {
                                        var approveByDep =
                                            '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
                                            row[0] +
                                            '"  data-modal="common-modal-sm" data-title="Departmental Approval" title="Approved">Approve By Dep.</button>';

                                        if (row[11] == null) {
                                            var approveByHr =
                                                '<button  Class="btn btn-sm btn-primary open-modal" data-id="' +
                                                row[0] + '" data-action="' + edit_hr +
                                                '" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Approve By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        } else if (row[11] == "1") {
                                            var approveByHr =
                                                '<button disabled Class="btn btn-sm btn-primary" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Approve By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        } else if (row[11] == "2") {
                                            var approveByHr =
                                                '<button disabled Class="btn btn-sm btn-danger" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Rejected By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                        }
                                    }

                                    var viewform =
                                        '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                                        row[0] + '" data-action="' + edit_emp +
                                        '" data-modal="common-modal-xl" data-title="Employee Leave Information" title="Employee Leave Information"><i class="fa fa-eye"></i></button>';
                                    var editForm =
                                        '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                                        row[0] + '" data-action="' + edit_emp_leave +
                                        '" data-modal="common-modal-md" data-title="Edit Employee Leave" title="Edit Employee Leave "><i class="fa fa-edit"></i></button>';

                                    return ` ${approveByDep} ${approveByHr} ${viewform}  ${editForm}`;
                                }
                            },
                            {
                                "targets": 2,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[2]);



                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 5,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[5]);



                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 6,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[6]);
                                    return `${d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()}`;
                                }
                            },
                            {
                                "targets": 10,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {

                                    if (row[11] == null && row[10] == null) {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    } else if (row[10] == '2') {
                                        var approved =
                                            '<span class="btn-danger btn-sm">Rejected</span>';
                                    } else if (row[11] == '2') {
                                        var approved =
                                            '<span class="btn-danger btn-sm">Rejected</span>';
                                    } else if (row[11] == '1') {
                                        var approved =
                                            '<span class="btn-success btn-sm">Approved</span>';
                                    } else if (row[10] == null) {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    } else if (row[10] == '1') {
                                        var approved =
                                            '<span class="btn-warning btn-sm">Pending</span>';
                                    }

                                    return `${approved}`;

                                }

                            },
                            {
                                "targets": 0,
                                "data": "Edit",
                                "render": function(data, type, row, meta) {
                                    var d = new Date(row[0]);

                                    return `${i++}`;

                                }
                            },
                        ]
                    });


                });
</script>
