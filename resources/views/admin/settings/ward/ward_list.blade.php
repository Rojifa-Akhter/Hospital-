<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Ward List</h5>
                    <small>Settings / Ward setup / Ward List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal  mt-2"
                        data-modal="common-modal-md" data-action="{{ route('ward.create_form_popup') }}"
                        data-title="Create New Ward"><i class="fa fa-plus"></i> Create New Ward</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Ward ID</th>
                                    <th class="text-center" scope="col">Ward Name</th>
                                    <th class="text-center" scope="col">Ward Type</th>
                                    <th class="text-center" scope="col">Category</th>
                                    <th class="text-center" scope="col">Service Unit</th>
                                    <th class="text-center" scope="col">Room</th>
                                    <th class="text-center" scope="col">CCU IND</th>
                                    <th class="text-center" scope="col">ICU IND</th>
                                    <th class="text-center" scope="col">NICU IND</th>
                                    <th class="text-center" scope="col">HDU IND</th>
                                    <th class="text-center" scope="col">Emergency IND</th>
                                    <th class="text-center" scope="col">VIP IND</th>
                                    <th class="text-center" scope="col">Status</th>


                                    <th class="text-center width-70" scope="col">Actions</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('ward/ward-setup-list') }}",
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

                        var edit_action = '{{ route('ward.edit-ward-setup', ':id') }}';
                        edit_action = edit_action.replace(':id', row[14]);

                        var delete_action = '{{ route('ward.delete-ward', ':id') }}';
                        delete_action = delete_action.replace(':id', row[14]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[14] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Ward" title="Edit"><i class="fa fa-pencil-alt"></i></span> <span  class="btn btn-sm btn-danger" id="' +
                            row[14] + '" data-action="' + delete_action +
                            '" data-title="Delete Ward" title="Delete" onclick="removeWards(this)"><i class="fa fa-trash"></i></span> ';
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
                            return "<span class='btn btn-sm btn-success'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>In Active </span>";
                        }
                    }
                },
            ]
        });



    });

    function removeWards(thisElement) {
        var formAction = $(thisElement).attr("data-action");
        var data = $(thisElement).attr("id");

        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                data: {
                    data: data
                },
                url: formAction,
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html(
                        "immuzation Data Deleted successfully");

                },
                complete: function() {
                    $(thisElement).parents("tr").remove();
                    $.unblockUI();
                }
            });

        }

        event.stopImmediatePropagation();
        return;
    }
</script>
