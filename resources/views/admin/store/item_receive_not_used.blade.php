<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-9">
			<h5 class="mt-2 mb-0">Item Receive</h5>
			<small>Store / Item Receive</small>
		</div>
		{{--<div class="col-md-3">
			<div id="top-action">
				<a  rel="tab" href="{{ route('new_item_receive') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-plus"></i>&nbsp;New Indent</a>

			</div>
		</div>--}}
	</div>
	<input type="hidden" id="tab_name" value="7">
	<div class="row mt-3">
		<div class="col-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active page-tab" id="received-by-challan-tab" data-toggle="tab" href="#received-by-challan" role="tab" aria-controls="received-by-challan" aria-selected="true">Received by Challan</a>
				</li>

				<li class="nav-item" role="presentation">
					<a class="nav-link page-tab" id="received-by-item-tab" data-toggle="tab" href="#received-by-item" role="tab" aria-controls="received-by-item" aria-selected="false">Received by Item</a>
				</li>
				<li class="ml-auto bg-none">
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="pending" name="deli_status" value="Pending">
						<label class="custom-control-label" for="pending">Pending</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="partial_received" name="deli_status" value="Partial Received">
						<label class="custom-control-label" for="partial_received">Partial Received</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="received" name="deli_status" value="Received">
						<label class="custom-control-label" for="received">Received</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="closed" name="deli_status" value="Closed">
						<label class="custom-control-label" for="closed">Closed</label>
					</div>
				</li>

				{{--<li class="nav-item" role="presentation">
					<a class="nav-link " id="indent-work-list-tab" data-toggle="tab" href="#indent-work-list" role="tab" aria-controls="indent-work-list" aria-selected="false">Indent Work List</a>
				</li>--}}
			</ul>

			<div class="tab-content" id="myTabContent">
				@include('admin.store.received_by_chalan')
				@include('admin.store.received_by_item')
				{{--@include('admin.store.indent_work_list')--}}


			</div>
		</div>
	</div>

</div>

	<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
	<script>
		$(document).ready(function () {
			$.fn.dataTable.ext.search.push(
					function( settings, searchData, index, rowData, counter ) {

						var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
							return this.value;
						}).get();


						if (offices.length === 0) {
							return true;
						}
						var tblindex = $('#tab_name').val()

						if (offices.indexOf(searchData[tblindex]) !== -1) {
							return true;
						}

						return false;
					}
			);

			var table = $('.datatable').DataTable({
				"ordering": false,
				"bPaginate": false,
				"bLengthChange": false,
				"bAutoWidth": false
			});


			$('input:checkbox').on('change', function () {
				table.draw();

			});
			$(document).on('click', '.page-tab', function (e) {
				e.preventDefault()

				if ($(this).attr('id') == 'received-by-challan-tab') {
					$('#tab_name').val(7)
				}
				if ($(this).attr('id') == 'received-by-item-tab') {
					$('#tab_name').val(8)
				}
				table.draw();
			})
			$('.date_picker').datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				todayHighlight: true,
				clearBtn: true,
			});
			$('.select2').select2({});
			$('.data-table').DataTable({});
		})

	</script>
