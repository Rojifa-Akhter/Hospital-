<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">User</h5>
                <small>Settings / User Setup / User List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Registered User List <button class="btn btn-sm btn-primary float-right open-modal"
                        data-modal="common-modal" data-action="{{ route('user.create_form') }}"
                        data-title="Create New Lookup">Create New User</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table class="table data-table table-bordered table-hover table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">#SL</th>
                                    <th class="text-left" scope="col">Username</th>
                                    <th class="text-center" scope="col">Code</th>
                                    <th class="text-center" scope="col">Full Name</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Action</th>
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

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('.data-table').DataTable();

        var datatable = $('.data-table').DataTable({
            "processing": "<i class='fas fa-stroopwafel fa-spin'></i>",
            "serverSide": true,
            "order": [
                [1, "asc"]
            ],
            "ajax": {
                "url": "{{ url('/user-list') }}",
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

                        var edit_action = '{{ route('user.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[6]);

                        return '<span href="#" Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[6] + '" data-action="' + edit_action +
                            '" data-modal="common-modal" data-title="Edit User Information" title="Edit User Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span href="#" data-id="' +
                            row[5] +
                            '" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></span>';
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[5] == 1) {
                            return "<span class='btn btn-sm btn-success align-middle'>Active </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger align-middle'>Inactive </span>";
                        }
                    }
                },
            ]
        });

    });
</script>

{{-- <script> --}}
{{-- $(document).ready(function () { --}}
{{-- //$('#datatable').DataTable(); --}}
{{-- var datatable = $('.data-table').DataTable({ --}}
{{-- "ordering": false, --}}
{{-- "language": { --}}
{{-- "infoFiltered": "" --}}
{{-- }, --}}
{{-- "processing": true, --}}
{{-- "serverSide": true, --}}
{{-- "ajax": { --}}
{{-- "url": "{{ url('/user-list') }}", --}}
{{-- "dataType": "json", --}}
{{-- "type": "POST", --}}
{{-- "data": {_token: "{{csrf_token()}}"} --}}
{{-- }, --}}
{{-- "columnDefs": [{ --}}
{{-- "targets": -1, --}}
{{-- "data": "Edit", --}}
{{-- "render": function (data, type, row, meta) { --}}
{{-- var edit_action = '{{ route("user.edit", ":id") }}'; --}}
{{-- edit_action = edit_action.replace(':id', row[6]); --}}
{{-- //alert(edit_action); --}}
{{-- return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[6] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Suppliers" title="Edit"><i class="fa fa-pencil-alt"></i></span>'; --}}
{{-- } --}}
{{-- }] --}}
{{-- }); --}}
{{-- }); --}}
{{-- </script> --}}
