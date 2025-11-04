<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Radiology Schedule List</h5>
                <small>Settings / Radiology Schedule Setup / Radiology Schedule List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Create New Radiology Schedule <button class="btn btn-sm btn-primary float-right open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('radiology-user-wise-room-schedule-form') }}"
                        data-title="Create Radiology Schedule">Create Radiology Schedule</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">User Name</th>
                                    <th class="text-center" scope="col">Department Name</th>
                                    <th class="text-center" scope="col">Room Name</th>
                                    <th class="text-center" scope="col">Start Time</th>
                                    <th class="text-center" scope="col">End Time</th>
                                    <th class="text-center" scope="col">Average Time</th>
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
    //             "url": "{{ url('radiology-user-wise-room-schedule-list') }}",
    //             "dataType": "json",
    //             "type": "POST",
    //             "data": {
    //                 _token: "{{ csrf_token() }}"
    //             }
    //         },
    //         "columnDefs": [{
    //                 "targets": -1,
    //                 "data": null, // Data is not directly mapped, it's used in render function
    //                 "render": function(data, type, row, meta) {
    //                     var edit_action =
    //                         '{{ route('radiology-editor-autocomplete-edit', ':id') }}';
    //                     edit_action = edit_action.replace(':id', row[4]);
    //                     return '<span class="btn btn-sm btn-primary open-modal" data-id="' +
    //                         row[4] + '" data-action="' + edit_action +
    //                         '" data-modal="common-modal-sm" data-title="Edit autocomplete" title="Edit">' +
    //                         '<i class="fa fa-pencil-alt"></i></span>';
    //                 }
    //             },
    //             {
    //                 "targets": 7,
    //                 "data": null,
    //                 "render": function(data, type, row, meta) {
    //                     if (row[7] == 1) {
    //                         return "<span class='btn btn-sm btn-success'>Yes </span>";
    //                     } else {
    //                         return "<span class='btn btn-sm btn-danger'>No </span>";
    //                     }
    //                 }
    //             }
    //         ]
    //     });
    // });


    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        var datatable = $('.data-table').DataTable({
            "ordering": true,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "order": [
                [4, "asc"]
            ],
            "serverSide": true,
            "lengthMenu": [50, 75, 100, 200, 300],
            "ajax": {
                "url": "{{ url('radiology-user-wise-room-schedule-list') }}",
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

                    var edit_action = '{{ route('radiology-user-wise-room-schedule-edit', ':id') }}';
                    edit_action = edit_action.replace(':id', row[8]);

                    return '<span class="btn btn-sm btn-primary open-modal" data-id="' +
                        row[8] + '" data-action="' + edit_action +
                        '" data-modal="common-modal-sm" data-title="Edit Bed" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }, ]
        });
    });
</script>
