<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Loan List</h5>
                    <small>Settings / Loan Setup / Loan List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                            data-modal="common-modal-sm"
                            data-action="{{ route('loan.create_form') }}" data-title="New Loan"><i
                            class="fa fa-plus"></i> New Loan
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Loan List

                </h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">

                                <tr>
                                <th class="text-center" scope="col">Sl#</th>
                                <th class="text-center" scope="col">Employee ID</th>
                                <th class="text-center" scope="col">Employee Name</th>
                                <th class="text-center" scope="col">Service Unit</th>
                                <th class="text-left" scope="col">Original Amount</th>
                                <th class="text-left" scope="col">Loan Amount</th>
                                <th class="text-center" scope="col"> Interest</th>
                                <th class="text-center" scope="col">No Of Installment</th>
                                <th class="text-center width-150" scope="col">Installment Amount</th>
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
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('loan-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function (data, type, row, meta) {

                    // var create_action = '{{ route("room.create") }}';
                    // create_action = create_action.replace(':id', row[0]);

                    var edit_action = '{{ route("loan.edit", ":id") }}';
                    edit_action = edit_action.replace(':id', row[9]);

                    // var delete_action = '{{ route("room.destroy", ":id") }}';
                    // delete_action = delete_action.replace(':id', row[0]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="' + row[9] + '" data-action="' + edit_action + '" data-modal="common-modal-sm" data-title="Edit Loan List" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script>
