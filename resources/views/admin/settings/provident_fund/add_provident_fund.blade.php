


<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="create_lookup">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">provident Fund</h5>
				<small>Settings / provident Fund  Setup / provident Fund  Add</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Create Lookup Item</h5></div>
			<div class="card-body mt-2">
				@include('admin.settings.provident_fund.add_provident_fund_form')
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        clearBtn: true
    });

</script>

