<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">HR Wise Leave Application List</h5>
                <small>Settings / Leave Application List</small>
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
                <form id="search_dep_form_hr" method="post" action="" target="_blank">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="type" class="col-form-label col-form-label-sm">From Date</label>
                                        <input type="text" class="form-control date_picker" name="date_from"
                                            value="{{ date('d-m-Y') }}" id="date_from" placeholder="From Date" />
                                    </div>
                                </div>

                                    <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="type" class="col-form-label col-form-label-sm">To Date </label>
                                        <input type="text" class="form-control date_picker" name="date_to"
                                            value="{{ date('d-m-Y') }}" id="date_to" placeholder="To Date" />
                                    </div>
                                </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="type" class="col-form-label col-form-label-sm">Department </label>
                                        <select name="dep_name_hr" id="dep_name_hr" class="select2">
                                            <option value="">Select Department</option>
                                            @foreach ($hrDat as $d)
                                                <option value="{{ $d->serviceunit_no_pk }}">{{ $d->serviceunit_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="search_dep_hr" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                                </div>
                            </div>
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
                                    <th class="text-center">Assign To</th>
                                    <th class="text-center">Extra Duty On</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
<script type="text/javascript">
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $(".date_picker").attr("autocomplete", "off");
</script>
<script>
    $(document).ready(function() {
        $('body').on('click', '#search_dep_hr', function() {
            $(".data-table").dataTable().fnDestroy()
            var i = 1;
            var datatable = $('.data-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    "url": "{{ route('leavelist.search.hr') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        dep_name: $('#dep_name_hr').val(),
                        date_from: $('#date_from').val(),
                        date_to: $('#date_to').val(),
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
                                '{{ route('leavelist.create.dep', [':id', 'leavelisthr']) }}';
                            edit_dep = edit_dep.replace(':id', row[0]);

                            var edit_hr =
                                '{{ route('leavelist.create.hr', [':id', 'leavelisthr']) }}';
                            edit_hr = edit_hr.replace(':id', row[0]);

                            var edit_emp =
                                '{{ route('leavelist.view.emp', ':id') }}';
                            edit_emp = edit_emp.replace(':id', row[0]);
                            var cancel = '';
                            if (row[10] == null) {
                                var approveByDep =
                                    '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
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

                                    cancel =
                                        '<form action="{{ route('leavelist.hr.cancel') }}" method="POST" id="cancel_leave_form_search'+row[0]+'"> @csrf <input type="hidden" name="leave_no_fk" value="' +
                                        row[0] +
                                        '"><button  Class="btn btn-sm btn-danger" type="button" onclick="saveUpdateDataDep(this)" id="cancel_leave"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                                } else if (row[11] == "2") {
                                    var approveByHr =
                                        '<button disabled Class="btn btn-sm btn-danger" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Rejected By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                                }
                            }

                            var viewform =
                                '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                                row[0] + '" data-action="' + edit_emp +
                                '" data-modal="common-modal-xl" data-title="Employee Leave Information" title="Employee Leave Information"><i class="fa fa-eye" aria-hidden="true"></i></button>';


                            return ` ${approveByDep} ${approveByHr} ${viewform} ${"&nbsp;&nbsp;&nbsp;"} ${cancel}`;
                        }
                    },
                    {
                        "targets": 2,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var d = new Date(row[2]);



                            return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                        }
                    },
                    {
                        "targets": 5,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var d = new Date(row[5]);



                            return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                        }
                    },
                    {
                        "targets": 6,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var d = new Date(row[6]);
                            return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                        }
                    },
                    {
                        "targets": 9,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            return row[9];
                        }
                    },
                    {
                        "targets": 10,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var d = new Date(row[12]);
                            var dateFormated = '';
                            if (row[12] != null) {
                                dateFormated = d.getDate() + '/' + (d.getMonth() + 1) +
                                    '/' + d.getFullYear();
                            }
                            return `${dateFormated}`;
                        }
                    },
                    {
                        "targets": 11,
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
                            '{{ route('leavelist.create.dep', [':id', 'leavelisthr']) }}';
                        edit_dep = edit_dep.replace(':id', row[0]);

                        var edit_hr =
                            '{{ route('leavelist.create.hr', [':id', 'leavelisthr']) }}';
                        edit_hr = edit_hr.replace(':id', row[0]);

                        var edit_emp =
                            '{{ route('leavelist.view.emp', ':id') }}';
                        edit_emp = edit_emp.replace(':id', row[0]);
                        var cancel = '';
                        if (row[10] == null) {
                            var approveByDep =
                                '<button disabled Class="btn btn-sm btn-primary open-modal" data-id="' +
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

                                    cancel =
                                        '<form action="{{ route('leavelist.hr.cancel') }}" method="POST" id="cancel_leave_form_search'+row[0]+'"> @csrf <input type="hidden" name="leave_no_fk" value="' +
                                        row[0] +
                                        '"><button  Class="btn btn-sm btn-danger" type="button" onclick="saveUpdateDataDep(this)" id="cancel_leave"><i class="fa fa-times" aria-hidden="true"></i></button></form>';
                            } else if (row[11] == "2") {
                                var approveByHr =
                                    '<button disabled Class="btn btn-sm btn-danger" data-modal="common-modal-sm" data-title="Hr Approval" title="Approved">Rejected By HR  &nbsp;&nbsp;&nbsp;&nbsp;</button>';
                            }
                        }

                        var viewform =
                            '<button  Class="btn btn-sm btn-secondary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_emp +
                            '" data-modal="common-modal-xl" data-title="Employee Leave Information" title="Employee Leave Information"><i class="fa fa-eye" aria-hidden="true"></i></button>';


                        return ` ${approveByDep} ${approveByHr} ${viewform} ${"&nbsp;&nbsp;&nbsp;"} ${cancel}`;
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[2]);



                        return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[5]);



                        return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[6]);
                        return `${d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()}`;
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return row[9];
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[12]);
                        var dateFormated = '';
                        if (row[12] != null) {
                            dateFormated = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d
                                .getFullYear();
                        }
                        return `${dateFormated}`;
                    }
                },
                {
                    "targets": 11,
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

<script>
    function saveUpdateDataDep(element) {
        event.preventDefault();
        var formAction = $(element).parents("form").attr("action");
        var formID = $(element).parents("form").attr("id");
        var formData = new FormData($('#' + formID)[0]);
        var formMethod = $(element).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }
        if (confirm("Are you sure?")) {
            $.ajax({
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: (data) => {
                    $('#' + formID).find("input, textarea").not('.keep_me').val(
                        "");
                    $('#' + formID).find("select").not('.keep_me').val("0");
                    $('.modal').modal('hide');
                    $(".data-table").DataTable().ajax.reload(null, false);
                },
                error: function(data) {

                },
                complete: function() {
                    alert("Cancel Success");
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText)
                        .errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings(
                                "label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(
                        "Validation Error");
                    $('.common-modal-notify-error .modal-body').html(
                        error_messages);
                    finished = false;
                    $.unblockUI();
                }
            });
            // });

        }
    }
</script>
