<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Attribute Default Value List</h5>
                    <small>Settings / Default Attribute setup / Attribute Default Value List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-md" data-action="{{ route('default-attribute.create') }}"
                        data-title="Create New Default Attribute"><i class="fa fa-plus"></i> Create New Default
                        Attribute</button>
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
                                    <th class="text-center" scope="col">Item Name</th>
                                    <th class="text-center" scope="col">Attribute Name</th>
                                    <th class="text-center" scope="col">Default Value</th>
                                    <th class="text-center" scope="col">Default</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="all_data">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "order": [
                [6, "asc"]
            ],
            "serverSide": true,
            "ajax": {
                "url": "{{ url('pathology/attribute-default-list') }}",
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

                        var edit_action = '{{ route('attribute-value.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[6]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[6] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Attribute Value" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                {
                    "targets": 4,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[4] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[5] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                }
            ]

        });
    });







    // $(document).ready(function() {
    //     var datatable = $('.data-table').DataTable({
    //         "ordering": false,
    //         "searching": true,
    //         "language": {
    //             "infoFiltered": ""
    //         },
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": {
    //             "url": "{{ url('pathology/attribute-default-list') }}",
    //             "dataType": "json",
    //             "type": "POST",
    //             "data": {
    //                 _token: "{{ csrf_token() }}"
    //             }
    //         },
    //         "columnDefs": [{
    //             "targets": -1,
    //             "data": "Edit",
    //             "render": function(data, type, row, meta) {

    //                 var edit_action = "{{ route('bed.edit-bed-setup', ':id') }}";
    //                 edit_action = edit_action.replace(':id', row[7]);

    //                 return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
    //                     row[7] + '" data-action="' + edit_action +
    //                     '" data-modal="common-modal-sm" data-title="Edit Bed" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
    //             }
    //         }]
    //     });
    // });


    // Searching
</script>
