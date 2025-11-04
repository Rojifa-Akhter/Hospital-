<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Auto Item Type List</h5>
                    <small>Settings / Auto Item Type Setup / Auto Item Type List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('auto-item-type.create_form') }}"
                        data-title="New Item Type"><i class="fa fa-plus"></i> New Item Type
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Auto Item Type List

                </h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Auto Item Type Code</th>
                                    <th class="text-center" scope="col">Parent Item Name</th>
                                    <th class="text-center" scope="col">Item Name</th>
                                    <th class="text-center" scope="col">UOM</th>
                                    <th class="text-center" scope="col">Item Quantity</th>
                                    <th class="text-center" scope="col">Free</th>
                                    <th class="text-center" scope="col">Discount Available</th>
                                    <th class="text-center" scope="col">Pkg Item</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center width-150" scope="col">Action</th>
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
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('auto-item-type/list') }}",
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

                        // var create_action = '{{ route('room.create') }}';
                        // create_action = create_action.replace(':id', row[0]);

                        var edit_action = '{{ route('edit-auto-item-type', ':id') }}';
                        edit_action = edit_action.replace(':id', row[10]);

                        // var delete_action = '{{ route('room.destroy', ':id') }}';
                        // delete_action = delete_action.replace(':id', row[0]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[10] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Item Type List" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    },

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
                }
                ,
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[9] == 1) {
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                        }
                    }
                },

            ]
        });
    });
</script>
