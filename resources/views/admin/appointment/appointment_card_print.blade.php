<form>
	<div class="card">
		<div class="card-body mt-2">
			<div class="row">
				<div class="col-md-12">
					<div class="hosital_logo m-auto">
						<img class="w-100" src="{{ asset('images/iCure_Logo.jpg') }}" alt="">
					</div>

					<div class="hospital_info">
						<h5>iCure Hospital Management</h5>
						<h6>Appointment Card</h6>
					</div>
				</div>

				<div class="col-md-12">
					<div class="card_info text-left">
						<div class="patient_info">
							<div class="row">
								<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-9">
									<table class="">
										<tr>
											<th class="text-left ">PID</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">PID-2135694</th>

											<th class="text-left pl-3">Name</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">Mohammad Atikul Islam</th>
										</tr>

										<tr>
											<th class="text-left ">Age</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">27</th>

											<th class="text-left pl-3">DOB</th>
											<th class="text-left px-3">:</th>
											<th class="text-left"><?php echo date ('d-m-Y')?></th>
										</tr>

										<tr>
											<th class="text-left ">Blood Group</th>
											<th class="text-left px-3">:</th>
											<th class="text-left ">B+</th>

											<th class="text-left pl-3">Gender</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">Male</th>
										</tr>

										<tr>
											<th class="text-left ">Doctor</th>
											<th class="text-left px-3">:</th>
											<th class="text-left ">DR.Abul Basar</th>

											<th class="text-left pl-3">Degree</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">MBBS</th>

										</tr>

										<tr>
											<th class="text-left ">App.No</th>
											<th class="text-left px-3">:</th>
											<th class="text-left ">23</th>

											<th class="text-left pl-3">Consult-No</th>
											<th class="text-left px-3">:</th>
											<th class="text-left">562436987</th>
										</tr>

										<tr>
											<th class="text-left ">App. Date & Time</th>
											<th class="text-left px-3">:</th>
											<th class="text-left "><?php echo date ('d-m-Y')?></th>
										</tr>
									</table>
								</div>


								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3">
									<div class="appointment_no m-auto">
										<span>4</span>
									</div>
								</div>
							</div>
						</div>

						<div class="card_footer">
							<div class="row align-items-center py-2">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-left">
									<div class="foot_time">
										<strong class="">ISSUE Date : <?php echo date ('d F Y,')?></strong>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
									<div class="foot_bar_code">
										<img class="w-100" src="{{ asset('images/barcode.gif') }}" alt="">
									</div>
								</div>
							</div>
						</div>
						<button class="btn btn-sm btn-success noprint" onclick="window.print();return false;"><i class="fas fa-print"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>