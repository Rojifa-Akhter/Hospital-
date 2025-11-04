	<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datetimepicker.min.css') }}">
	
	<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Shift</h5>
                <small>Settings / Shift Setup / Shift Add</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Shift</h5></div>
            <div class="card-body mt-2">
                <div class="row">
                    @include('admin.settings.shift.create_shift_form')
                </div>
            </div>
        </div>
    </div>
</section>


	<!-- datepicker -->
	<script src="{{ asset('datepicker/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
		$(function () {
			$('.datepicker').datetimepicker({
				format: "yyyy-mm-dd HH:11 P",
				showMeridian: true,
				autoclose: true,
				todayBtn: true
			});
		})
	</script>