






<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Holiday Entry List</h5>
				<small>Settings / Holiday Entry / Holiday Entry List</small>
			</div>
		</div>
		<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section id="create_grade">
		<div class="card">
			<div class="card-header">
				<h5>Create Holiday data</h5>
			</div>
			<div class="card-body mt-2">
				<div class="row">
					<div class="col-md-12">

							<div class="col-sm-12 col-lg-5 col-xl-12">

<!-- list -->
							@include('admin.settings.holiday_entry.holiday_entry_form')


							</div>
					</div>
				</div>
			</div>
		</div>
</section>





		<!-- list -->
		@include('admin.settings.holiday_entry.holiday_all_data_list')

	</div>
</section>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>


<script>
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        multidate: true,
        todayHighlight: true,
        clearBtn: true,
        autoClose:true
    });

</script>

