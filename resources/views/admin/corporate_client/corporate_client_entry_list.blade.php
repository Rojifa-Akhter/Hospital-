<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Corporate Client List</h5>
                    <small>Corporate Client / Corporate Client List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-md" data-action="{{ route('corporate.client-popup') }}"
                        data-title="Create New Client"><i class="fa fa-plus"></i> Create New Client
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="data-table" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">#Sl</th>
                                    <th class="text-center" scope="col" width="15%">Name</th>
                                    <th class="text-center" scope="col">Address</th>
                                    <th class="text-center" scope="col">Country</th>
                                    <th class="text-center" scope="col">City</th>
                                    <th class="text-center" scope="col">Phone</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" scope="col">Emp. Health Service</th>
                                    <th class="text-center" scope="col">Proposal Approved</th>
                                    <th class="text-center" scope="col">Post Bill</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center width-150" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        //$('#datatable').DataTable();
        // $("#sidebar-left").addClass("active");
        // $("#content").addClass("active");
        $("body").addClass("sidebar-collapse");

        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('corporate/client-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {
                        var name = row[2] != null ? "<strong>" + row[2] + "</strong>" : "";

                        if (row[1] != null) {
                            return '<img src="../../public/images/uploads/doctor_images/thumb/' +
                                row[1] + '" >' + name;
                        } else {
                            // if (row[5] == 'Male') {
                            return '<img src="../../public/images/doc-1.png" width="50" >' +
                                name;
                            // } else {
                            //     return '<img src="../public/images/nurse-2.png" width="50" >';
                            // }
                        }
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return ` ${row[3]}`;
                    }
                },
                {
                    "targets": 3,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return ` ${row[4]}`;
                    }
                },
                {
                    "targets": 4,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return ` ${row[5]}`;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return ` ${row[6]}`;
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return ` ${row[7]}`;
                    }
                },
                {
                    "targets": 7,
                    "render": function(data, type, row, meta) {

                        if (row[8] == 1) {
                            return "<span class='btn btn-sm btn-success'>Approved </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Proposal </span>";
                        }
                    }
                },
                {
                    "targets": 8,
                    "render": function(data, type, row, meta) {

                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Approved </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Proposal </span>";
                        }
                    }
                },
                {
                    "targets": 9,
                    "render": function(data, type, row, meta) {

                        if (row[10] == 1) {
                            return "<span class='btn btn-sm btn-success'>Approved </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Proposal </span>";
                        }
                    }
                },
                {
                    "targets": 10,
                    "render": function(data, type, row, meta) {

                        if (row[11] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var edit_action = '{{ route('corporate.client-entry-edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[12]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[12] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Client Information" title="Edit Client Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;';
                    }
                }
            ]
        });
    });
</script>
