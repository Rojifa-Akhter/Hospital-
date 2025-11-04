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
                                            <option value="{{ $item_type->itemtype_no_pk }}">
                                                {{ $item_type->item_type_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="searchItemType"  class="btn btn-md btn-success btn-block mt-4">Search</button>

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
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
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
<script>
	$(document).ready(function () {
		// $('.data-table').DataTable();

		var datatable = $('.data-table').DataTable({
			"processing": true,
			"serverSide": true,
            "order": [[ 2, "asc" ]],
			"ajax":{
				"url": "{{ url('item-type-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {



					var edit_action = '{{ route("item-type-edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[9]);

					// var delete_action = '';

					//delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[9] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Item Type" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});

	// Searching


    $(document).on("click", "#searchItemType", function(e) {
        console.log($('#item_type').val());
        $('.data-table').empty();
        $('.data-table').DataTable().destroy();
        $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('item.item_type_search') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    item_type: $('#item_type').val(),
                }
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {
                    var edit_action = '{{ route('item-type-edit', ':id') }}';
                    edit_action = edit_action.replace(':id', row[9]);
                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                        row[9] + '" data-action="' + edit_action +
                        '" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });

    $('.select2').select2();


</script>
