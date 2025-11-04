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
                <h5 class="mt-2 mb-0">Uniform</h5>
                <small>Uniform / Uniform Policy Setup</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Uniform Policy Setup</h5>
                <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                    data-action="{{ route('uniform.create') }}" data-title="Create Uniform Policy Setup">Create Uniform Policy Setup
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL.</th>
                                {{-- <th class="text-center">Department</th> --}}
                                <th class="text-center">Designation</th>
                                <th class="text-center">Uniform</th>
                                <th class="text-center">Shoes</th>
                                <th class="text-center">Winter Uniform</th>
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
    // $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    <!-- Fetch Table Data -->
    getUniformSetupData();

    function getUniformSetupData() {
        $.ajax({
            url: "{{ route('uniform.getData') }}",
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

    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 2, 3, 4, 5, 6], className: 'text-center' },
                    { targets: [1], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });

    <!-- Set Table Data -->
    function setTableData(data) {
        $('.data_table tbody').empty();
        let rows = [];
        let table = $('#dataTable').DataTable();

        data.forEach(function(item, index) {
            let status = null;
            if(item.status == '1') status = '<span class="badge badge-success">Active</span>';
            else status = '<span class="badge badge-danger">Inactive</span>';

            let rowData = [
                ++index,
                // item.serviceunit_name,
                item.designation_name,
                item.uniform_ind == '1' ? 'Yes' : 'No',
                item.shoe_ind == '1' ? 'Yes' : 'No',
                item.winteruniform_ind == '1' ? 'Yes' : 'No',
                status,
                '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{ route('uniform.edit','')}}/'+item.uniformpolicy_no_pk+'" data-modal="common-modal-md" data-title="Edit Uniform Setup" title="Edit Uniform Setup" data-id="'+item.uniformpolicy_no_pk+'"><i class="fas fa-edit"></i></span>',
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
                <td colspan="7" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>
