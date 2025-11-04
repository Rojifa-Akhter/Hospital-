<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<style>
	.select2-container {
		z-index: 99999!important;
	}
</style>
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Lookup item List</h5>
				<small>Settings / Lookup item Setup / Lookup item List</small>
			</div>
		</div>

		<div class="card">
			<div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
			<div class="card-body">
				<form action="" id="searchForm" method="post">
					@csrf
					<div class="form-row justify-content-center">
						<div class="col-md-4">
							<div class="form-group">
								<label for="lookup_no" class="col-sm-12 col-form-label col-form-label-sm">Lookup Uid</label>
								<div class="col-sm-12">
									<select class="form-control font_size_12 m-auto  required select2" id="lookup_no" name="lookup_no" required>
										<option selected="selected" value="" disabled>Select Lookup Uid</option>
										@if(!empty($lookup))
										@foreach ($lookup as $record)
										<option value="{{ $record->lookup_no_pk }}"  >{{ $record->lookup_name }}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="btn-group btn-block" role="group">
								<button type="button" id="lookup_search_btn"  class="btn btn-md btn-success btn-block mt-4">Search</button>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-header"><h5>Lookupdata List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('lookup.createlookupitem_form') }}" data-title="Create New Lookup">Create Lookupdata</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Lookupdata Uid</th>
									<!-- <th class="text-center" scope="col">Lookup Name</th> -->
									<th class="text-center" scope="col">Lookupdata Name</th>
									<th class="text-center" scope="col">Lookupdata Name (বাংলা)</th>
									<th class="text-center" scope="col">Lookupdata Desc</th>
									<th class="text-center" scope="col">Status</th>
									<th class="text-center width-150" scope="col">Actions</th>
								</tr>
							</thead>
							<tbody id="lookup_item_list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table').DataTable({
			"processing": true,
			"serverSide": true,
            "order": [[ 2, "asc" ]],
			"ajax":{
				"url": "{{ url('lookupitem-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("lookup.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("editlookupitem", ":id") }}';
					edit_action = edit_action.replace(':id', row[6]);
					// var delete_action = '{{ route("lookup.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[6] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Lookup" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
	{{--$(document).on("click", "#lookup_search_btn", function(e) {--}}
	{{--	var formID = $("#searchForm").attr("id");--}}
	{{--	var formMethod = $("#searchForm").attr("method");--}}
	{{--	$.ajax({--}}
	{{--		data: $('#' + formID).serialize(),--}}
	{{--		url:"{{ url('lookup-item-search') }}",--}}
	{{--		type: formMethod,--}}
	{{--		beforeSend: function() {--}}
	{{--			blockUI();--}}

	{{--		},--}}
	{{--		success: function(data) {--}}
	{{--			$("#lookup_item_list").html(data);--}}
	{{--		},--}}
	{{--		complete: function() {--}}
	{{--			$.unblockUI();--}}
	{{--		}--}}
	{{--	});--}}
	{{--});--}}
    // Searching
    $(document).on("click", "#lookup_search_btn", function(e) {
        console.log($('#lookup_no').val());
        $('.data-table').empty();
        $('.data-table').DataTable().destroy();
        $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('lookup-item-search') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    lookup_no: $('#lookup_no').val(),
                }
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {
                    var edit_action = '{{ route('editlookupitem', ':id') }}';
                    edit_action = edit_action.replace(':id', row[6]);
                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="' +
                        row[13] + '" data-action="' + edit_action +
                        '" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });


	$("#category_lookup").focus();
	$('.select2').select2();
</script>
