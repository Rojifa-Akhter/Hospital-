

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="create_grade">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">User Wise Radiology Room</h5>
				<small>Settings / User Wise Radiology Room Schedule Setup / User Wise Radiology Room Schedule Add</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5>User Wise Radiology Room Schedule</h5>
			</div>
			<div class="card-body mt-2">
				<div class="row">
					<div class="col-md-12">
				    @include('admin.radiology.userwiseroom.user_wise_room_form')
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

