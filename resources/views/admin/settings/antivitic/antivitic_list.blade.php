<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_antivitic_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Antivitic List</h5>
                <small>Settings / Antivitic Setup / Antivitic List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Antivitic List <button class="btn btn-sm btn-primary float-right open-modal"
                        data-modal="common-modal-sm" data-action="{{ route('pathology.antivitic-form') }}"
                        data-title="Create New Antivitic">Create Antivitic</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-left" scope="col">Antivitic Uid</th>
                                    <th class="text-left" scope="col">Antivitic Name</th>
                                    <th class="text-left" scope="col">Status</th>
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
            "order": [
                [2, "asc"]
            ],
            "ajax": {
                "url": "{{ url('pathology/antivitic-all-data') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 4,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var edit_action = '{{ route('pathology.antivitic-edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[4]);

                        return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[4] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-sm" data-title="Edit Antivitic" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                    }
                },
                {
                    "targets": 3,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[3] == 1) {
                            return "<span class='btn btn-sm btn-success'>Yes </span>";
                        } else {
                            return "<span class='btn btn-sm btn-danger'>No </span>";
                        }
                    }
                }
            ]
        });
    });
</script>
