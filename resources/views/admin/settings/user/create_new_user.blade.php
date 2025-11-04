
<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/custom_datepicker.css') }}"> --}}

<section id="full_registration">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">User List</h5>
				<small>Settings / User item  Setup / User  item Type List</small>
            </div>
        </div>
		<div class="card">
			<div class="card-header"><h5>Create New User</h5></div>
			@include('admin.settings.user.create_new_user_form')
		</div>
	</div>
</section>
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
