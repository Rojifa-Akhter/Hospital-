<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Financial Assessment</h5>
			<small>IPD / Financial Assessment</small>
		</div>
	</div>

	<div class="card">
		<div class="card-header"><h5>IPD Financial Assessment</h5></div>
		<div class="card-body p-2">
			<div class="form-row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="select_package">Package</label>
						<select class="form-control form-control-sm" id="select_package" name="select_package">
							<option value="">Select Package</option>
							<option value="">Package-1</option>
							<option value="">Package-2</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="select_bed">Bed</label>
						<select class="form-control form-control-sm" id="select_bed" name="select_bed">
							<option value="">Select Bed</option>
							<option value="">Bed-1</option>
							<option value="">Bed-2</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="package_rate">Rate</label>
						<input type="text" class="form-control form-control-sm m-0" id="package_rate" name="package_rate" value="" placeholder="0.00" >
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="number_of_days">Number of Days</label>
						<input type="text" class="form-control form-control-sm m-0" id="number_of_days" name="number_of_days" value="" placeholder="Number of Days" >
					</div>
				</div>



			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body p-2">
			<div class="form-row">
				<div class="col-md-12">
					<table class="table table-bordered table-striped mb-0">
						<thead>
							<tr class="bg-primary">
								<th class="text-left">Dept. Name</th>
								<th class="text-right w-10">Total Amount</th>
								<th class="text-right w-10">Proposed</th>
								<th class="text-right w-10">Difference</th>
								<th class="text-center w-10">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-left">Pathology</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
									<button class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>
								</td>
							</tr>

							<tr>
								<td class="text-left">Radiology & Imaging</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
									<button class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>
								</td>
							</tr>

							<tr>
								<td class="text-left">OT Charge</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
									<button class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>
								</td>
							</tr>

							<tr>
								<td class="text-left">Surgeon Charge</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
									<button class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>
								</td>
							</tr>

							<tr>
								<td class="text-left">Medicine Charge</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-right">0.00</td>
								<td class="text-center">
									<button class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
									<button class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th class="text-right">Grand Total</th>
								<th class="text-right">0.00</th>
								<th class="text-right">0.00</th>
								<th class="text-right">0.00</th>
								<th class="text-right"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h5>Enquiry Details:</h5></div>
				<div class="card-body p-2">
					<div class="form-row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="enquiry_name">Name</label>
								<input type="text" class="form-control form-control-sm m-0" id="enquiry_name" name="enquiry_name" value="" placeholder="Name">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="enquiry_gender">Gender
								</label>
								<input type="text" class="form-control form-control-sm m-0" id="enquiry_gender" name="enquiry_gender" value="" placeholder="Gender">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="enquiry_mobile">Mobile
								</label>
								<input type="text" class="form-control form-control-sm m-0" id="enquiry_mobile" name="enquiry_mobile" value="" placeholder="Mobile">
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="enquiry_address">Address</label>
								<input type="text" class="form-control form-control-sm m-0" id="enquiry_address" name="enquiry_address" value="" placeholder="Address">
							</div>
						</div>

						<div class="col-md-6">
							<label class="col-form-label col-form-label-sm" for="enquiry_address">Query For</label> <br>
							<div class="mt-1">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="query_for" id="query_for_self" value="">
									<label class="form-check-label" for="query_for_self">Self</label>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="query_for" id="query_for_spouse" value="">
									<label class="form-check-label" for="query_for_spouse">Spouse</label>
								</div>


								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="query_for" id="query_for_parents" value="">
									<label class="form-check-label" for="query_for_parents">Parents</label>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="query_for" id="query_for_other" value="">
									<label class="form-check-label" for="query_for_other">Others</label>
								</div>
							</div>
						</div>
					</div>

					<div class="form-row justify-content-center mt-3">
						<div class="col-md-3">
							<button class="btn btn-md btn-block btn-danger">Clear</button>
						</div>
						<div class="col-md-3">
							<button class="btn btn-md btn-block btn-success">Save And Print</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>