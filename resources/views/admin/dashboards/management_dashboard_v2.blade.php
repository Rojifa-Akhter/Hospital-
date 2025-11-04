<style>
	.card {
		margin-bottom: .6rem;
		border-radius: 0;
	}
	.card-body{
		padding: 1.25rem;
	}
	.value{
		position: relative;
		min-height: 40px;
	}
	.value i {
		position: absolute;
		top: 0px;
		right: 0;
		font-size: 45px;
		color: #e9ecef;
	}

	.progress {
		height: 0.3rem;
	}

	.bg-white {
		background-color: #fff !important;
	}

	.font-weight-semibold {
		font-weight: 700 !important;
	}

	.card-header:before {
		background-color: #705ec8;
	}
	.card-header:before {
		content: "";
		position: absolute;
		left: 0px;
		padding: 3px;
		border-radius: 0 50px 50px 0;
		height: 20px;
	}

	.ipd_consultation h4,
	.opd_consultation h4{
		font-size: 1rem!important;
	}

	#sidebar-left {
		position: fixed;
		top: 43px;
	}
	.navbar {
		position: fixed;
		width: 100%;
		top: 0;
		left: 0;
	}
	#content {
		overflow-y: auto!important;
	}

	h4,
	.h4 {
		font-size: 1.1rem;
	}

	h5,
	.h5 {
		font-size: 1rem;
	}



	/*===================================================*/

	.avatar-title {
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		color: #fff;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		height: 100%;
		-webkit-box-pack: center;
		-ms-flex-pack: center;
		justify-content: center;
		width: 100%;
	}

	.avatar-lg {
		height: 4.5rem;
		width: 4.5rem;
	}

	.avatar-md {
		height: 3rem;
		width: 3rem;
	}


	.bg-soft-light {
		background-color: rgba(247,247,247,.25)!important;
	}

	.align-self-center {
		-ms-flex-item-align: center!important;
		align-self: center!important;
	}
	.rounded-circle {
		border-radius: 50%!important;
	}

	.widget-box-two{
		position: relative;
	}

	.avatar{
		position: absolute;
		top: 50%;
		right:1rem;
		transform: translateY(-50%);
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

	.card-title {
		margin-bottom: 0.75rem;
		/*background-color: #0072ffba;*/
		background-color: rgba(0,0,0,.2);
		/*background: linear-gradient(to top right,#007bff,#00121d) !important;*/
		padding: 5px 10px;
		color: #ffffff;
		font-weight: 500;
		font-size: 14px;
		border-radius: 5px 5px 0 0;
	}

	.box {
		box-shadow: 0px 3px 20px #0000000b;
		--bg-opacity: 1;
/*		background-color: #fff;
background-color: rgba(255, 255, 255, var(--bg-opacity));*/
border-radius: 0.375rem;
padding: .3rem .5rem;
position: relative;
}
.items-center {
	align-items: center;
}

.w-10 {
	width: 2.5rem;
}
.overflow-hidden {
	overflow: hidden;
}
.h-10 {
	height: 2.5rem;
}
.flex-none {
	flex: none;
}

.display-flex {
	display: flex;
}

.rounded-full {
	border-radius: 9999px;
}
.image-fit {
	position: relative;
}

.image-fit > img {
	position: absolute;
	-o-object-fit: cover;
	object-fit: cover;
	width: 100%;
	height: 100%;
}



.zoom-in {
	transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
	transition-duration: 300ms;
	transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
	--transform-translate-x: 0;
	--transform-translate-y: 0;
	--transform-rotate: 0;
	--transform-skew-x: 0;
	--transform-skew-y: 0;
	--transform-scale-x: 1;
	--transform-scale-y: 1;
	transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
	cursor: pointer;
}

.zoom-in:hover {
	--transform-scale-x: 1.03;
	--transform-scale-y: 1.03;
	box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.input-group-text {
	color: #ffffff;
	background-color: #0798be;
}

.cursor-pointer{
	cursor: pointer;
}

.top-section{
	background: url({{ asset('images/bg1.png') }})!important;
}

/*.dashboard-table.table {
	color: #ffffff !important;
}
.dashboard-table .table-bordered th,
.dashboard-table .table-bordered td {
	border: 1px solid #c3e0ff45!important;
	}*/

	.custom-form{
		background-color: #f5f8fa3d!important;
		color: #d8d8d8!important;
		border: 1px solid #e1e8ee8c!important;
	}

	.custom-form:focus{
		/*text-shadow:0 1px 0 rgba(0,0,0,0.4)!important;*/
		color: #222!important;
	}



</style>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">


<div class="container-fluid top-section">
	<div class="row bg-white sticky-top align-items-center justify-content-between py-1">
		<div class="col-md-3">
			<h5 class="mb-0">Management Dashboard</h5>
			<small>Home / Management Dashboard</small>
		</div>

		<div class="col-md-9">
			<div class="form-row justify-content-end mt-2">
				<div class="col-md-2">
					<button class="btn btn-success btn-block btn-md"><i class="fas fa-calendar-day"></i>&nbsp;Today</button>
				</div>

				<div class="col-md-3">
					<div class="form-group m-0">
						<select class="form-control" id="select_time" name="select_time">
							<option value="">Yesterday</option>
							<option value="">This Week</option>
							<option value="">This Month</option>
							<option value="">This Year</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group m-0">
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
			</div>
		</div>
	</div>

	<div class="form-row  mt-3">
		<div class="col-md-12">
			<div class="card bg-transparent-black border-0 bg-transparent-black mt-0">
				<div class="card-body p-2 d-flex align-items-center justify-content-between">
					<h5 class="mb-0 font-weight-bold">Accounts</h5>
					<h6 class="mb-0">This Month (November)</h6>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card border-0 bg-transparent-black mt-0">
				<div class="row mr-0 ml-0 bg-transparent-black">
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Investigation</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.investigation-popup') }}" data-title="Investigation">00,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 00,000</span> Last month</span>
						</div>
					</div>

					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">IPD-Collection</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.ipd-popup') }}" data-title="IPD-Collection">00,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 00,000</span> Last month</span>
						</div>
					</div>

					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Pharmacy Collection</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal" data-action="{{ route('dashboard.pharmacy-collection-popup') }}" data-title="Pharmacy Collection">00,000</h4>
							<span class="mb-0 text-white"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 00,000</span> Last month</span>
						</div>
					</div>

					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Ambulance</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.ambulance-collection-popup') }}" data-title="Ambulance Collection">0,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 0,000</span> Last month</span>
						</div>
					</div>

					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Others Collection</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.others-collection-popup') }}" data-title="Others Collection">00,000</h4>
							<span class="mb-0 text-white"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 00,000</span> Last month</span>
						</div>
					</div>

					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Total Collection</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">0,00,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 0,00,000</span> Last month</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-12">
			<div class="card bg-transparent-black border-0 mt-0 bg-transparent-black">
				<div class="card-body p-2 d-flex align-items-center justify-content-between">
					<h5 class="mb-0 font-weight-bold">Human Resource</h5>
					<h6 class="mb-0">Today (23/11/2020)</h6>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card border-0 bg-transparent-black mt-0">
				<div class="row mr-0 ml-0 bg-transparent-black">
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Total Manpower</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.total-manpower-employees') }}" data-title="Late Employees">0,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 0,000</span> Last Year</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Late</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.late-employees') }}" data-title="Late Employees">000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 000</span> Last Day</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Absent</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.late-employees') }}" data-title="Absent Employees">000</h4>
							<span class="mb-0 text-white"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 000</span> Last Day</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Leave</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.leave-employees') }}" data-title="Leave Employees">00</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 00</span> Last Day</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Sick</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.sick-employees') }}" data-title="Sick Employees">000</h4>
							<span class="mb-0 text-white"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 000</span> Last Day</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
						<div class="card-body text-center">
							<p class="mb-1 text-white">Offday</p>
							<h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.offday-employees') }}" data-title="Offday Employees">0,000</h4>
							<span class="mb-0 text-white"><span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i> 0,000</span> Last Day</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-6">
			<div class="card border-0 bg-transparent-black mt-0 mb-3">
				<div class="card-body p-2">
					<div class="card-title">
						<div class="form-row justify-content-between align-items-center">
							<div class="col-md-6">
								<h6 class="mb-0">Consultant - Morning <span>(10-Jun-2020)</span></h6>
							</div>
							<div class="col-md-6">
								<div class="form-group m-0" style="margin-bottom: 0px!important;">
									<select class="form-control custom-form" id="department_wise_filter_morning" name="department_wise_filter_morning" style="margin-bottom: 0px!important;">
										<option value="">Select Department</option>
										<option value="">Department-1</option>
										<option value="">Department-2</option>
										<option value="">Department-3</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">9:30&nbsp;AM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-2.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Cardiologist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">9:30&nbsp;AM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>
							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">9:30&nbsp;AM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>
							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-2.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Cardiologist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">9:30&nbsp;AM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>
							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.pharmacy-collection-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">9:30&nbsp;AM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>
							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card border-0 bg-transparent-black mt-0 mb-3">
				<div class="card-body p-2">
					<div class="card-title">
						<div class="form-row justify-content-between align-items-center">
							<div class="col-md-6">
								<h6 class="mb-0">Consultant - Evening <span>(10-Jun-2020)</span></h6>
							</div>
							<div class="col-md-6">
								<div class="form-group m-0" style="margin-bottom: 0px!important;">
									<select class="form-control custom-form" id="department_wise_filter_evening" name="department_wise_filter_evening" style="margin-bottom: 0px!important;">
										<option value="">Select Department</option>
										<option value="">Department-1</option>
										<option value="">Department-2</option>
										<option value="">Department-3</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor" >
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">6:30&nbsp;PM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>
							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-2.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Cardiologist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">6:30&nbsp;PM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">6:30&nbsp;PM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-2.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Cardiologist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">6:30&nbsp;PM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>

					<div class="intro-x bg-transparent-black mt-1 open-modal" data-modal="common-modal-md" data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
						<div class="box items-center zoom-in display-flex">
							<div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
								<img alt="Midone Tailwind HTML Admin Template" src="{{ asset('images/doc-1.png') }}">
							</div>
							<div class="ml-4 mr-auto">
								<div class="font-medium"><b>Denzel Washington</b></div>
								<div class="text-gray-600 text-xs"><span>Dentist</span></div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Time</div>
								<div class="font-medium">6:30&nbsp;PM</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Appointment</div>
								<div class="font-medium">25</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Sale</div>
								<div class="font-medium">0,00,000</div>
							</div>

							<div class="ml-4 mr-auto">
								<div class="text-gray-600 text-xs">Collection</div>
								<div class="font-medium">0,00,000</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid bottom-section">
	<div class="form-row">
		<div class="col-md-6 text-center align-items-center">
			<div class="card border-0 bg-transparent-white mt-0">
				<div class="card-body p-2">
					<h4 class="mb-0 bg-flat-color-5 p-1">Accounts</h4>
					<div class="chart-wrapper px-0 text-center align-items-center" style="height:260px; padding: 20px;">
						<canvas id="account"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6 text-center align-items-center">
			<div class="card border-0 bg-transparent-white mt-0">
				<div class="card-body p-2">
					<h4 class="mb-0 bg-flat-color-5 p-1">Human Resource</h4>
					<div class="chart-wrapper px-0 text-center align-items-center" style="height:260px; padding: 20px;">
						<canvas id="hr_admin"></canvas>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-12">
			<div class="card mt-0 border-0 shadow-sm">
				<div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
					<h6 class="mb-0">Marketing Report</h6>
					<h6 class="mb-0">This Month (November)</h6>
				</div>
				<div class="card-body p-2">
					<table class="table dashboard-table table-bordered table-hover mb-0">
						<thead class="bg-flat-color-10">
							<tr>
								<th class="text-left">Marketing Executive</th>
								<th class="text-left">Activities</th>
								<th class="text-left">Note</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-left">Ali ahmed</td>
								<td class="text-left">Leaflet distribution,Facebook Post</td>
								<td class="text-left"></td>
							</tr>

							<tr>
								<td class="text-left">Kamal</td>
								<td class="text-left">SMS Marketing</td>
								<td class="text-left"></td>
							</tr>
							<tr>
								<td class="text-left">Robi</td>
								<td class="text-left">Doctor visit, MIC scheduled</td>
								<td class="text-left">proposal for chamber</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card mt-0 border-0 shadow-sm">
				<div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
					<h6 class="mb-0">Purchase Requisition</h6>
					<h6 class="mb-0">This Month (November)</h6>
				</div>
				<div class="card-body p-2">
					<table class="table dashboard-table table-bordered table-hover mb-0">
						<thead class="bg-flat-color-10">
							<tr>
								<th class="text-center">Requisition ID</th>
								<th class="text-left">By</th>
								<th class="text-center">Date</th>
								<th class="text-left">Item Description</th>
								<th class="text-right">Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>
							<tr>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>
							<tr>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card mt-0 border-0 shadow-sm">
				<div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
					<h6 class="mb-0">Purchase</h6>
					<h6 class="mb-0">This Month (November)</h6>
				</div>
				<div class="card-body p-2">
					<table class="table dashboard-table table-bordered table-hover mb-0">
						<thead class="bg-flat-color-10">
							<tr>
								<th class="text-center">Purchase ID</th>
								<th class="text-center">Requisition ID</th>
								<th class="text-left">By</th>
								<th class="text-center">Date</th>
								<th class="text-left">Item Description</th>
								<th class="text-right">Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">Parchase-01235</td>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>
							<tr>
								<td class="text-center">Parchase-01235</td>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>
							<tr>
								<td class="text-center">Parchase-01235</td>
								<td class="text-center">Req-01235</td>
								<td class="text-left">Alif Hasan</td>
								<td class="text-center">24/11/2020</td>
								<td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, laborum.</td>
								<td class="text-right">20,000 <small>Tk</small></td>
							</tr>


						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{{-- <script src="{{ asset('dashboard/vendors/chart.js/dist/Chart.bundle.min.js')}}"></script> --}}
{{-- <script src="{{ asset('dashboard/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/widgets.js') }}"></script> --}}


<script>
	$("#sidebar-left").addClass("active");
	$("#content").addClass("active");

	$('.input-daterange').datepicker({
		format: 'dd/mm/yyyy',
		// autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});



	var ctx = document.getElementById( "hr_admin" );
	var myChart = new Chart( ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [3000, 600, 200, 80, 120, 1300],
				backgroundColor: [
				'rgba(255, 99, 132, 0.9)',
				'rgba(54, 162, 235, 0.9)',
				'rgba(255, 206, 86, 0.9)',
				'rgba(75, 192, 192, 0.9)',
				'rgba(153, 102, 255, 0.9)',
				'rgba(255, 159, 64, 0.9)'
				],

				borderWidth: '0.5',
			}],

			labels: ['Total Manpower', 'Late', 'Absent', 'Leave', 'Sick', 'Offday'],
		},

		options: {
			maintainAspectRatio: false,
			legend: {
				display: true,
				position:'left',
				// align:
			},
		}
	} );

	var ctx = document.getElementById( "account" );
	var myChart = new Chart( ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [30000, 60000, 20000, 8000, 12000, 130000],
				backgroundColor: [
				'rgba(255, 99, 132, 0.9)',
				'rgba(54, 162, 235, 0.9)',
				'rgba(255, 206, 86, 0.9)',
				'rgba(75, 192, 192, 0.9)',
				'rgba(153, 102, 255, 0.9)',
				'rgba(255, 159, 64, 0.9)'
				],

				borderWidth: '0.5',
			}],

			labels: ['Investigation', 'IPD-Collection', 'Pharmacy Collection', 'Ambulance', 'Others Collection', 'Total Collection'],
		},

		options: {
			maintainAspectRatio: false,
			legend: {
				display: true,
				position:'left',
			},
		}
	} );




</script>
