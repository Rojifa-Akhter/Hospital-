<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-12">
			<div class="float-left">
				<h5 class="mt-2 mb-0">Bank Service Charge List</h5>
				<small>Settings / Card Service / Bank Service Charge List</small>
			</div>
			<div id="top-action"></div>
		</div>
	</div>
	@include('admin.settings.card_service.create_bank_wise_card_service_form')
	<div class="card">
		<div class="card-body p-2">
			<div class="row">
				<div class="col-md-12 table-responsive">
					<table  class="table table-bordered table-hover table-striped mb-0 data-table">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">Sl#</th>
								<th class="text-center">Code</th>
								<th class="text-center">Bank</th>
								<th class="text-center">Card Type</th>
								<th class="text-center">Service Charge</th>
								<th class="text-center">Action</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	{{--$(document).ready(function () {--}}
	{{--	var datatable = $('.data-table').DataTable({--}}
	{{--		// "ordering": false,--}}

    {{--        "processing": "<i class='fas fa-stroopwafel fa-spin'></i>",--}}
    {{--        "serverSide": true,--}}
    {{--        "order": [[ 1, "asc" ]],--}}
	{{--		"ajax":{--}}
	{{--			"url": "{{ url('bank-wise-service-charge-all-data') }}",--}}
	{{--			"dataType": "json",--}}
	{{--			"type": "POST",--}}
	{{--			"data":{ _token: "{{csrf_token()}}"}--}}
	{{--		},--}}
	{{--		"columnDefs": [{--}}
	{{--			"targets": -1,--}}
	{{--			"data": "Edit",--}}
	{{--			"render": function ( data, type, row, meta ) {--}}

	{{--				var edit_action = '{{ route("service-charge-edit", ":id") }}';--}}
	{{--				edit_action = edit_action.replace(':id', row[5]);--}}

	{{--				return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[5] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Bank Service Charge" title="Edit"><i class="fa fa-pencil-alt"></i></span>';--}}
	{{--			}--}}
	{{--		}]--}}
	{{--	});--}}
	{{--});--}}
    $(document).ready(function () {
        // $('.data-table').DataTable();

        var datatable = $('.data-table').DataTable({
            "processing": "<i class='fas fa-stroopwafel fa-spin'></i>",
            "serverSide": true,
            "order": [[ 1, "asc" ]],
            "ajax":{
                "url": "{{ url('bank-wise-service-charge-all-data') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function ( data, type, row, meta ) {

                    var edit_action = '{{ route("service-charge-edit", ":id") }}';
                    edit_action = edit_action.replace(':id', row[5]);

                    return '<span href="#" Class="btn btn-sm btn-primary open-modal" data-id="'+ row[5] +'" data-action="'+edit_action+'" data-modal="common-modal" data-title="Edit Bank Service Charge Information" title="Edit User Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;';
                }
            }]
        });

    });
</script>
