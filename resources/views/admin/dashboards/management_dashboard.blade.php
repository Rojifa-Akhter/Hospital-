<style>
    .card {
        margin-bottom: .6rem;
        border-radius: 0;
    }

    .card-body {
        padding: 1.25rem;
    }

    .value {
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
    .opd_consultation h4 {
        font-size: 1rem !important;
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
        overflow-y: auto !important;
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
        background-color: rgba(247, 247, 247, .25) !important;
    }

    .align-self-center {
        -ms-flex-item-align: center !important;
        align-self: center !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .widget-box-two {
        position: relative;
    }

    .avatar {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
    }

    .shortcut-buttons a {
        text-decoration: none;
    }

    .custom-box-button {
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

    .custom-box-button:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 0px;
        width: 100%;
        background: #00c6ff;
        background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
        background: linear-gradient(to right, #0072ff, #00c6ff);
        z-index: -1;
        transition: all 0.3s;
    }

    .custom-box-button:hover:before {
        height: 100%;
    }

    .card-title {
        margin-bottom: 0.75rem;
        /*background-color: #0072ffba;*/
        background-color: #176e92;
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
        background-color: #fff;
        background-color: rgba(255, 255, 255, var(--bg-opacity));
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

    .image-fit>img {
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

    .cursor-pointer {
        cursor: pointer;
    }

</style>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm align-items-center justify-content-between py-1">
        <div class="col-md-3">
            <h5 class="mb-0">Management Dashboard</h5>
            <small>Home / Management Dashboard</small>
        </div>
        <div class="col-md-9">
            <div class="form-row justify-content-end mt-2">
                <div class="col-md-2">
                    <button class="btn btn-success btn-block btn-md"><i
                            class="fas fa-calendar-day"></i>&nbsp;Today</button>
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
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="dashboard_date_from" name="start" value="" placeholder="dd/mm/yyyy">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="dashboard_date_to" name="end" value="" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="form-row mt-3">
		<div class="col-md-6 col-lg-3">
			<div class="card text-white bg-flat-color-1 mt-0 border-0">
				<div class="card-body pb-0">
					<div class="dropdown float-right">
						<button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton1" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<div class="dropdown-menu-content">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<h4 class="mb-0">
						<span class="count">10468</span>
					</h4>
					<p class="text-light">Service Person</p>

					<div class="chart-wrapper px-0" style="height:70px;" height="70">
						<canvas class="widgetChart1"></canvas>
					</div>

				</div>

			</div>
		</div>

		<div class="col-md-6 col-lg-3">
			<div class="card text-white bg-flat-color-2 mt-0 border-0">
				<div class="card-body pb-0">
					<h4 class="mb-0">
						<span class="count">10468</span>
					</h4>
					<p class="text-light">Family Member</p>

					<div class="chart-wrapper px-0" style="height:70px;" height="70">
						<canvas class="widgetChart2"></canvas>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-6 col-lg-3">
			<div class="card text-white bg-flat-color-3 mt-0 border-0">
				<div class="card-body pb-0">
					<h4 class="mb-0">
						<span class="count">10468</span>
					</h4>
					<p class="text-light"e>CNE/RE Patient</p>

				</div>

				<div class="chart-wrapper px-0" style="height:70px;" height="70">
					<canvas class="widgetChart3"></canvas>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-lg-3">
			<div class="card text-white bg-flat-color-4 mt-0 border-0">
				<div class="card-body pb-0">
					<h4 class="mb-0">
						<span class="count">10468</span>
					</h4>
					<p class="text-light">Active Doctors</p>

					<div class="chart-wrapper px-3" style="height:70px;" height="70">
						<canvas class="widgetChart4"></canvas>
					</div>

				</div>
			</div>
		</div>
	</div> --}}

    <div class="form-row  mt-3">
        <div class="col-md-12">
            <div class="card shadow-xs border-0 bg-flat-color-13 mt-0">
                <div class="card-body p-2 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 font-weight-bold">Accounts</h5>
                    <h6 class="mb-0">This Month (November)</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 shadow-xs bg-white mt-0">
                <div class="row mr-0 ml-0 bg-geadient-color-7">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Investigation</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal data_id"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', 1) }}"
                                data-title="Investigation" data_id="1">
                                00,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 00,000</span> Last month</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">IPD-Collection</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', 2) }}"
                                data-title="IPD-Collection">00,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 00,000</span> Last month</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Pharmacy Collection</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', 3) }}"
                                data-title="Pharmacy Collection">00,000</h4>
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i> 00,000</span> Last month</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Ambulance</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', 4) }}"
                                data-title="Ambulance Collection">0,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 0,000</span> Last month</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Others Collection</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', 5) }}"
                                data-title="Others Collection">00,000</h4>
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i> 00,000</span> Last month</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Total Collection</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">0,00,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 0,00,000</span> Last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card shadow-xs border-0 mt-0 bg-flat-color-13">
                <div class="card-body p-2 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 font-weight-bold">Human Resource</h5>
                    <h6 class="mb-0">Today (23/11/2020)</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 shadow-xs bg-white mt-0">
                <div class="row mr-0 ml-0 bg-geadient-color-8">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Total Manpower</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">0,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 0,000</span> Last Year</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Late</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 000</span> Last Day</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Absent</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">000</h4>
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i> 000</span> Last Day</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Leave</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">00</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 00</span> Last Day</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Sick</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">000</h4>
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i> 000</span> Last Day</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">Offday</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2">0,000</h4>
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i> 0,000</span> Last Day</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-body p-2">
                    <div class="card-title">
                        <div class="form-row justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-0">Consultant - Morning <span>(10-Jun-2020)</span></h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-0" style="margin-bottom: 0px!important;">
                                    <select class="form-control" id="department_wise_filter_morning"
                                        name="department_wise_filter_morning" style="margin-bottom: 0px!important;">
                                        <option value="">Select Department</option>
                                        <option value="">Department-1</option>
                                        <option value="">Department-2</option>
                                        <option value="">Department-3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.pharmacy-collection-popup') }}" data-title="Doctor">
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
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-body p-2">
                    <div class="card-title">
                        <div class="form-row justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-0">Consultant - Evening <span>(10-Jun-2020)</span></h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-0" style="margin-bottom: 0px!important;">
                                    <select class="form-control" id="department_wise_filter_evening"
                                        name="department_wise_filter_evening" style="margin-bottom: 0px!important;">
                                        <option value="">Select Department</option>
                                        <option value="">Department-1</option>
                                        <option value="">Department-2</option>
                                        <option value="">Department-3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

                    <div class="intro-x shadow-xs mt-1 open-modal" data-modal="common-modal-md"
                        data-action="{{ route('dashboard.doctor-popup') }}" data-title="Doctor">
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

    <div class="form-row">
        <div class="col-md-6 text-center align-items-center">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-body p-2">
                    <h4 class="mb-0 bg-flat-color-5 p-1">Accounts</h4>
                    <div class="chart-wrapper px-0 text-center align-items-center"
                        style="height:260px; padding: 20px;">
                        <canvas id="account"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-center align-items-center">
            <div class="card border-0 shadow-xs mt-0">
                <div class="card-body p-2">
                    <h4 class="mb-0 bg-flat-color-5 p-1">Human Resource</h4>
                    <div class="chart-wrapper px-0 text-center align-items-center"
                        style="height:260px; padding: 20px;">
                        <canvas id="hr_admin"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card mt-0 border-0 shadow-xs">
                <div class="card-title d-flex align-items-center justify-content-between mb-0">
                    <h6 class="mb-0">Marketing Report</h6>
                    <h6 class="mb-0">This Month (November)</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-bordered table-hover mb-0 bg-white">
                        <thead class="bg-flat-color-13">
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
            <div class="card mt-0 border-0 shadow-xs">
                <div class="card-title d-flex align-items-center justify-content-between mb-0">
                    <h6 class="mb-0">Purchase Requisition</h6>
                    <h6 class="mb-0">This Month (November)</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-bordered table-hover mb-0 bg-white">
                        <thead class="bg-flat-color-13">
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
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>
                            <tr>
                                <td class="text-center">Req-01235</td>
                                <td class="text-left">Alif Hasan</td>
                                <td class="text-center">24/11/2020</td>
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>
                            <tr>
                                <td class="text-center">Req-01235</td>
                                <td class="text-left">Alif Hasan</td>
                                <td class="text-center">24/11/2020</td>
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-0 border-0 shadow-xs">
                <div class="card-title d-flex align-items-center justify-content-between mb-0">
                    <h6 class="mb-0">Purchase</h6>
                    <h6 class="mb-0">This Month (November)</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-bordered table-hover mb-0 bg-white">
                        <thead class="bg-flat-color-13">
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
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>
                            <tr>
                                <td class="text-center">Parchase-01235</td>
                                <td class="text-center">Req-01235</td>
                                <td class="text-left">Alif Hasan</td>
                                <td class="text-center">24/11/2020</td>
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>
                            <tr>
                                <td class="text-center">Parchase-01235</td>
                                <td class="text-center">Req-01235</td>
                                <td class="text-left">Alif Hasan</td>
                                <td class="text-center">24/11/2020</td>
                                <td class="text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis, laborum.</td>
                                <td class="text-right">20,000 <small>Tk</small></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today's Appointment</div>
					<div class="value justify-content-between">
						<strong class="d-block">Appointment (<span class="count">100</span>)</strong>
						<strong class="d-block">Prescription (<span class="count">40</span>)</strong>
						<i class="fas fa-calendar-check"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today's No of Doctor</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total Doctor (<span class="count">30</span>)</strong>
						<strong class="d-block">On Duty (<span class="count">28</span>)</strong>
						<i class="fas fa-user-md"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-info" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today's Appointment vs Prescription</div>
					<div class="value justify-content-between">
						<strong class="d-block">Appointment (<span class="count">100</span>)</strong>
						<strong class="d-block">Prescription (<span class="count">55</span>)</strong>
						<i class="fas fa-file-prescription"></i>

					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-warning" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today's Admission</div>
					<div class="value justify-content-between">
						<strong class="d-block">Request (<span class="count">52</span>)</strong>
						<strong class="d-block">Admitted (<span class="count">26</span>)</strong>
						<i class="fas fa-procedures"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-mazblue" role="progressbar" style="width: 26%;" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today's Discharge</div>
					<div class="value justify-content-between">
						<strong class="d-block">Request (<span class="count">52</span>)</strong>
						<strong class="d-block">Discharged (<span class="count">25</span>)</strong>
						<i class="fas fa-eject"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-pumkin" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">LP (By Patient)</div>
					<div class="value justify-content-between">
						<strong class="d-block">Request (<span class="count">650</span>)</strong>
						<strong class="d-block">Delivered (<span class="count">361</span>)</strong>
						<i class="fas fa-file-alt"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-brown" role="progressbar" style="width: 52%;" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today OT</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">05</span>)</strong>
						<i class="fas fa-heartbeat"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-navy" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Today Investigation</div>
					<div class="value justify-content-between">
						<strong class="d-block">Pathology (<span class="count">25</span>)</strong>
						<strong class="d-block">Radiology and Imaging (<span class="count">15</span>)</strong>
						<i class="fas fa-file-contract"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-flat-color-1" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Bed Occupancy</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">10</span>)</strong>
						<i class="fas fa-bed"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-flat-color-4" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Birth</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">05</span>)</strong>
						<i class="fas fa-baby"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-flat-color-6" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}

        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">SIL/DIL</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">60</span>)</strong>
						<i class="fas fa-file-invoice"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-blue" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div> --}}

        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Deceased</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">25</span>)</strong>
						<i class="fas fa-feather-alt"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div> --}}

        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">Avg. Lenght of Stay</div>
					<div class="value justify-content-between">
						<strong class="d-block">Days (<span class="count">03</span>)</strong>
						<i class="fas fa-hospital"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-brown" role="progressbar" style="width: 52%;" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div> --}}

        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">RE/CNE Patient</div>
					<div class="value justify-content-between">
						<strong class="d-block">Admitted (<span class="count">25</span>)</strong>
						<i class="fas fa-wheelchair"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-flat-color-2" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div> --}}

        {{-- <div class="col-md-3">
			<div class="card border-0 mt-0 shadow-xs bg-white">
				<div class="card-body">
					<div class="text-muted">RE/CNE Patient Financial</div>
					<div class="value justify-content-between">
						<strong class="d-block">Total (<span class="count">5000</span>)</strong>
						<i class="fas fa-coins"></i>
					</div>
					<div class="progress progress-xs mt-2" style="height: 5px;">
						<div class="progress-bar bg-flat-color-3" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div> --}}

        {{-- <div class="form-row">
		<div class="col-xl-6">
			<div class="opd_consultation">
				<div class="card mt-0 pt-3 border-0">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4">
								<h4 class="card-title mb-0">OPD Consultation (Soldier, JCO, Officer, Civil)</h4>
								<div class="small text-muted">October 2017</div>
							</div>
							<div class="col-sm-8 hidden-sm-down">
								<button type="button" class="btn btn-primary float-right bg-flat-color-1"><i class="fas fa-cloud-download-alt"></i></button>
								<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
									<div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
										<label class="btn btn-outline-secondary">
											<input type="radio" name="options" id="option1"> Day
										</label>
										<label class="btn btn-outline-secondary active">
											<input type="radio" name="options" id="option2" checked=""> Month
										</label>
										<label class="btn btn-outline-secondary">
											<input type="radio" name="options" id="option3"> Year
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="chart-wrapper mt-4">
							<canvas id="opd_consultation" style="height:200px;" height="200"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-6">
			<div class="ipd_consultation">
				<div class="card mt-0 pt-3 border-0">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4">
								<h4 class="card-title mb-0">IPD Admission (Soldier, JCO, Officer, Civil)</h4>
								<div class="small text-muted">October 2017</div>
							</div>
							<div class="col-sm-8 hidden-sm-down">
								<button type="button" class="btn btn-primary float-right bg-flat-color-1"><i class="fas fa-cloud-download-alt"></i></button>
								<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
									<div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
										<label class="btn btn-outline-secondary">
											<input type="radio" name="options" id="option1"> Day
										</label>
										<label class="btn btn-outline-secondary active">
											<input type="radio" name="options" id="option2" checked=""> Month
										</label>
										<label class="btn btn-outline-secondary">
											<input type="radio" name="options" id="option3"> Year
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="chart-wrapper mt-4">
							<canvas id="ipd_admission" style="height:200px;" height="200"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
    </div>

    <script src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        $('.input-daterange').datepicker({
            format: 'dd/mm/yyyy',
            // autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });



        var ctx = document.getElementById("hr_admin");
        var myChart = new Chart(ctx, {
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
                    position: 'left',
                    // align:
                },
            }
        });

        var ctx = document.getElementById("account");
        var myChart = new Chart(ctx, {
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

                labels: ['Investigation', 'IPD-Collection', 'Pharmacy Collection', 'Ambulance', 'Others Collection',
                    'Total Collection'
                ],
            },

            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'left',
                },
            }
        });
    </script>
