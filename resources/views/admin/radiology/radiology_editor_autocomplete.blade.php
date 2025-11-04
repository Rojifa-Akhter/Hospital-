<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Radiology Autocomplete List</h5>
                <small>Settings / Radiology Autocomplete Setup / Radiology Autocomplete List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Create New Radiology Autocomplete <button class="btn btn-sm btn-primary float-right open-modal"
                        data-modal="common-modal-md" data-action="{{ route('radiology-editor-autocomplete-form') }}"
                        data-title="Create Radiology Autocomplete">Create Radiology Autocomplete</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Autocomplete Name</th>
                                    <th class="text-center" scope="col">Autocomplete Description</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center width-150" scope="col">Actions</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    // $(document).ready(function() {
    //     var datatable = $('.data-table').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "order": [
    //             [2, "asc"]
    //         ],
    //         "ajax": {
    //             "url": "{{ url('radiology-editor-autocomplete-list') }}",
    //             "dataType": "json",
    //             "type": "POST",
    //             "data": {
    //                 _token: "{{ csrf_token() }}"
    //             }
    //         },
    //         "columnDefs": [{
    //                 "targets": -1,
    //                 "data": null,      "render": function(data, type, row, meta) {
    //                     var edit_action =
    //                         '{{ route('radiology-editor-autocomplete-edit', ':id') }}';
    //                     edit_action = edit_action.replace(':id', row[4]);
    //                     return '<span class="btn btn-sm btn-primary open-modal" data-id="' +
    //                         row[4] + '" data-action="' + edit_action +
    //                         '" data-modal="common-modal-sm" data-title="Edit autocomplete" title="Edit">' +
    //                         '<i class="fa fa-pencil-alt"></i></span>';
    //                 }
    //             },
    // {
    //     "targets": 3,
    //     "data": null,
    //     "render": function(data, type, row, meta) {
    //         if (row[3] == 1) {
    //             return "<span class='btn btn-sm btn-success'>Yes </span>";
    //         } else {
    //             return "<span class='btn btn-sm btn-danger'>No </span>";
    //         }
    //     }
    // }
    //         ]
    //     });
    // });



    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('radiology-editor-autocomplete-list') }}",
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
                    var edit_action =
                        '{{ route('radiology-editor-autocomplete-edit', ':id') }}';
                    edit_action = edit_action.replace(':id', row[4]);

                    return `<a Class="btn btn-md btn-primary" data-id="' + row[11] + '" href="${edit_action}"  target="_blank" data-title="Edit Report Template" title="Edit"><i class="fa fa-pencil-alt"></i></a>
                   `;



                }
            }, {
                "targets": 3,
                "data": null,
                "render": function(data, type, row, meta) {
                    if (row[3] == 1) {
                        return "<span class='btn btn-sm btn-success'>Active </span>";
                    } else {
                        return "<span class='btn btn-sm btn-danger'>Inactive </span>";
                    }
                }
            }, ]
        });
    });
</script>
