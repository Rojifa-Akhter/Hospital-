<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-12">
			<h5 class="mt-2 mb-0">Pathology Test wise Attribute Entry</h5>
			<small>Pathology / Pathology Test wise Attribute Entry</small>
		</div>		
	</div>

	<div class="form-row">
		<div class="col-md-3">
			<div class="card shadow-sm">
				<div class="card-header"><h5>Exam List</h5></div>
				<div class="card-body">
					<div class="form-group">
						<label for="exam_type" class="col-form-label col-form-label-sm">Item Type</label>
						<select class="form-control form-control-sm" id="exam_type" name="exam_type">
							<option value="">Select Item Type</option>
							<option value="">Pathology</option>
							<option value="">Radiology</option>
						</select>
					</div>

					<div class="form-group">
						<label for="exam_id" class="col-form-label col-form-label-sm">Item ID</label>
						<input type="text" class="form-control custom-form" id="exam_id" name="exam_id" value="" placeholder="Item ID">
					</div>

					<div class="form-group">
						<label for="exam_name" class="col-form-label col-form-label-sm">Item Name</label>
						<input type="text" class="form-control custom-form" id="exam_name" name="exam_name" value="" placeholder="Item Name">
					</div>

					<div class="form-group">
						<label for="exam_sample" class="col-form-label col-form-label-sm">Sample</label>
						<select class="form-control form-control-sm" id="exam_sample" name="exam_sample">
							<option value="">Select Sample</option>
							<option value="">Sample-1</option>
							<option value="">Sample-2</option>
						</select>
					</div>

					<div class="form-group">
						<label for="exam_department" class="col-form-label col-form-label-sm">Department</label>
						<select class="form-control form-control-sm" id="exam_department" name="exam_department">
							<option value="">Select Department</option>
							<option value="">Department-1</option>
							<option value="">Department-2</option>
						</select>
					</div>

					<div class="form-group">
						<label for="exam_template" class="col-form-label col-form-label-sm">Template</label>
						<select class="form-control form-control-sm" id="exam_template" name="exam_template">
							<option value="">Select Template</option>
							<option value="">Template-1</option>
							<option value="">Template-2</option>
						</select>
					</div>

					<div class="form-group">
						<label for="item_template" class="col-form-label col-form-label-sm d-block">Status</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
							<label class="form-check-label" for="inlineRadio1">All</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
							<label class="form-check-label" for="inlineRadio2">Active</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
							<label class="form-check-label" for="inlineRadio3">Inactive</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-sm btn-warning"><i class="fas fa-print"></i> Print</button>
							<button class="btn btn-sm btn-success">Save</button>
							<button class="btn btn-sm btn-danger">Reset</button>	
						</div>
					</div>

					<hr>

					<table class="table table-striped table-bordered mb-0">
						<thead>
							<tr class="bg-primary">
								<th class="text-left">ID</th>
								<th class="text-left">Name</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-1</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Lipid Profile Serum</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">CAG</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-56324692</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-98531478516</td>
							</tr>

							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-1</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Lipid Profile Serum</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">CAG</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-56324692</td>
							</tr>
							<tr>
								<td class="text-left">item-0120142</td>
								<td class="text-left">Blood Test-98531478516</td>
							</tr>




						</tbody>
					</table>

				</div>
			</div>
		</div>





		<div class="col-md-9">
			<div class="card shadow-sm">
				<div class="card-header"><h5>Attribute Setup</h5></div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="item_no">Item No.</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control custom-form" id="item_no" name="item_no" value="" placeholder="Item No.">
									<input type="text" class="form-control custom-form" id="item_barcode" name="item_barcode" value="" placeholder="Barcode">
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="item_name" class="col-form-label col-form-label-sm">Item Name</label>
								<input type="text" class="form-control custom-form" id="item_name" name="item_name" value="" placeholder="Item Name">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="item_sample" class="col-form-label col-form-label-sm">Sample</label>
								<input type="text" class="form-control custom-form" id="item_sample" name="item_sample" value="" placeholder="Item Name">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="item_department" class="col-form-label col-form-label-sm">Department</label>
								<input type="text" class="form-control custom-form" id="item_department" name="item_department" value="" placeholder="Department">
							</div>
						</div>

						<div class="col-md-12">
							<table class="table table-borderless mb-0">
								<thead>
									<tr>
										<th class="w-5">SL</th>
										<th class="">Attribute</th>
										<th class="w-10">Unit</th>
										<th class="">A.G</th>
										<th class="w-5">GS</th>
										<th class="">SF</th>
										<th class="w-5">HP</th>
										<th class="w-5">GI</th>
										<th class="w-5">Active</th>
										<th class="">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class=""><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class=""><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class=""><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="">
											<select class="form-control form-control-sm" id="" name="">
												<option value="">Select A.G</option>
												<option value="">Lipid Profile Serum</option>
											</select>
										</td>
										<td class=""><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class=""><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class=""><input type="checkbox" id="" name="" value="" ></td>
										<td class=""><input type="checkbox" id="" name="" value="" ></td>
										<td class=""><input type="checkbox" id="" name="" value="" ></td>
										<td class="">
											<button class="btn btn-sm btn-success">Save</button>
											<button class="btn btn-sm btn-danger">Clear</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>


			<div class="card border-0">
				<div class="card-body p-2">
					<div class="form-row">
						<div class="col-md-9">
							<div class="card mt-0">
								<div class="card-body p-2">
									<table class="table table-bordered table-striped mb-0">
										<thead>
											<tr class="bg-primary">
												<th class="text-center">SL</th>
												<th class="text-left">Attribute</th>
												<th class="text-center">Unit</th>
												<th class="text-left">Attribute Group</th>
												<th class="text-center">GS</th>
												<th class="text-center">SF</th>
												<th class="text-center">HP</th>
												<th class="text-center">GI</th>
												<th class="text-center">Active</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>
											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>

											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>

											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>

											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>

											<tr>
												<td class="text-center">01</td>
												<td class="text-left">Total Cholesterol</td>
												<td class="text-center">Mg/dL</td>
												<td class="text-left">Lipid Profile Serum</td>
												<td class="text-center">1</td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
												<td class="text-center"><input type="checkbox" id="" name="" value="" ></td>
											</tr>


										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="card mt-0">
								<div class="card-body">
									<div class="form-group">
										<label for="analyzer" class="col-form-label col-form-label-sm">Analyzer</label>
										<select class="form-control form-control-sm" id="analyzer" name="analyzer">
											<option value="">Select Analyzer</option>
											<option value="">Analyzer-1</option>
											<option value="">Analyzer-2</option>
										</select>
									</div>

									<div class="form-group">
										<label for="matchine_attribute" class="col-form-label col-form-label-sm">Matchine Attribute</label>
										<input type="text" class="form-control custom-form" id="matchine_attribute" name="matchine_attribute" value="" placeholder="Matchine Attribute">
									</div>

									<div class="form-group">
										<label for="panel_attribute" class="col-form-label col-form-label-sm">Panel Attribute</label>
										<input type="text" class="form-control custom-form" id="panel_attribute" name="panel_attribute" value="" placeholder="Panel Attribute">
									</div>

									<div class="form-group">
										<label for="unit" class="col-form-label col-form-label-sm">Unit</label>
										<input type="text" class="form-control custom-form" id="unit" name="unit" value="" placeholder="Unit">
									</div>

									<div class="form-group">
										<label for="normal_result" class="col-form-label col-form-label-sm">Normal Result</label>
										<textarea class="form-control custom-form" id="normal_result" name="normal_result" value="" placeholder="Normal Result" name="" id=""rows="3"></textarea>
									</div>


									<button class="btn btn-sm btn-success btn-block"> Save</button>

								</div>
							</div>
						</div>
						<div class="col-md-12">
							<hr>
							<table class="table table-borderless mb-0">
								<thead>
									<th class="text-left">Gender <Span class="text-danger">*</Span></th>
									<th class="text-left">A.G <Span class="text-danger">*</Span></th>
									<th class="text-left w-5">DD</th>
									<th class="text-left w-5">MM</th>
									<th class="text-left w-5">YY</th>
									<th class="text-left">Normal Result <Span class="text-danger">*</Span></th>
									<th class="text-left">CMP</th>
								</thead>
								<tbody>
									<td class="text-left">
										<select class="form-control form-control-sm" id="" name="">
											<option value="">Select Gender</option>
											<option value="">Male</option>
											<option value="">Female</option>
											<option value="">Others</option>
										</select>
									</td>

									<td class="text-left">
										<select class="form-control form-control-sm" id="" name="">
											<option value="">Select A.G</option>
											<option value="">A.G</option>
											<option value="">A.G</option>
											<option value="">A.G</option>
										</select>
									</td>
									<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
									<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
									<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
									<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
									<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>



								</tbody>
							</table>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="normal_range">Normal Range</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control custom-form" id="normal_range" name="normal_range" value="" placeholder="0">
									<input type="text" class="form-control custom-form" id="normal_range2" name="normal_range2" value="" placeholder="0">
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="critical_range">Critical Range</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control custom-form" id="critical_range" name="critical_range" value="" placeholder="0">
									<input type="text" class="form-control custom-form" id="critical_range2" name="critical_range2" value="" placeholder="0">
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="">Action</label>
								<div class="input-group mb-2">
									<button class="btn btn-sm btn-success w-50">Save</button>
									<button class="btn btn-sm btn-danger w-50">Clear</button>
								</div>
							</div>
						</div>


						<div class="col-md-12">
							<hr>
							<table class="table table-borderless mb-0">
								<thead>
									<tr class="bg-primary">
										<th class="text-left">Gender</th>
										<th class="text-left">Age Group</th>
										<th class="text-left w-5">DD</th>
										<th class="text-left w-5">MM</th>
										<th class="text-left w-5">YY</th>
										<th class="text-left">CMP</th>
										<th class="text-left w-10">Normal Range</th>
										<th class="text-left w-10">Critical Range</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-left">Male</td>
										<td class="text-left"></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"></td>
										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>


										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>
										<td class="text-center"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
									</tr>
									<tr>
										<td class="text-left">Male</td>
										<td class="text-left"></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"></td>
										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>


										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>
										<td class="text-center"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
									</tr>
									<tr>
										<td class="text-left">Male</td>
										<td class="text-left"></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"><input type="text" class="form-control custom-form" id="" name="" value="" placeholder=""></td>
										<td class="text-left"></td>
										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>


										<td class="text-left">
											<div class="input-group mb-2">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
												<input type="text" class="form-control" id="" name="" value="" placeholder="0">
											</div>
										</td>
										<td class="text-center"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
									</tr>


								</tbody>
							</table>
						</div>

					</div>


				</div>
			</div>
			


		</div>








	</div>
</div>