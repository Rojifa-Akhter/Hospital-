<div class="container-fluid">
	<div class="form-row bg-white border-bottom sticky-top shadow-sm">
		<div class="col-md-12 mb-1">
			<h5 class="mt-2 mb-0">Payment List</h5>
			<small>Payment / Payment List</small>
		</div>
	</div>


	<div class="card">
		<div class="card-body">
			<div class="form-row justify-content-center border-bottom">
				<div class="form-group col-md-2">
					<label class="col-form-label col-form-label-sm" for="prescription_id">Prescription ID</label>
					<input type="text" class="form-control form-control-sm m-0" id="prescription_id" name="prescription_id" value="" placeholder="Prescription ID">
				</div>

				<div class="form-group col-md-2">
					<label class="col-form-label col-form-label-sm" for="admission_id">Admission ID</label>
					<input type="text" class="form-control form-control-sm m-0" id="admission_id" name="admission_id" value="" placeholder="Admission ID">
				</div>

				<div class="form-group col-md-2">
					<label class="col-form-label col-form-label-sm" for="select_status">Status</label>
					<select class="form-control form-control-sm mb-3" id="select_status" name="select_status">
						<option value="">Select Status</option>
						<option value="">Paid</option>
						<option value="">Due</option>
						<option value="">Partial</option>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label class="col-form-label col-form-label-sm" for="admission_date_from">Admission Date</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">From</div>
						</div>
						<input type="text" class="form-control form-control-sm m-0 date_picker" id="admission_date_from" name="admission_date_from" value="" placeholder="dd-mm-yyyy">
						<div class="input-group-prepend">
							<div class="input-group-text">To</div>
						</div>
						<input type="text" class="form-control form-control-sm m-0 date_picker" id="admission_date_to" name="admission_date_to" value="" placeholder="dd-mm-yyyy">
					</div>
				</div>

				<div class="col-md-2">
					<div class="btn-group btn-block" role="group">
						<button type="button" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>
						<button type="reset" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i>Reset</button>
					</div>
				</div>
			</div>	

			<div class="form-row mt-2">
				<div class="col-md-12">
					<table class="table table-striped table-bordered table-hover mb-0">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">SL</th>
								<th class="text-left">Patient Name</th>
								<th class="text-center">Pres./Adm.ID</th>
								<th class="text-center">Service ID</th>
								<th class="text-left">Doctor Name</th>
								<th class="text-center">Prescription Date</th>
								<th class="text-right">Total Bill</th>
								<th class="text-right">Discount</th>
								<th class="text-right">Net Payable</th>
								<th class="text-right">Total Paid</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">01</td>
								<td class="text-left">Patient-022025625</td>
								<td class="text-center">Adm-01221552</td>
								<td class="text-center">BAF-01221552</td>
								<td class="text-left">Dr.Kawsar Ahamed</td>
								<td class="text-center">dd/mm/yyyy</td>
								<td class="text-right">12,000.00</td>
								<td class="text-right">2000.00</td>
								<td class="text-right">10,000.00</td>
								<td class="text-right">10,000.00</td>
							</tr>

							<tr>
								<td class="text-center">02</td>
								<td class="text-left">Patient-022025625</td>
								<td class="text-center">Adm-01221552</td>
								<td class="text-center">BAF-01221552</td>
								<td class="text-left">Dr.Kawsar Ahamed</td>
								<td class="text-center">dd/mm/yyyy</td>
								<td class="text-right">12,000.00</td>
								<td class="text-right">2000.00</td>
								<td class="text-right">10,000.00</td>
								<td class="text-right">10,000.00</td>
							</tr>

							<tr>
								<td class="text-center">03</td>
								<td class="text-left">Patient-022025625</td>
								<td class="text-center">Adm-01221552</td>
								<td class="text-center">BAF-01221552</td>
								<td class="text-left">Dr.Kawsar Ahamed</td>
								<td class="text-center">dd/mm/yyyy</td>
								<td class="text-right">12,000.00</td>
								<td class="text-right">2000.00</td>
								<td class="text-right">10,000.00</td>
								<td class="text-right">10,000.00</td>
							</tr>

							<tr>
								<td class="text-center">04</td>
								<td class="text-left">Patient-022025625</td>
								<td class="text-center">Adm-01221552</td>
								<td class="text-center">BAF-01221552</td>
								<td class="text-left">Dr.Kawsar Ahamed</td>
								<td class="text-center">dd/mm/yyyy</td>
								<td class="text-right">12,000.00</td>
								<td class="text-right">2000.00</td>
								<td class="text-right">10,000.00</td>
								<td class="text-right">10,000.00</td>
							</tr>

							<tr>
								<td class="text-center">05</td>
								<td class="text-left">Patient-022025625</td>
								<td class="text-center">Adm-01221552</td>
								<td class="text-center">BAF-01221552</td>
								<td class="text-left">Dr.Kawsar Ahamed</td>
								<td class="text-center">dd/mm/yyyy</td>
								<td class="text-right">12,000.00</td>
								<td class="text-right">2000.00</td>
								<td class="text-right">10,000.00</td>
								<td class="text-right">10,000.00</td>
							</tr>




						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>