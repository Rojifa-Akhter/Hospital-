<style>
    .accordion_title {
        position: relative;
    }

    .accordion_title i {
        position: absolute;
        top: 50%;
        right: 2%;
        transform: translateY(-50%);
        font-size: 18px;
        transition: all 0.3s;
    }
</style>


<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="add_doctor">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Referral / Agent Registration</h5>
				<small>hrm/referral / create referral </small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Registration Form</h5></div>
			<div class="card-body">
				@include('admin.hrm.referral.create_referral_form')
			</div>
		</div>
	</div>
</section>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>








</script>

