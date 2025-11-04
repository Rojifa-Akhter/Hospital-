<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Advance Deduction List</h5>
                    <small>Settings / Advance Deduction Setup / Advance Deduction List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('advance-deduction-popup') }}"
                        data-title="Create New Deduction">Add New Deduction</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Advance Deduction List </h5>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Name</th>
                                    <th class="text-center" scope="col">Transaction Type</th>
                                    <th class="text-center" scope="col">Year/Month</th>
                                    <th class="text-center" scope="col">Amount</th>
                                    <th class="text-center" scope="col">Remarks</th>
                                    <th class="text-center" scope="col">Date</th>
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

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('deduction.all-data') }}",
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

                    var edit_action = '{{ route("advance-deduction.edit-list", ":id") }}';


                    // var edit_action = "{{ route('advance-deduction.edit-list', ':id') }}";
                    edit_action = edit_action.replace(':id', row[7]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                        row[7] + '" data-action="' + edit_action +
                        '" data-modal="common-modal-sm" data-title="Edit Advance Deduction" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                },
                // "targets": 6,
                // "render": function(data, type, row, meta) {
                //     var date = new Date(row[6]);
                //     var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                //         .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                //     return updated_date;
                // },


            }]
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
    //             "url": "{{ route('deduction.all-data') }}",
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

    //                 var edit_action = "{{ route('advance-deduction.edit-list', ':id') }}";
    //                 edit_action = edit_action.replace(':id',  row[7]);

    //                 return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +

    //                 row[7] + '" data-action="' + edit_action +
    //                     '" data-modal="common-modal-sm" data-title="Edit Bed" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
    //             }

    //             ,
    //             "targets": 6,
    //             "render": function(data, type, row, meta) {
    //                 var date = new Date(row[6]);
    //                 var updated_date = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
    //                     .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
    //                 return updated_date;
    //             }
    //         }]
    //     });
    // });

</script>
