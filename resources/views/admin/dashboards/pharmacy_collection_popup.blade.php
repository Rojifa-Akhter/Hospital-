<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="form-row">
	<div class="col-md-6">
		<div class="form-row">
			<div class="col-md-12 text-center">
				<h5 class="m-0 text-white bg-flat-color-5 mb-2 py-1">Indoor Pharmacy</h5>
			</div>
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
			<div class="col-md-7">
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

			<div class="col-md-5">
				<div class="form-group m-0">
					<select class="form-control" id="salesman_wise_filter" name="salesman_wise_filter">
						<option value="">Select Salesman</option>
						<option value="">salesman-1</option>
						<option value="">salesman-2</option>
						<option value="">salesman-3</option>
					</select>
				</div>
			</div>

			<div class="col-md-12">
				<table class="table table-bordered table-hover mb-0">
					<thead class="bg-flat-color-13">
						<tr>
							<th class="text-center">SL#</th>
							<th class="text-left">Date</th>
							<th class="text-left">Generic Name</th>
							<th class="text-left">Medicine</th>
							<th class="text-right">Sale Amount</th>
							<th class="text-center">Discount</th>
							<th class="text-right">Payable Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">01</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">02</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">03</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">04</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">05</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>
					</tbody>

					<tfoot>
						<tr class="bg-flat-color-13">
							<th class="text-right" colspan="4">Total&nbsp;:</th>
							<th class="text-right">6,000</th>
							<th class="text-right">Total&nbsp;:</th>
							<th class="text-right">5,000</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</div>
	<div class="col-md-6">
		<div class="form-row">
			<div class="col-md-12 text-center">
				<h5 class="m-0 text-white bg-flat-color-5 mb-2 py-1">Outdoor Pharmacy</h5>
			</div>
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
			<div class="col-md-7">
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

			<div class="col-md-5">
				<div class="form-group m-0">
					<select class="form-control" id="salesman_wise_filter" name="salesman_wise_filter">
						<option value="">Select Salesman</option>
						<option value="">salesman-1</option>
						<option value="">salesman-2</option>
						<option value="">salesman-3</option>
					</select>
				</div>
			</div>

			<div class="col-md-12">
				<table class="table table-bordered table-hover mb-0">
					<thead class="bg-flat-color-13">
						<tr>
							<th class="text-center">SL#</th>
							<th class="text-left">Date</th>
							<th class="text-left">Generic Name</th>
							<th class="text-left">Medicine</th>
							<th class="text-right">Sale Amount</th>
							<th class="text-center">Discount</th>
							<th class="text-right">Payable Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">01</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">02</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">03</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">04</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>

						<tr>
							<td class="text-center">05</td>
							<td class="text-left">28/11/2020</td>
							<td class="text-left">Alendronate tablet</td>
							<td class="text-left">Fosamax</td>
							<td class="text-right">1,200</td>
							<td class="text-center">10%</td>
							<td class="text-right">1,000</td>
						</tr>
					</tbody>

					<tfoot>
						<tr class="bg-flat-color-13">
							<th class="text-right" colspan="4">Total&nbsp;:</th>
							<th class="text-right">6,000</th>
							<th class="text-right">Total&nbsp;:</th>
							<th class="text-right">5,000</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

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