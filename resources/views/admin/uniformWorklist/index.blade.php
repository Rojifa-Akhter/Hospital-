<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Uniform Worklist</h5>
                <small>Uniform / Uniform Worklist</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Uniform Worklist</h5>
                {{-- <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                    data-action="{{ route('uniformWorklist.create') }}" data-title="Create Uniform Worklist">Create Uniform Worklist
                </button> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center" width="5%">Card No.</th>
                                <th class="text-center">Full Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Last Allocate Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    <!-- Fetch Table Data -->
    getData();

    function getData() {
        $.ajax({
            url: "{{ route('uniformWorklist.getData') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if(response.data.length != 0) {
                    setTableData(response.data);
                }
                else {
                    emptyTable();
                }
            },
            error:function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    <!-- Set Table Data -->
    function setTableData(data) {
        // Destroy Datatable if exists
        if($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }

        $('.data_table tbody').empty();
        var rows = [];
        var table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 3, 4, 5, 6, 7, 8], className: 'text-center' },
                    { targets: [2], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });

        data.forEach(function(item, index) {
            let status = null;
            if(item.status == '1') status = '<span class="badge badge-success">Active</span>';
            else status = '<span class="badge badge-danger">Inactive</span>';

            let uniformAllocationRoute = "{{ route('uniformWorklist.allocate', ['id' => ':id', 'designation_id' => ':designation_id']) }}";
            uniformAllocationRoute = uniformAllocationRoute.replace(':id', item.person_no_pk);
            uniformAllocationRoute = uniformAllocationRoute.replace(':designation_id', item.designation_no_pk);

            const uniformAllocation = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="'+uniformAllocationRoute+'" data-modal="common-modal-md" data-title="Allocate Uniform" title="Allocate Uniform" data-id="'+item.person_no_pk+'"><i class="fas fa-edit"></i></span>';
            const allocationHistory = '<span class="btn btn-sm btn-warning btn-md-global open-modal btnView" data-action="{{ route('uniformWorklist.allocationHistory','')}}/'+item.person_no_pk+'" data-modal="common-modal-sm" data-title="Uniform Allocation History" title="Uniform Allocation History" data-id="'+item.person_no_pk+'"><i class="fas fa-history"></i></span>';

            const rowData = [
                ++index,
                item.person_code,
                item.full_name,
                item.department,
                item.designation_name,
                item.phone_mobile,
                item.email_personal,
                'N/A',
                status,
                uniformAllocation + ' ' + allocationHistory,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
            <tr>
                <td colspan="9" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>
