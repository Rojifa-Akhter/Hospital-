<style>
	body{
		font-family: 'Poppins' !important;
	}

	.card_name{
		font-size: 20px;
		color: #70657b !important;

	}

	.counter-num {
		font-size: 32px;
		font-weight: 500;
		font-family: poppins;
	}

	.card-body{
		position: relative;
		padding: .5rem;
	}

	.card-icon {
		position: absolute;
		width: 65px;
		top: 50%;
		left: 12%;
		transform: translate(-50%, -50%);
		font-size: 40px;
		color: #74697f9e;
		opacity: 0.2;
	}

	.card-title {
		margin-bottom: 0.75rem;
		background-color: #0072ffba;
		padding: 7px 10px;
		color: #ffffff;
		font-weight: 500;
		font-size: 14px;
		border-radius: 5px 5px 0 0;
	}

	.white-space{
		white-space: nowrap;
	}

	.table thead th,
	.table thead td {
		color: #7987a1;
		font-weight: 700;
		font-size: 13px !important;
		letter-spacing: .5px;
		text-transform: uppercase;
		border-bottom-width: 1px;
		border-top-width: 0;
		/*padding: 0 15px 5px;*/
	}

	.shortcut-buttons a{
		text-decoration: none;
	}

	.custom-box-button{
		width: 100%;
		text-align: center;
		color: #fff;
		padding: 20px 10px;
		box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.1);
		margin-top: 10px;
		vertical-align: middle;
		font-size: 18px;
		border-radius: 20px 5px 20px;
		overflow: hidden;
		position: relative;
		z-index: 1;
		background-color: #00c6ff;
	}

	.custom-box-button:before{
		content: '';
		position: absolute;
		top: 0;
		left:0;
		height: 0px;
		width: 100%;
		background: #00c6ff;
		background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
		background: linear-gradient(to right, #0072ff, #00c6ff);
		z-index: -1;
		transition: all 0.3s;
	}

	.custom-box-button:hover:before{
		height: 100%;
	}

	.tab-content {
		border-radius: 5px;
	}

	.tab-content .table thead {
		background: #00c6ff;
		background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
		background: linear-gradient(to right, #0072ff, #00c6ff);
	}

	.tab-content .table thead tr th{
		color: #fff;
	}

	.nav-pills .nav-link {
		border-radius: 0.25rem;
		padding: 7px 10px;
		font-size: 14px;
	}

	.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
		color: #fff;
		background-color: #0072ffba;
	}


</style>


<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top shadow-sm">
		<div class="col-md-12">
			<h5 class="mt-2 mb-0">Dashboard</h5>
			<small>PCRM / Dashboard</small>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<h6 class="card-title mb-1">Appointment Today <span>(10-Jun-2020)</span></h6>
					<div class="card-body border-top">
						<div class="table-responsive">
							<table class="table table-hover m-0">
								<thead>
									<tr>
										<th class="text-center">SL#</th>
										<th class="text-left">Time</th>
										<th class="text-left">Patient</th>
										<th class="text-left">Contact</th>
										<th class="text-left">Physiotherapist</th>
										<th class="text-left">Next Appointment</th>
										<th class="text-left"></th>
										<th class="text-left"></th>
										<th class="text-left"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="text-center">01</th>
										<td class="text-left">10:00 AM</td>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left">+880 1723254120</td>
										<td class="text-left">Alam Khan</td>
										<td class="text-left"><span>15-Jun-2020</span> <span>10:30AM</span></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-navy">Call</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-brown">Email</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-blue">SMS</button></td>
									</tr>

									<tr>
										<th class="text-center">02</th>
										<td class="text-left">10:00 AM</td>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left">+880 1723254120</td>
										<td class="text-left">Alam Khan</td>
										<td class="text-left"><span>15-Jun-2020</span> <span>10:30AM</span></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-navy">Call</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-brown">Email</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-blue">SMS</button></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<div class="card-body">
						<div class="shortcut-buttons">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Instant Appointment</span>
										</div>
									</a>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Add Referral</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Add Agent</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Add Service</span>
										</div>
									</a>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Calendar</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Billing</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Due Collection</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Collection Report</span>
										</div>
									</a>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Sales Report</span>
										</div>
									</a>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Due Report</span>
										</div>
									</a>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
									<a href="#">
										<div class="custom-box-button">
											<span>Add Physicist Schedule</span>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<div class="card-body">
						<div class="row">
							<div class="col-3">
								<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link active" id="v-pills-yesterday-tab" data-toggle="pill" href="#v-pills-yesterday" role="tab" aria-controls="v-pills-yesterday" aria-selected="true">Yesterday</a>
									<a class="nav-link" id="v-pills-today-tab" data-toggle="pill" href="#v-pills-today" role="tab" aria-controls="v-pills-today" aria-selected="false">Today</a>
									<a class="nav-link" id="v-pills-tomorrow-tab" data-toggle="pill" href="#v-pills-tomorrow" role="tab" aria-controls="v-pills-tomorrow" aria-selected="false">Tomorrow</a>
								</div>
							</div>
							<div class="col-9">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="v-pills-yesterday" role="tabpanel" aria-labelledby="v-pills-yesterday-tab">
										<div class="table-responsive">
											<table class="table table-hover m-0">
												<thead>
													<tr>
														<th class="text-center">SL#</th>
														<th class="text-left">Appointment</th>
														<th class="text-left">Calls</th>
														<th class="text-left">SMS</th>
														<th class="text-left">Email</th>
														<th class="text-left">Patient</th>
														<th class="text-left">Visit</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th class="text-center">01</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
													</tr>


													<tr>
														<th class="text-center">02</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div> 	
									<div class="tab-pane fade" id="v-pills-today" role="tabpanel" aria-labelledby="v-pills-today-tab">
										<div class="table-responsive">
											<table class="table table-hover m-0">
												<thead>
													<tr>
														<th class="text-center">SL#</th>
														<th class="text-left">Appointment</th>
														<th class="text-left">Calls</th>
														<th class="text-left">SMS</th>
														<th class="text-left">Email</th>
														<th class="text-left">Patient</th>
														<th class="text-left">Visit</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th class="text-center">01</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
													</tr>


													<tr>
														<th class="text-center">02</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane fade" id="v-pills-tomorrow" role="tabpanel" aria-labelledby="v-pills-tomorrow-tab">
										<div class="table-responsive">
											<table class="table table-hover m-0">
												<thead>
													<tr>
														<th class="text-center">SL#</th>
														<th class="text-left">Appointment</th>
														<th class="text-left">Calls</th>
														<th class="text-left">SMS</th>
														<th class="text-left">Email</th>
														<th class="text-left">Patient</th>
														<th class="text-left">Visit</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th class="text-center">01</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
													</tr>


													<tr>
														<th class="text-center">02</th>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
														<td class="text-left"></td>
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
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<h6 class="card-title mb-1">Followup List <span>(Next 7 Days Schedules)</span></h6>
					<div class="card-body border-top">
						<div class="table-responsive">
							<table class="table table-hover m-0">
								<thead>
									<tr>
										<th class="text-center">SL#</th>
										<th class="text-left">Patient</th>
										<th class="text-left white-space">Contact</th>
										<th class="text-left white-space">Service Name</th>
										<th class="text-left white-space">App.Date</th>
										<th class="text-left white-space">Time</th>
										<th class="text-left">Followup</th>
										<th class="text-left">Response</th>
										<th class="text-left"></th>
										<th class="text-left"></th>
										<th class="text-left"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="text-center">01</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-left white-space">Electro Therapy</td>
										<td class="text-left white-space">20-Jun-2020</td>
										<td class="text-left white-space">10:00 AM</td>
										<th class="text-left">Call (2), SMS (0), Email (0)</th>
										<th class="text-left">Call (2), SMS (0), Email (0)</th>
										<td class="text-left"><button type="button" class="btn btn-sm bg-navy">Call</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-brown">Email</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-blue">SMS</button></td>
									</tr>

									<tr>
										<th class="text-center">02</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-left white-space">Electro Therapy</td>
										<td class="text-left white-space">20-Jun-2020</td>
										<td class="text-left white-space">10:00 AM</td>
										<th class="text-left">Call (2), SMS (0), Email (0)</th>
										<th class="text-left">Call (2), SMS (0), Email (0)</th>
										<td class="text-left"><button type="button" class="btn btn-sm bg-navy">Call</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-brown">Email</button></td>
										<td class="text-left"><button type="button" class="btn btn-sm bg-blue">SMS</button></td>
									</tr>


								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<h6 class="card-title mb-1">Unattendant Patient List</span></h6>
					<div class="card-body border-top">
						<div class="table-responsive">
							<table class="table table-hover m-0">
								<thead>
									<tr>
										<th class="text-center">SL#</th>
										<th class="text-left">Patient</th>
										<th class="text-left white-space">Contact</th>
										<th class="text-left white-space">Last Call Date</th>
										<th class="text-left white-space">Comments</th>
										<th class="text-left white-space">Called by</th>
										<td></td>
										<td></td>
										<td></td>

									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="text-center">01</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-left white-space">20-Jun-2020</td>
										<td class="text-left white-space"></td>
										<td class="text-left white-space"></td>
										<th class="text-left">Details</th>
										<th class="text-left">Deceased Mark</th>
										<th class="text-left">Never Call Mark</th>
									</tr>

									<tr>
										<th class="text-center">02</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-left white-space">20-Jun-2020</td>
										<td class="text-left white-space"></td>
										<td class="text-left white-space"></td>
										<th class="text-left">Details</th>
										<th class="text-left">Deceased Mark</th>
										<th class="text-left">Never Call Mark</th>
									</tr>


								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body shadow-sm">
					<h6 class="card-title mb-1">Due Patient List</h6>
					<div class="card-body border-top">
						<div class="table-responsive">
							<table class="table table-hover m-0">
								<thead>
									<tr>
										<th class="text-center">SL#</th>
										<th class="text-left">Patient</th>
										<th class="text-left white-space">Contact</th>
										<th class="text-right white-space">Last Bill Amount</th>
										<th class="text-center white-space">Last Bill Date</th>
										<th class="text-center white-space">Payment Date</th>
										<td class="text-right white-space">Due Amount</td>
										<td></td>
										<td></td>
										<td></td>

									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="text-center">01</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-right white-space">5000 <small>(Tk)</small></td>
										<td class="text-center white-space">20-Jun-2020</td>
										<td class="text-center white-space">20-Jun-2020</td>
										<td class="text-right white-space">2000 <small>(Tk)</small></td>
										<th class="text-left">
											<button type="button" class="btn btn-sm bg-navy">Call</button>
											<button type="button" class="btn btn-sm bg-brown">Email</button>
											<button type="button" class="btn btn-sm bg-blue">SMS</button>
										</th>
										<th class="text-left white-space">Patient Details</th>
										<th class="text-left white-space">Collect Due</th>
									</tr>

									<tr>
										<th class="text-center">02</th>
										<th class="text-left"><span>Patient-002</span>, <br> <span>35years</span>, <span>Male</span></th>
										<td class="text-left white-space">+880 1723254120</td>
										<td class="text-right white-space">5000 <small>(Tk)</small></td>
										<td class="text-center white-space">20-Jun-2020</td>
										<td class="text-center white-space">20-Jun-2020</td>
										<td class="text-right white-space">2000 <small>(Tk)</small></td>
										<th class="text-left">
											<button type="button" class="btn btn-sm bg-navy">Call</button>
											<button type="button" class="btn btn-sm bg-brown">Email</button>
											<button type="button" class="btn btn-sm bg-blue">SMS</button>
										</th>
										<th class="text-left white-space">Patient Details</th>
										<th class="text-left white-space">Collect Due</th>
									</tr>


								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
