<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .card {
        margin-bottom: .6rem;
        border-radius: 0;
    }

    .card-body {
        padding: 1.25rem;
    }

    .text-decoration-underline {
        text-decoration: underline;
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
        background-color: rgba(0, 0, 0, .2);
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

    .h-10 {
        height: 2.5rem;
    }

    .w-20 {
        width: 5rem;
    }

    .h-20 {
        width: 5rem;
    }

    .overflow-hidden {
        overflow: hidden;
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

    .top-section {
        background: url({{ asset('images/bg1.png') }}) !important;
    }

    /*.dashboard-table.table {
        color: #ffffff !important;
    }
    .dashboard-table .table-bordered th,
    .dashboard-table .table-bordered td {
        border: 1px solid #c3e0ff45!important;
        }*/

    .custom-form {
        background-color: #f5f8fa3d !important;
        color: #d8d8d8 !important;
        border: 1px solid #e1e8ee8c !important;
    }

    .custom-form::placeholder {
        color: #fff;
    }

    .custom-form:focus {
        /*text-shadow:0 1px 0 rgba(0,0,0,0.4)!important;*/
        color: #222 !important;
    }

    .consultant-img {
        width: 60px;
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
                {{-- <div class="col-md-2"> --}}
                {{-- <button class="btn btn-success btn-block btn-md date_piker"><i --}}
                {{-- class="fas fa-calendar-day"></i>&nbsp;Today --}}
                {{-- </button> --}}
                {{-- </div> --}}

                {{-- <div class="col-md-3"> --}}
                {{-- <div class="form-group m-0"> --}}
                {{-- <select class="form-control" id="select_time" name="select_time"> --}}
                {{-- <option value="">Yesterday</option> --}}
                {{-- <option value="">This Week</option> --}}
                {{-- <option value="">This Month</option> --}}
                {{-- <option value="">This Year</option> --}}
                {{-- </select> --}}
                {{-- </div> --}}
                {{-- </div> --}}
                {{-- <div class="col-md-4"> --}}
                {{-- <div class="form-group m-0"> --}}
                {{-- <div class="input-group input-daterange"> --}}
                {{-- <div class="input-group-prepend"> --}}
                {{-- <div class="input-group-text">From</div> --}}
                {{-- </div> --}}
                {{-- <input type="text" class="form-control form-control-sm m-0 date_picker" --}}
                {{-- id="dashboard_date_from" name="start" value="" placeholder="dd/mm/yyyy"> --}}
                {{-- <div class="input-group-prepend"> --}}
                {{-- <div class="input-group-text">To</div> --}}
                {{-- </div> --}}
                {{-- <input type="text" class="form-control form-control-sm m-0 date_picker" --}}
                {{-- id="dashboard_date_to" name="end" value="" placeholder="dd/mm/yyyy"> --}}
                {{-- </div> --}}
                {{-- </div> --}}
                {{-- </div> --}}

                <div class="col-md-2 d-none">
                    <a href="{{ route('dashboard.refresh') }}" class="btn btn-success btn-block btn-md"><i
                            class="fa fa-sync"></i> Refresh</a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row  mt-3">
        <div class="col-md-12">
            <div class="card bg-transparent-black border-0 bg-transparent-black mt-0">
                <div class="card-body p-2 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 font-weight-bold">Accounts</h5>
                    <h6 class="mb-0">This Month ({{ date('M') }})</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 bg-transparent-black mt-0">
                <div class="row mr-0 ml-0 bg-transparent-black">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        @php
                            $investigation_data = isset($dashboard_data['ROW01COL01T']) ? explode('_', $dashboard_data['ROW01COL01T']) : [];
                        @endphp
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">
                                {{ isset($investigation_data[1]) ? $investigation_data[1] : '0.00' }}</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', '1') }}"
                                data-title="Investigation">
                                {{ !empty($investigation_data[0]) ? number_format($investigation_data[0], 2) : 0 }}
                            </h4>
                            @php
                                $investigation_last_data = !empty($dashboard_data['ROW01COL01B']) ? explode('_', $dashboard_data['ROW01COL01B']) : [];
                            @endphp
                            <span class="mb-0 text-white">
                                <span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($investigation_last_data[0]) ? number_format($investigation_last_data[0], 2) : '0.00' }}</span>
                                {{ !empty($investigation_last_data[1]) ? $investigation_last_data[1] : '' }}</span>
                        </div>
                    </div>
                    @php
                        $ipd_collection_data = !empty($dashboard_data['ROW01COL02T']) ? explode('_', $dashboard_data['ROW01COL02T']) : [];
                    @endphp
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">
                                {{ !empty($ipd_collection_data[1]) ? $ipd_collection_data[1] : '' }}</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', '2') }}"
                                data-title="IPD-Collection">

                                {{ !empty($ipd_collection_data[0]) ? number_format($ipd_collection_data[0], 2) : 0.0 }}
                            </h4>
                            @php
                                $ipd_last_month_collection_data = isset($dashboard_data['ROW01COL02B']) ? explode('_', $dashboard_data['ROW01COL02B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($ipd_last_month_collection_data[0]) ? number_format($ipd_last_month_collection_data[0], 2) : '0.00' }}</span>
                                {{ !empty($ipd_last_month_collection_data[1]) ? $ipd_last_month_collection_data[1] : '' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        @php
                            $pharmacy_data = !empty($dashboard_data['ROW01COL03T']) ? explode('_', $dashboard_data['ROW01COL03T']) : [];
                        @endphp
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">{{ isset($pharmacy_data[1]) ? $pharmacy_data[1] : '0.00' }}
                            </p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal"
                                data-action="{{ route('dashboard.investigation-popup', '3') }}"
                                data-title="Pharmacy Collection">
                                {{ !empty($pharmacy_data[0]) ? $pharmacy_data[0] : '0.00' }}</h4>
                            @php
                                $last_month_pharmacy_data = !empty($dashboard_data['ROW01COL03B']) ? explode('_', $dashboard_data['ROW01COL03B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i>
                                    {{ !empty($last_month_pharmacy_data[0]) ? number_format($last_month_pharmacy_data[0], 2) : '0.00' }}

                                </span>
                                {{ !empty($last_month_pharmacy_data[1]) ? $last_month_pharmacy_data[1] : '0.00' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $ambulance_data = !empty($dashboard_data['ROW01COL04T']) ? explode('_', $dashboard_data['ROW01COL04T']) : [];
                            @endphp
                            <p class="mb-1 text-white">{{ !empty($ambulance_data[1]) ? $ambulance_data[1] : '0.00' }}
                            </p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', '4') }}"
                                data-title="Ambulance Collection">
                                {{ !empty($ambulance_data[0]) ? number_format($ambulance_data[0], 2) : '0.00' }}</h4>
                            @php
                                $last_month_data = !empty($dashboard_data['ROW01COL04B']) ? explode('_', $dashboard_data['ROW01COL04B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($last_month_data[0]) ? number_format($last_month_data[0], 2) : '0.00' }}</span>
                                {{ !empty($last_month_data[1]) ? $last_month_data[1] : '0.00' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $others_data = !empty($dashboard_data['ROW01COL05T']) ? explode('_', $dashboard_data['ROW01COL05T']) : [];
                            @endphp
                            <p class="mb-1 text-white">{{ !empty($others_data[1]) ? $others_data[1] : '0.00' }}</p>
                            <h4 class="mb-1 cursor-pointer font-weight-bold text-white my-2 open-modal"
                                data-modal="common-modal-md"
                                data-action="{{ route('dashboard.investigation-popup', '5') }}"
                                data-title="Others Collection">
                                {{ !empty($others_data[0]) ? number_format($others_data[0], 2) : '0.00' }}</h4>
                            @php
                                $last_month_others_data = !empty($dashboard_data['ROW01COL05B']) ? explode('_', $dashboard_data['ROW01COL05B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i>
                                    {{ !empty($last_month_others_data[0]) ? number_format($last_month_others_data[0], 2) : '0.00' }}</span>
                                {{ !empty($last_month_others_data[1]) ? $last_month_others_data[1] : '0.00' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
                        <div class="card-body text-center">
                            @php
                                $total_month_collection_data = !empty($dashboard_data['ROW01COL06T']) ? explode('_', $dashboard_data['ROW01COL06T']) : [];
                            @endphp
                            <p class="mb-1 text-white">
                                {{ !empty($total_month_collection_data[1]) ? $total_month_collection_data[1] : '0.00' }}
                            </p>
                            <h4 class="mb-1 font-weight-bold text-white my-2">
                                {{ !empty($total_month_collection_data[0]) ? number_format($total_month_collection_data[0], 2) : '' }}
                            </h4>
                            @php
                                $last_month_total_collection_data = !empty($dashboard_data['ROW01COL06B']) ? explode('_', $dashboard_data['ROW01COL06B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($last_month_total_collection_data[0]) ? number_format($last_month_total_collection_data[0], 2) : '0.00' }}</span>
                                {{ !empty($last_month_total_collection_data[1]) ? $last_month_total_collection_data[1] : '' }}</span>
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
                    <h6 class="mb-0">Today ({{ date('d-m-Y') }})</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 bg-transparent-black mt-0">
                <div class="row mr-0 ml-0 bg-transparent-black">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        @php
                            $total_manpower_data = !empty($dashboard_data['ROW02COL01T']) ? explode('_', $dashboard_data['ROW02COL01T']) : [];
                        @endphp
                        <div class="card-body text-center">
                            <p class="mb-1 text-white">
                                {{ !empty($total_manpower_data[1]) ? $total_manpower_data[1] : '' }}</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-title="total Employees">
                                {{ !empty($total_manpower_data[0]) ? number_format($total_manpower_data[0], 2) : '0' }}
                            </h4>
                            @php
                                $last_total_manpower_data = !empty($dashboard_data['ROW02COL01B']) ? explode('_', $dashboard_data['ROW02COL01B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($last_total_manpower_data[0]) ? number_format($last_total_manpower_data[0], 2) : '0' }}</span>
                                {{ !empty($last_total_manpower_data[1]) ? $last_total_manpower_data[1] : '' }}</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $late_manpower_data = !empty($dashboard_data['ROW02COL02T']) ? explode('_', $dashboard_data['ROW02COL02T']) : [];
                            @endphp
                            <p class="mb-1 text-white">
                                {{ !empty($late_manpower_data[1]) ? $late_manpower_data[1] : '' }}</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ !empty($late_manpower_data[0]) ? number_format($late_manpower_data[0], 2) : '0' }}
                            </h4>
                            @php
                                $last_late_manpower_data = !empty($dashboard_data['ROW02COL02B']) ? explode('_', $dashboard_data['ROW02COL02B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($last_late_manpower_data[0]) ? number_format($last_late_manpower_data[0], 2) : '0' }}</span>
                                {{ !empty($last_late_manpower_data[1]) ? $last_late_manpower_data[1] : '' }}</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $total_absent_data = !empty($dashboard_data['ROW02COL03T']) ? explode('_', $dashboard_data['ROW02COL03T']) : [];
                            @endphp
                            <p class="mb-1 text-white">
                                {{ !empty($total_absent_data[1]) ? $total_absent_data[1] : '' }}</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '5') }}"
                                data-title="Absent Employees">
                                {{ !empty($total_absent_data[0]) ? number_format($total_absent_data[0], 2) : '0' }}
                            </h4>
                            @php
                                $last_month_total_absent_data = !empty($dashboard_data['ROW02COL03B']) ? explode('_', $dashboard_data['ROW02COL03B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i>
                                    {{ !empty($last_month_total_absent_data[0]) ? number_format($last_month_total_absent_data[0], 2) : '0' }}</span>
                                {{ !empty($last_month_total_absent_data[1]) ? $last_month_total_absent_data[1] : '' }}</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $total_leave_data = !empty($dashboard_data['ROW02COL04T']) ? explode('_', $dashboard_data['ROW02COL04T']) : [];
                            @endphp
                            <p class="mb-1 text-white">{{ !empty($total_leave_data[1]) ? $total_leave_data[1] : '' }}
                            </p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '3') }}" data-title="Leave Employees">
                                {{ !empty($total_leave_data[0]) ? number_format($total_leave_data[0], 2) : '0' }}
                            </h4>
                            @php
                                $last_month_total_leave_data = !empty($dashboard_data['ROW02COL04B']) ? explode('_', $dashboard_data['ROW02COL04B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ !empty($last_month_total_leave_data[0]) ? number_format($last_month_total_leave_data[0], 2) : '0' }}</span>
                                {{ !empty($last_month_total_leave_data[1]) ? $last_month_total_leave_data[1] : '' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">
                            @php
                                $total_sick_collection_data = isset($dashboard_data['ROW02COL5T']) ? explode('_', $dashboard_data['ROW02COL5T']) : [];
                            @endphp
                            <p class="mb-1 text-white">
                                {{ isset($total_sick_collection_data[1]) ? $total_sick_collection_data[1] : '0' }}
                            </p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', 'SICK') }}"
                                data-title="Sick Employees">
                                {{ isset($total_sick_collection_data[0]) ? $total_sick_collection_data[0] : '0' }}
                            </h4>
                            @php
                                $last_total_sick_collection_data = isset($dashboard_data['ROW02COL5B']) ? explode('_', $dashboard_data['ROW02COL5B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-danger"><i
                                        class="fa fa-caret-down  mr-1"></i>
                                    {{ isset($last_total_sick_collection_data[0]) ? $last_total_sick_collection_data[0] : '0' }}</span>
                                {{ isset($last_total_sick_collection_data[1]) ? $last_total_sick_collection_data[1] : '' }}</span>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
                        <div class="card-body text-center">
                            @php
                                $total_offday_data = isset($dashboard_data['ROW02COL6T']) ? explode('_', $dashboard_data['ROW02COL6T']) : [];
                            @endphp
                            <p class="mb-1 text-white">
                                {{ isset($total_offday_data[1]) ? $total_offday_data[1] : '' }}</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '6') }}"
                                data-title="Offday Employees">
                                {{ isset($total_offday_data[0]) ? $total_offday_data[0] : '0' }}</h4>
                            @php
                                $last_month_total_offday_data = isset($dashboard_data['ROW02COL6B']) ? explode('_', $dashboard_data['ROW02COL6B']) : [];
                            @endphp
                            <span class="mb-0 text-white"><span class="text-green-highlight"><i
                                        class="fa fa-caret-up  mr-1"></i>
                                    {{ isset($last_month_total_offday_data[0]) ? $last_month_total_offday_data[0] : '0' }}</span>
                                {{ isset($last_month_total_offday_data[1]) ? $last_month_total_offday_data[1] : '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bottom-section">
    <div class="form-row consultant">
        <div class="col-md-8">
            <div class="card border-0 mb-3 shadow-sm overflow-hidden">
                <div class="card-title align-items-center justify-content-between mb-0 bg-flat-color-15">
                    <div class="form-row justify-content-between align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0">Consultant <span class="text-green-highlight"> <i>(
                                        {{ $consultant_data_count }} )</i> </span>
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <input type="text" class="form-control date_picker" name="consultant_date"
                                id="consultant_date" autocomlete="off" placeholder="Consultant Date" value="" />
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-0" style="margin-bottom: 0px!important;">
                                <select class="form-control font_size_12 m-auto  select2 required" id="service_factor"
                                    name="service_factor" required>
                                    <option value="">Select Service Unit</option>
                                    @if (!empty($service_unit))
                                        @foreach ($service_unit as $service)
                                            <option value="{{ $service->serviceunit_no_pk }}">
                                                {{ strtoupper($service->serviceunit_name) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group m-0" style="margin-bottom: 0px!important;">
                                <select class="form-control font_size_12 m-auto  select2 required" id="shift_factor"
                                    name="shift_factor" required>
                                    <option value="">Select Shift</option>
                                    @if (!empty($shift))
                                        @foreach ($shift as $shift)
                                            <option value="{{ $shift->shift_no_pk }}">

                                                {{ strtoupper($shift->shift_code) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <table class="table dashboard-table table-bordered table-hover mb-0 datatable">
                        <thead class="bg-flat-color-10">
                            <tr>
                                <th class="text-left">Consultant</th>
                                <th class="text-left">Appointment Date</th>
                                <th class="text-center">In Time</th>
                                <th class="text-center">Out Time</th>
                                {{-- <th class="text-center">Appointment</th> --}}
                                <th class="text-right">Sale</th>
                                <th class="text-right">Collection</th>
                            </tr>
                        </thead>
                        <tbody id="consultant_data">
                            @include('admin.dashboards.consultant_data')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-transparent-white">
                <div class="card-body p-2 text-center">
                    <h4 class="mb-0 bg-flat-color-5 p-1">Consultant</h4>
                    <div class="chart-wrapper px-0 text-center align-items-center"
                        style="height:260px; padding: 20px;">
                        <canvas id="consultant"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6 text-center align-items-center">
            <div class="card border-0 bg-transparent-white mt-0">
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
            <div class="card border-0 bg-transparent-white mt-0">
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
            <div class="card mt-0 border-0 shadow-sm">
                <div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
                    <h6 class="mb-0">Marketing Report</h6>
                    <h6 class="mb-0">This Month ({{ Date('M') }})</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table dashboard-table table-bordered table-hover mb-0 datatable">
                        <thead class="bg-flat-color-10">
                            <tr>
                                <th class="text-center">Marketing Executive</th>
                                <th class="text-center">Activity Date</th>
                                <th class="text-center">Activities</th>
                                <th class="text-center">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('admin.dashboards.marking_data_list')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-0 border-0 shadow-sm">
                <div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
                    <h6 class="mb-0">Purchase Requisition</h6>
                    <h6 class="mb-0">This Month ({{ Date('M') }})</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table dashboard-table table-bordered table-hover mb-0 datatable1">
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
                            <tr id="purchase_requisition">
                                @include('admin.dashboards.purchase_requisition_list')
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-0 border-0 shadow-sm">
                <div class="card-title d-flex align-items-center justify-content-between mb-0 bg-secondary">
                    <h6 class="mb-0">Purchase Order</h6>
                    <h6 class="mb-0">This Month ({{ date('M') }})</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table dashboard-table table-bordered table-hover mb-0 datatable2">
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
                            <div id="purchase_order_list">
                                @include('admin.dashboards.purchase_order_list')
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- pie chart --}}
{{-- <input type="hidden" class="hidden" id="pie_hide" value="pie_hide"> --}}

<script type="application/javascript" src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script>
{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>



<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    // $('.datatable').DataTable({
    //     searching: false,
    //     ordering: false
    // });
    // $('.datatable').DataTable({
    //     "lengthMenu": [
    //         [5],
    //         [5]
    //     ]
    // });
    // $('.datatable1').DataTable({
    //     "lengthMenu": [
    //         [5],
    //         [5]
    //     ]
    // });
    $('.datatable2').DataTable({
        "lengthMenu": [
            [5],
            [5]
        ]
    });
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(function() {
        $('.date_picker').datepicker({
            // format: 'dd/mm/yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true
        });
    })

    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy',
        // autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    // for date data

    $(document).on("change", "#consultant_date", function(e) {
        var date_value = $(this).val();
        // var shift = $('#shift_factor').val();
        // var service = $('#service_factor').val();
        // var formAction = $("#frmSearch").attr("action");
        // alert(grade_value);

        $.ajax({
            url: "{{ route('dashboard.date-data') }}",
            type: 'GET',
            data: {
                date_value: date_value
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#consultant_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    // for shift
    $(document).on("change", "#shift_factor", function(e) {
        var shift_value = $(this).val();
        // var formAction = $("#frmSearch").attr("action");
        // alert(grade_value);

        $.ajax({
            url: "{{ route('dashboard.shift-data') }}",
            type: 'GET',
            data: {
                shift_value: shift_value
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#consultant_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    // for su


    $(document).on("change", "#service_factor", function(e) {
        var service_value = $(this).val();
        // var formAction = $("#frmSearch").attr("action");
        // alert(grade_value);

        $.ajax({
            url: "{{ route('dashboard.service-unit-data') }}",
            type: 'GET',
            data: {
                service_value: service_value
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#consultant_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    // Consultant Pie

    var jsonfile1 = {
        "jsonarray": @php echo $consultant_chart_data @endphp
    };

    var labels = jsonfile1.jsonarray.map(function(e) {
        return e.shift_code;
    });

    var consultant_data = jsonfile1.jsonarray.map(function(e) {
        return e.total_app;
    });


    var ctx = document.getElementById("consultant");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: consultant_data,
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

            labels: labels,
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

    // HR Pie
    var jsonfile4 = {
        "jsonarray": @php echo $hr_chart_data @endphp
    };
    var total_manpower = jsonfile4.jsonarray.map(function(e) {
        return e.total_emp;
    });
    var attend = jsonfile4.jsonarray.map(function(e) {
        return e.attend;
    });
    var late = jsonfile4.jsonarray.map(function(e) {
        return e.late;
    });
    var leave = jsonfile4.jsonarray.map(function(e) {
        return e.leave;
    });
    var lwp = jsonfile4.jsonarray.map(function(e) {
        return e.lwp;
    });
    var absent = jsonfile4.jsonarray.map(function(e) {
        return e.absent;
    });
    var off_day = jsonfile4.jsonarray.map(function(e) {
        return e.dayoff;
    });

    if (total_manpower != '') {
        var ctx = document.getElementById("hr_admin");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [total_manpower,
                        attend,
                        late,
                        leave,
                        lwp,
                        absent,
                        off_day
                    ],
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

                labels: ['Total Manpower', 'Attend', 'Late', 'Leave', 'LWP', 'Absent',
                    'Offday'
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
    } else {
        var ctx = document.getElementById("hr_admin");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [650,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0
                    ],
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

                labels: ['Total Manpower', 'Attend', 'Late', 'Leave', 'LWP', 'Absent',
                    'Offday'
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
    }

    // Account
    var jsonfile3 = {
        "jsonarray": @php echo $account_pie_chart @endphp
    };
    var investigation_data = jsonfile3.jsonarray.map(function(e) {
        return e.investigation;
    });
    var ipd_data = jsonfile3.jsonarray.map(function(e) {
        return e.ipd;
    });
    var pharmacy_data = jsonfile3.jsonarray.map(function(e) {
        return e.pharmacy;
    });
    var ambulance_data = jsonfile3.jsonarray.map(function(e) {
        return e.ambulance;
    });
    var other_data = jsonfile3.jsonarray.map(function(e) {
        return e.other;
    });
    var total_collection_data = jsonfile3.jsonarray.map(function(e) {
        return e.total_collection;
    });
    //alert(investigation_data);

    if (investigation_data != 0 && investigation_data != '') {
        var ctx = document.getElementById("account");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [investigation_data,
                        ipd_data,
                        pharmacy_data,
                        ambulance_data,
                        other_data,
                        total_collection_data
                    ],
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

                labels: ['Investigation', 'IPD-Collection', 'Pharmacy Collection', 'Ambulance',
                    'Others Collection',
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

    } else {
        var ctx = document.getElementById("account");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [100,
                        0,
                        0,
                        0,
                        0,
                        0
                    ],
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

                labels: ['Investigation', 'IPD-Collection', 'Pharmacy Collection', 'Ambulance',
                    'Others Collection',
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
    }
</script>
