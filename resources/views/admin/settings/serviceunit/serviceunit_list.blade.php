<style>
    .table>tbody>tr>td {
        vertical-align: middle;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">


        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Service Unit List</h5>
                    <small>Settings / Service Unit Setup / Service Unit List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-sm" data-action="{{ route('serviceunit.create_form') }}"
                        data-title="Create New Service Unit"><i class="fa fa-plus"></i> Create Service Unit</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Service Unit list</div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Service Unit ID</th>
                                    <th class="text-center" scope="col">Parent Service Unit</th>
                                    <th class="text-center" scope="col">Name</th>
                                    <th class="text-center" scope="col">Report Header</th>
                                    <th class="text-center" scope="col">Service Unit HoD</th>
                                    <th class="text-center" scope="col">Clinical</th>
                                    <th class="text-center" scope="col">Medicine Store</th>
                                    <th class="text-center" scope="col">Pharmacy Store</th>
                                    <th class="text-center" scope="col">Hospital Store</th>
                                    <th class="text-center" scope="col">LP Store</th>
                                    <th class="text-center" scope="col">Pathology</th>
                                    <th class="text-center" scope="col">Radiology</th>
                                    <th class="text-center" scope="col">IPD</th>
                                    <th class="text-center" scope="col">Dental</th>
                                    <th class="text-center" scope="col">Eye</th>
                                    <th class="text-center" scope="col">OT</th>
                                    <th class="text-center" scope="col">External Hospital</th>
                                    <th class="text-center" scope="col">Cash Counter</th>
                                    <th class="text-center" scope="col">Duty Area</th>
                                    <th class="text-center" scope="col">Physiotherapy</th>
                                    <th class="text-center" scope="col">Main Store</th>
                                    <th class="text-center" scope="col">Sub Store</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center " scope="col">Actions</th>
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
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "order": [
                [3, "asc"]
            ],
            "serverSide": true,

            "ajax": {
                "url": "{{ url('serviceunit-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        // var create_action = '{{ route('serviceunit.create') }}';
                        // create_action = create_action.replace(':id', row[0]);

                        var edit_action = '{{ route('serviceunit.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[24]);

                        // var delete_action = '{{ route('serviceunit.destroy', ':id') }}';
                        // delete_action = delete_action.replace(':id', row[0]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[22] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Service Unit" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[6] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[7] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[8] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[10] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 11,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[11] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 12,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[12] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 13,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[13] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 14,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[14] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 15,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[15] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 15,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[15] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 16,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[16] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 17,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[17] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 18,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[18] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 19,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[19] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },

                {
                    "targets": 20,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[20] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 21,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[21] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 22,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[22] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 23,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[23] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                }
            ]
        });
    });
</script>
