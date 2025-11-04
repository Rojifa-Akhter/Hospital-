

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="create_grade">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Item Wise Radiology Room</h5>
				<small>Settings / Item Wise Radiology Room Schedule Setup / Item Wise Radiology Room Schedule Add</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5>Item Wise Radiology Room Schedule</h5>
			</div>
			<div class="card-body mt-2">
				<div class="row">
					<div class="col-md-12">
				    @include('admin.radiology_v2.setup.item_wise_room_form')
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

