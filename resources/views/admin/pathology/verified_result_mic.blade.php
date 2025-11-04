<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-12">
			<h5 class="mt-2 mb-0">Result entry</h5>
			<small>Pathology / Result entry</small>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Pending Sample" aria-selected="true" href="{{ route('path.result-entry-mic') }}" rel="tab">Result Entry</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab" aria-controls="Collected Sample" aria-selected="false" href="{{ route('path.verified-results-mic') }}" rel="tab">Verified Results</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="pending-sample" role="tabpanel" aria-labelledby="received-by-challan-tab">
					<div class="row justify-content-center">
						<div class="col-md-12">
							@include('admin.pathology.result_entry_search_panel_mic')
						</div>
					</div>
					<div id="financial-list">
						@include('admin.pathology.result_entry_list_mic')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
     $('.select2').select2();
	openInvoiceAutocomplete("#prescription_id");
</script>
