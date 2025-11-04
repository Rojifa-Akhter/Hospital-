

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="create_grade">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">LookUp</h5>
				<small>Settings / Lookup  Setup / LookUp Add</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5>Create UOM Lookup</h5>
			</div>
			<div class="card-body mt-2">
				<div class="row">
					<div class="col-md-12">
				@include('admin.uhl.settings.lookup.create_uom_lookup_form')
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
