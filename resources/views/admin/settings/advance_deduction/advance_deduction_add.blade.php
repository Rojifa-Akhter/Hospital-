<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="create_grade">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Add Advance Deduction </h5>
                <small>Settings / Advance Deduction / Add Advance Deduction </small>
            </div>
        </div>
		<div class="card">
			<div class="card-header">
				<h5>Create Advance Deduction</h5>
			</div>
			<div class="card-body mt-2">
				<div class="row">
					<div class="col-md-12">

				@include("admin.settings.advance_deduction.advance_deduction_popUp")
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>




<script type="text/javascript">
	openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
</script>
