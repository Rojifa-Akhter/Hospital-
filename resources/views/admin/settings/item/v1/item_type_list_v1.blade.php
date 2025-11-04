<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_item_list">
	<div class="container-fluid">

        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Item Type List</h5>
                    <small>Settings / Item Type  Setup / Item Type List</small>
                </div>
                <div id="top-action">
{{--                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"--}}
{{--                            data-modal="common-modal-sm" data-action="{{ route('item-type-create-form') }}"--}}
{{--                            data-title="Create New Bed"><i class="fa fa-plus"></i> Create New Item Type</button>--}}
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2" data-modal="common-modal-sm" data-action="{{ route('item-type-create-form') }}" data-title="Create New Item Type">
                        <i class="fa fa-plus"></i> Create Item Type</button>
                </div>
            </div>
        </div>

{{--		<div class="row bg-white border-bottom sticky-top shadow-sm">--}}
{{--            <div class="col-md-12 mb-1">--}}
{{--                <h5 class="mt-2 mb-0">Item Type List</h5>--}}
{{--				<small>Settings / Item Type  Setup / Item Type List</small>--}}
{{--            </div>--}}
{{--            <div id="top-action">--}}
{{--                <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"--}}
{{--                        data-modal="common-modal-sm" data-action="{{ route('bed.create') }}"--}}
{{--                        data-title="Create New Bed"><i class="fa fa-plus"></i> Create New Bed</button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="{{ route('item.item_type_search') }}" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="item_type">Parent Item Type</label>
                                <select class="form-control form-control-sm select2" id="item_type" name="item_type">
                                    <option value="">Select Item Type</option>
                                    @if (!empty($item_type))
                                        @foreach ($item_type as $item_type)
                                            {{-- <option value="{{ $item_type->itemtype_no_pk }}">
                                                {{ $item_type->item_type_name }}</option> --}}
                                            <option value="{{ $item_type->item_type_name }}">
                                                    {{ $item_type->item_type_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="searchItemType" class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <a href="{{ route('item-type-v1') }}" class="btn btn-md btn-danger btn-block mt-4" rel="tab" title="Reset">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<div class="card">
			<div class="card-header "><h5>Item Type List</h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="dataTable" class="table table-bordered table-hover table-striped data_table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-center" scope="col">Parent Type</th>
	                                <th class="text-center" scope="col">Item Type Name</th>
	                                <th class="text-center" scope="col">Serial Number</th>
	                                <th class="text-center" scope="col">Default Discount</th>
	                                <th class="text-center" scope="col">Account Ledger</th>
	                                <th class="text-center" scope="col">Account Auto-Posting</th>
	                                <th class="text-center" scope="col">Parent Ledger</th>
	                                <th class="text-center" scope="col">Item Status</th>
	                                <th class="text-center" scope="col">Actions</th>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
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
    getItemTypeData();

    function getItemTypeData() {
        $.ajax({
            url: "{{ route('itemType.getData') }}",
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
                    { targets: [0, 3, 4, 9], className: 'text-center' },
                    { targets: [1, 2, 5, 6, 7, 8], className: 'text-left' }
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
            let rowData = [
                ++index,
                item.parent_type_name,
                item.item_name,
                item.sl_no,
                item.default_discount,
                item.acc_ledger_no_fk,
                item.acc_par_itemtype_no_fk,
                item.type_auto_con_flag,
                item.status,
                '<span class="btn btn-sm btn-primary open-modal" data-id="35885" data-action="{{ route('item-type-edit','')}}/'+item.itemtype_no_pk+'" data-modal="common-modal-sm" data-title="Edit Item Type" title="Edit"><i class="fa fa-pencil-alt"></i></span>',
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

    $('.select2').select2();

    // Search
    $(document).on("click", "#searchItemType", function(e) {
        $.ajax({
            url: "{{ route('itemType.filter') }}",
            method: "POST",
            "data": {
                item_type: $('#item_type').val(),
            },
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
    });
</script>
