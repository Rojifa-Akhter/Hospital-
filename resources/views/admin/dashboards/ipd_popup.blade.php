<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="form-row">
	<div class="col-md-6">
		<div class="total-sales text-center bg-flat-color-7 py-3">
			<p class="mb-2">Total Sale</p>
			<h4 class="mb-0">00.00.000</h4>
		</div>
	</div>
	<div class="col-md-6">
		<div class="total-collection text-center bg-flat-color-4 py-3">
			<p class="mb-2">Total Collection</p>
			<h4 class="mb-0">00.00.000</h4>
		</div>
	</div>
</div>

<div class="form-row mt-2 justify-content-center">
	<div class="col-12">
		<h6 class="py-1 px-2 bg-flat-color-12 d-block">Search Panel</h6>
	</div>
	<div class="col-md-5">
		<div class="input-group input-daterange">
			<div class="input-group-prepend">
				<div class="input-group-text">From</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_from" name="start" value="" placeholder="dd/mm/yyyy">
			<div class="input-group-prepend">
				<div class="input-group-text">To</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 date_picker" id="dashboard_date_to" name="end" value="" placeholder="dd/mm/yyyy">
		</div>
	</div>
</div>
<div class="form-row mt-2 justify-content-center">
	<div class="col-md-3">
		<div class="form-group m-0">
			<select class="form-control" id="doctor_wise_filter" name="doctor_wise_filter">
				<option value="">Select Doctor</option>
				<option value="">Doctor-1</option>
				<option value="">Doctor-2</option>
				<option value="">Doctor-3</option>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group m-0">
			<select class="form-control" id="department_wise_filter" name="department_wise_filter">
				<option value="">Select Department</option>
				<option value="">Department-1</option>
				<option value="">Department-2</option>
				<option value="">Department-3</option>
			</select>
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group m-0">
			<select class="form-control" id="investigation_wise_filter" name="investigation_wise_filter">
				<option value="">Select Investigation</option>
				<option value="">Investigation-1</option>
				<option value="">Investigation-2</option>
				<option value="">Investigation-3</option>
			</select>
		</div>
	</div>

	<div class="col-md-12">
		<table class="table table-bordered table-hover mb-0">
			<thead class="bg-flat-color-13">
				<tr>
					<th class="text-center">SL#</th>
					<th class="text-left">Date</th>
					<th class="text-left">Investigation</th>
					<th class="text-left">Doctor</th>
					<th class="text-left">Department</th>
					<th class="text-right">Sale Amount</th>
					<th class="text-center">Discount</th>
					<th class="text-right">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center">01</td>
					<td class="text-left">28/11/2020</td>
					<td class="text-left">backbone x-ray</td>
					<td class="text-left">Dr.Tajuddin Ahamed</td>
					<td class="text-left">Cardiology</td>
					<td class="text-right">1,200</td>
					<td class="text-center">10%</td>
					<td class="text-right">1,000</td>
				</tr>
				<tr>
					<td class="text-center">02</td>
					<td class="text-left">28/11/2020</td>
					<td class="text-left">backbone x-ray</td>
					<td class="text-left">Dr.Tajuddin Ahamed</td>
					<td class="text-left">Cardiology</td>
					<td class="text-right">1,200</td>
					<td class="text-center">10%</td>
					<td class="text-right">1,000</td>
				</tr>
				<tr>
					<td class="text-center">03</td>
					<td class="text-left">28/11/2020</td>
					<td class="text-left">backbone x-ray</td>
					<td class="text-left">Dr.Tajuddin Ahamed</td>
					<td class="text-left">Cardiology</td>
					<td class="text-right">1,200</td>
					<td class="text-center">10%</td>
					<td class="text-right">1,000</td>
				</tr>
				<tr>
					<td class="text-center">04</td>
					<td class="text-left">28/11/2020</td>
					<td class="text-left">backbone x-ray</td>
					<td class="text-left">Dr.Tajuddin Ahamed</td>
					<td class="text-left">Cardiology</td>
					<td class="text-right">1,200</td>
					<td class="text-center">10%</td>
					<td class="text-right">1,000</td>
				</tr>
				<tr>
					<td class="text-center">05</td>
					<td class="text-left">28/11/2020</td>
					<td class="text-left">backbone x-ray</td>
					<td class="text-left">Dr.Tajuddin Ahamed</td>
					<td class="text-left">Cardiology</td>
					<td class="text-right">1,200</td>
					<td class="text-center">10%</td>
					<td class="text-right">1,000</td>
				</tr>
			</tbody>

			<tfoot>
				<tr class="bg-flat-color-13">
					<th class="text-right" colspan="5">Total&nbsp;:</th>
					<th class="text-right">6,000</th>
					<th class="text-right">Total&nbsp;:</th>
					<th class="text-right">5,000</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	$('.input-daterange').datepicker({
		format: 'dd/mm/yyyy',
		// autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});
</script>