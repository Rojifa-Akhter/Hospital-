<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">leave List</h5>
                <small>Settings / leave Setup / leave List</small>
            </div>
        </div>

        <div class="card">
            {{-- <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div> --}}
            <div class="card-body pt-2">
                <div class="form-row justify-content-center">

                    <div class="col-sm-2">
                        <label for="leave_category"><b>Leave Category</b></label>
                        <select class="form-control form-control-sm" style="width: 200px;" id="leave_category"
                            value="" name="leave_category">

                            <option value="0">Select Leave Category</option>
                            @if (!empty($leave_category))
                                @foreach ($leave_category as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>leave List <button class="btn btn-sm btn-primary float-right open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('crete-pop-up-leave-setup') }}"
                        data-title="Create New Leave">Add
                        New leave</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl</th>
                                    <th class="text-left" scope="col">Leave Name</th>
                                    <th class="text-center" scope="col">Leave Days</th>
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
    $(document).ready(function() {
        // $('#datatable').DataTable();
        // var datatable = $('.data-table').DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     // "order": [[ 2, "asc" ]],
        //     "ajax": {
        //         "url": "{{ url('leave-setup-list') }}",
        //         "dataType": "json",
        //         "type": "POST",
        //         "data": {
        //             _token: "{{ csrf_token() }}"
        //         }
        //     },
        //     "columnDefs": [{
        //         "targets": -1,
        //         "data": "Edit",
        //         "render": function(data, type, row, meta) {

        //             // var create_action = '{{ route('lookup.create') }}';
        //             // create_action = create_action.replace(':id', row[0]);

        //             var edit_action = '{{ route('leave.edit-list', ':id') }}';
        //             edit_action = edit_action.replace(':id', row[4]);
        //             // var delete_action = '{{ route('lookup.destroy', ':id') }}';
        //             // delete_action = delete_action.replace(':id', row[0]);

        //             return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
        //                 row[5] + '" data-action="' + edit_action +
        //                 '" data-modal="common-modal-sm" data-title="Edit Leave Data" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
        //         }
        //     }]
        // });

    });

    
    $("#leave_category").on('change', function() {
            var category_id = $(this).val();

            // $('.data-table').empty()
            $('.data-table').DataTable().destroy();
            $('.data-table').DataTable({

                "processing": true,
                "serverSide": true,
                // "order": [[ 2, "asc" ]],
                "ajax": {
                    "url": "{{ url('leave-setup-list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        category_id: category_id,
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columnDefs": [{
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var edit_action = '{{ route('leave.edit-list', ':id') }}';
                        edit_action = edit_action.replace(':id', row[4]);
                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[5] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Grade Salary" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                }]
            });
        });
</script>
