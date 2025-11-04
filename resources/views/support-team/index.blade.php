<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Support Team Work List</h5>
                <small>Settings / Supplier Setup / Supplier List</small>
            </div>
            <div id="top-action">
                <button class="btn btn-outline-primary btn-md float-right mt-2 open-modal" data-modal="common-modal-sm"
                    data-action="{{ route('support.team.tricket.create') }}" data-title="Create New Issue">Add New
                    Issue</button>
            </div>
        </div>
    </div>

    {{-- Search Panel Start --}}
    <div class="card">
        <div class="card-header">
            <h5><i class="fa fa-search"></i> Search Panel</h5>
        </div>
        <div class="card-body pt-2 bg-light">
            <form id="search_issue_form" method="post" action=""
                target="_blank">
                @csrf
                <div class="form-group row text-right">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 text-left" style="margin-right: -30px;">
                                <label for="type">From Date</label>
                                <input type="text" class="form-control date_picker" name="date_from" value="{{ date("d-m-Y") }}"
                                    id="date_from" placeholder="From Date" />
                            </div>
                            <div class="col-md-6 text-left ml-2">
                                <label for="type">To Date </label>
                                <input type="text" class="form-control date_picker" name="date_to" value="{{ date("d-m-Y") }}" id="date_to"
                                    placeholder="To Date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="button" id="search_issue"
                            class="btn btn-md btn-success mt-4">Search</button>
                        {{-- <button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print"> Export
                            PDF</button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Search Panel end --}}

    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">Sl. No.</th>
                                    <th class="text-center">Issue No.</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Issue Name</th>
                                    <th style="width: 10%" class="text-center">User Name</th>
                                    <th class="text-center">User Desc.</th>
                                    <th class="text-center">Issue Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Issue Document</th>
                                    <th class="text-center width-150">Actions</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        var i = 1;
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [1, "desc"]
            ],
            "ajax": {
                "url": "{{ url('support-team-ticket-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
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
                    "render": function(data, type, row, meta) {

                        // var create_action = '{{ route('lookup.create') }}';
                        // create_action = create_action.replace(':id', row[0]);

                        var edit_action = '{{ route('support.team.tricket.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[1]);
                        // var delete_action = '{{ route('lookup.destroy', ':id') }}';
                        // delete_action = delete_action.replace(':id', row[0]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[1] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Issue" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
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
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var imgF = row[8] != null ?
                            '<img src="{{ URL::to('/images/uploads/issue/file') }}/' + row[
                            8] +
                            '"  style="wimgFth: 70px;height:50px" class="img-thumbnail" />' :
                            '<img src="{{ URL::to('/images/uploads/issue/not_found.jpg') }}"  style="wimgFth: 70px;height:50px" class="img-thumbnail" />';
                        return `${imgF}`;
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
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var d = new Date(row[0]);

                        return `${i++}`;

                    }
                },
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var status = row[7] == 1 ?
                            '<span class="btn btn-primary btn-sm">Active</span>' :
                            '<span class="btn btn-warning btn-sm">Pending</span>';

                        return `${status}`;

                    }
                },
            ]
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('body').on('click', '#search_issue', function() {
            $(".data-table").dataTable().fnDestroy()
            var i = 1;
            var datatable2 = $('.data-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [1, "desc"]
                ],
                "ajax": {
                    "url": "{{ route('issue.search') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        form_date:$('#date_from').val(),
                        to_date:$('#date_to').val(),

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
                        "render": function(data, type, row, meta) {

                            // var create_action = '{{ route('lookup.create') }}';
                            // create_action = create_action.replace(':id', row[0]);

                            var edit_action =
                                '{{ route('support.team.tricket.edit', ':id') }}';
                            edit_action = edit_action.replace(':id', row[1]);
                            // var delete_action = '{{ route('lookup.destroy', ':id') }}';
                            // delete_action = delete_action.replace(':id', row[0]);

                            return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                                row[1] + '" data-action="' + edit_action +
                                '" data-modal="common-modal-sm" data-title="Edit Issue" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
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
                        "targets": 8,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var imgF = row[8] != null ?
                                '<img src="{{ URL::to('/images/uploads/issue/file') }}/' +
                                row[8] +
                                '"  style="wimgFth: 70px;height:50px" class="img-thumbnail" />' :
                                '<img src="{{ URL::to('/images/uploads/issue/not_found.jpg') }}"  style="wimgFth: 70px;height:50px" class="img-thumbnail" />';
                            return `${imgF}`;
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
                        "targets": 0,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var d = new Date(row[0]);

                            return `${i++}`;

                        }
                    },
                    {
                        "targets": 7,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var status = row[7] == 1 ?
                                '<span class="btn btn-primary btn-sm">Active</span>' :
                                '<span class="btn btn-warning btn-sm">Pending</span>';

                            return `${status}`;

                        }
                    },
                ]
            });
        });
    });
</script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $(".date_picker").attr("autocomplete", "off");
</script>
