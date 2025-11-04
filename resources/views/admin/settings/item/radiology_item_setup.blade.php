
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">


<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Radiology Item Setup</h5>
			<small>Item Setup / Radiology Item Setup</small>
		</div>
		<div class="col-md-6">
			<div class="m-0 text-right" id="top-action">
				<a rel="tab"  href="{{route('item.radiology-item-setup')}}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Radiology Item Worklist</a>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-3"  id="radiology-item" >

				@include('admin.settings.item.radiology_item_form')

		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-header"><h5>Radiology Investigation item worklist</h5></div>
				<div class="card-body p-2" style="min-height: 395px;">
					<div class="row" >
						@include('admin.settings.item.radiology_item_setup_data')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
	// $(function() {
	// 	$('body').on('focus',".timepicker", function(){
	// 		$(this).timepicker({
	// 			showInputs: false,
	// 			showMeridian: false,
	// 			forma
 //    			// setTime: null
 //    		});
	// 	});
	// })

</script>
