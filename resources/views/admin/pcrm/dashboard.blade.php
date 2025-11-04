<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .bg-purple {
        background-color: #8892d6 !important;
    }

    .text-white {
        color: #fff !important;
    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .m-0 {
        margin: 0 !important;
    }

    p {
        line-height: 1.8;
    }

    .font-22 {
        font-size: 22px !important;
    }

    .font-14 {
        font-size: 14px !important;
    }

    .font-12 {
        font-size: 12px !important;
    }


    .card-body {
        min-height: 1px;
        padding: 1rem;
    }


    .card {
        margin-bottom: 24px;
    }

    .bg-purple {
        background-color: #8892d6 !important;
    }

    .bg-pink {
        background-color: #f06292 !important;
    }

    .bg-success {
        background-color: #78c350 !important;
    }

    .bg-info {
        background-color: #45bbe0 !important;
    }

    .text-white {
        color: #fff !important;
    }

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
        background-color: #0072ffba;
        padding: 7px 10px;
        color: #ffffff;
        font-weight: 500;
        font-size: 14px;
        border-radius: 5px 5px 0 0;
    }

    .white-space {
        white-space: nowrap;
    }

    .table {
        overflow-x: auto;
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
    }

    .box {
        box-shadow: 0px 3px 20px #0000000b;
        --bg-opacity: 1;
        background-color: #fff;
        background-color: rgba(255, 255, 255, var(--bg-opacity));
        border-radius: 0.375rem;
        padding: 1rem;
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

    .font-medium {
        font-weight: 500;
    }

    .text-gray-600 {
        --text-opacity: 1;
        color: #718096;
        color: rgba(113, 128, 150, var(--text-opacity));
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .text-theme-6 {
        --text-opacity: 1;
        color: #D32929;
        color: rgba(211, 41, 41, var(--text-opacity));
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

    /*	.intro-x{
  height: 80px;
  }*/

</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Dashboard</h5>
            <small>PCRM / Dashboard</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-info border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Appointment Today">
                                        Appointment Today</p>
                                    @if (count($last_day_appointment) == 0)
                                        <?php $la = 1; ?>
                                    @else
                                        <?php $la = count($last_day_appointment); ?>
                                    @endif
                                    <h2 class="text-white my-1 count"><span
                                            data-plugin="counterup">{{ count($appointments) }}</span>
                                        @if (count($appointments) > $la)
                                            <i class="fa fa-arrow-up text-white font-22"></i>
                                        @else
                                            <i class="fa fa-arrow-down text-red font-22"></i>
                                        @endif
                                    </h2>
                                    <p class="text-white m-0 font-12 ">
                                        <b>{{ number_format((float) ((count($appointments) * 100) / $la), 2, '.', '') }}%</b>
                                        From previous period
                                    </p>
                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="icofont-network-tower  font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-purple border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Followup List">Followup List
                                        <span>(7 Days)</span>
                                    </p>
                                    @if (count($last_s_followup) == 0)
                                        <?php $lfw = 1; ?>
                                    @else
                                        <?php $lfw = count($last_s_followup); ?>
                                    @endif
                                    <h2 class="text-white my-1 count"><span>{{ count($follow_up) }}</span>
                                        @if (count($follow_up) > $lfw)
                                            <i class="fa fa-arrow-up text-white font-22"></i>
                                        @else
                                            <i class="fa fa-arrow-down text-red font-22"></i>
                                        @endif
                                    </h2>
                                    <p class="text-white m-0 font-12 ">

                                        <b>{{ number_format((float) ((count($follow_up) * 100) / $lfw), 2, '.', '') }}%</b>
                                        From previous period
                                    </p>
                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="fa fa-chart-line font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-pink border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Unattendant Patient List">
                                        Unattendant Patient <span>(7 Days)</span></p>

                                    @if (count($unattendant_patients_last) == 0)
                                        <?php $upl = 1; ?>
                                    @else
                                        <?php $upl = count($unattendant_patients_last); ?>
                                    @endif
                                    <h2 class="text-white my-1 count"><span
                                            data-plugin="counterup">{{ count($unattendant_patients) }}</span>
                                        @if (count($unattendant_patients) > $upl)
                                            <i class="fa fa-arrow-up text-white font-22"></i>
                                        @else
                                            <i class="fa fa-arrow-down text-red font-22"></i>
                                        @endif
                                    </h2>
                                    <p class="text-white m-0 font-12 ">


                                        <b>{{ number_format((float) ((count($unattendant_patients) * 100) / $upl), 2, '.', '') }}%</b>
                                        From previous period
                                    </p>

                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="icofont-users-alt-5 font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card widget-box-two bg-success border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Due Patient List">Due
                                        Patient List</p>
                                    <h2 class="text-white my-1 count"><span data-plugin="counterup">854</span> <i
                                            class="fa fa-arrow-up text-white font-22"></i></h2>
                                    <p class="text-white m-0 font-12 "><b>9.9%</b> From previous period</p>
                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="icofont-users font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a href="{{ route('appointments.create') }}" rel="tab">
                                        <div class="custom-box-button m-0">
                                            <span>Instant Appointment</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('create-referral') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Add Referral</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('create-referral') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Add Agent</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('serviceunit.create') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Add Service</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#">
                                        <div class="custom-box-button">
                                            <span>Calendar</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('billing.service-billing') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Billing</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('reports.financial') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Due Report</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a href="{{ route('billing.billing-due-collection') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Due Collection</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a href="{{ route('reports.daily-collection') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Collection Report</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a href="{{ route('reports.daily-sales') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Sales Report</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a href="{{ route('doctor-schedule') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Add Doctor Schedule</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="card mb-0">
                <div class="card-body border-top">
                    <h6 class="card-title mb-1">Appointment Today <span>({{ date('d-M-Y') }})</span>
                    </h6>
                    <div class="col-12 table-responsive p-0 ">
                        <table class="table data-table table-striped table-bordered table-hover data-table appointment">
                            <thead>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr class="">
                                        <td class=" border-0">
                                            {{ $loop->iteration }}</td>
                                        <td class="ml-4 border-0">
                                            <div
                                                class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden ml-2">
                                                @if ($appointment->patient_photo)
                                                    <img alt="No Image"
                                                        src="{{ asset('images/uploads/patient_images/thumb/' . $appointment->patient_photo) }}">
                                                @else
                                                    <img alt="No Image" src="{{ asset('images/pt-patient.jpg') }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="ml-4 mr-auto">
                                                <div class="font-medium">{{ $appointment->full_name }}</div>
                                                <div class="text-gray-600 text-xs">{{ $appointment->specialization }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="ml-4 mr-auto">
                                                <div class="font-medium">{{ $appointment->patient_name }}</div>
                                                <div class="text-gray-600 text-xs">
                                                    <span>{{ Carbon\Carbon::parse($appointment->patient_dob)->age }}years</span>,
                                                    <span>{{ $appointment->gender_txt }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="ml-4 mr-auto">
                                                <div class="font-medium">{{ $appointment->mobile1 }}</div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="text-theme-6">
                                                <div class="row">
                                                    @php
                                                        $param = $appointment->patient_no_pk . '_' . $appointment->mobile1 . '_' . $appointment->patient_name . '_' . $appointment->full_name;
                                                    @endphp

                                                    @if ($appointment->call_ind == 1)
                                                        <button class="btn btn-sm bg-navy open-modal mx-1"
                                                            id="patient_app_info" data-modal="common-modal-md"
                                                            data-action="{{ route('patient.app_info', $appointment->patient_no_pk) }}"
                                                            data-title="Patient Information"
                                                            bed-attr="{{ $appointment->patient_no_pk }}">Call
                                                            Info</button>
                                                    @else
                                                        <form action="{{ route('pcrm.call-person') }}" method="post"
                                                            id="call-data">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_no_pk }}" name="id">
                                                            <input type="hidden" value="{{ $appointment->mobile1 }}"
                                                                name="mobile_num">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_name }}"
                                                                name="patient_name">
                                                            <input type="hidden"
                                                                value="{{ $appointment->full_name }}"
                                                                name="doctor_name">
                                                            {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                            <input type="hidden" value="call" name="call">
                                                            @php
                                                                $response_action = route('pcrm.pcrm-dashboard');
                                                            @endphp
                                                            <button type="button" class="btn btn-sm bg-navy mx-1"
                                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Call</button>
                                                        </form>
                                                    @endif



                                                    {{-- @if ($appointment->sms_ind == 1)
                                                        <button class="btn btn-sm bg-blue open-modal  mx-1"
                                                            id="patient_app_info" data-modal="common-modal-md"
                                                            data-action="{{ route('patient.app_info', $appointment->patient_no_pk) }}"
                                                            data-title="Patient Information"
                                                            bed-attr="{{ $appointment->patient_no_pk }}">Sms
                                                            Info</button>
                                                    @else

                                                        <form action="{{ route('pcrm.call-person') }}" method="post"
                                                            id="sms-data">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_no_pk }}" name="id">
                                                            <input type="hidden" value="{{ $appointment->mobile1 }}"
                                                                name="mobile_num">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_name }}"
                                                                name="patient_name">
                                                            <input type="hidden"
                                                                value="{{ $appointment->full_name }}"
                                                                name="doctor_name">
                                                            {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                    {{-- <input type="hidden" value="sms" name="sms">
                                                            @php
                                                                $response_action = route('pcrm.pcrm-dashboard');
                                                            @endphp
                                                            <button type="button" class="btn btn-sm bg-blue mx-1"
                                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Sms</button>
                                                        </form>
                                                    @endif --}}
                                                    @if ($appointment->sms_ind == 1)
                                                        <button class="btn btn-sm bg-blue open-modal  mx-1"
                                                            id="patient_app_info" data-modal="common-modal-md"
                                                            data-action="{{ route('patient.app_info', $appointment->patient_no_pk) }}"
                                                            data-title="Patient Information"
                                                            bed-attr="{{ $appointment->patient_no_pk }}">Sms
                                                            Info</button>
                                                    @else
                                                        <button class="btn btn-sm bg-blue mx-1 open-modal"
                                                            data-modal="common-modal-sm"
                                                            data-action="{{ route('sms-modal', $param) }}"
                                                            data-title="SMS">Sms
                                                        </button>

                                                    @endif


                                                    @if ($appointment->email_ind == 1)
                                                        <button class="btn btn-sm bg-brown open-modal mx-1"
                                                            id="patient_app_info" data-modal="common-modal-md"
                                                            data-action="{{ route('patient.app_info', $appointment->patient_no_pk) }}"
                                                            data-title="Patient Information"
                                                            bed-attr="{{ $appointment->patient_no_pk }}">Email
                                                            Info</button>
                                                    @else

                                                        <form action="{{ route('pcrm.call-person') }}" method="post"
                                                            id="email-data">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_no_pk }}" name="id">
                                                            <input type="hidden" value="{{ $appointment->mobile1 }}"
                                                                name="mobile_num">
                                                            <input type="hidden"
                                                                value="{{ $appointment->patient_name }}"
                                                                name="patient_name">
                                                            <input type="hidden"
                                                                value="{{ $appointment->full_name }}"
                                                                name="doctor_name">
                                                            {{-- <input type="hidden"
                                                                value="{{ $appointment->appoint_date }}"
                                                                name="app_date"> --}}
                                                            <input type="hidden" value="email" name="email">
                                                            @php
                                                                $response_action = route('pcrm.pcrm-dashboard');
                                                            @endphp
                                                            <button type="button" class="btn btn-sm bg-brown mx-1"
                                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Email</button>
                                                        </form>

                                                    @endif



                                                </div>

                                                {{-- <button type="button" class="btn btn-sm bg-blue">SMS</button> --}}
                                                {{-- <button type="button" class="btn btn-sm bg-brown">Email</button> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">Appointment Not Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-body border-top">
                    <h6 class="card-title mb-1">Unattendant Patient Last 7 Days
                        <span>({{ date('d-M-Y', strtotime('-6 days')) }}
                            to {{ date('d-M-Y') }})</span>
                    </h6>
                    <div class="col-12 table-responsive p-0">
                        <table
                            class="table table-striped table-bordered table-hover mb-0 border-top border-right data-table upAppointment">
                            <thead>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (isset($unattendant_patients))
                                    @foreach ($unattendant_patients as $unattendant_patient)
                                        <tr class="">
                                            <td class="
                                            border-0">
                                                {{ $loop->iteration }}</td>
                                            <td class="border-0 ml-4">
                                                <div
                                                    class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden ml-1">
                                                    @if ($unattendant_patient->patient_photo)
                                                        <img alt="No Image"
                                                            src="{{ asset('images/uploads/patient_images/thumb/' . $unattendant_patient->patient_photo) }}">
                                                    @else
                                                        <img alt="No Image"
                                                            src="{{ asset('images/pt-patient.jpg') }}">
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $unattendant_patient->full_name }}
                                                    </div>
                                                    <div class="text-gray-600 text-xs">
                                                        {{ $unattendant_patient->specialization }}</div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $unattendant_patient->patient_name }}
                                                    </div>
                                                    <div class="text-gray-600 text-xs">
                                                        <span>{{ Carbon\Carbon::parse($unattendant_patient->patient_dob)->age }}years</span>,
                                                        <span>{{ $unattendant_patient->gender_txt }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $unattendant_patient->mobile1 ? $unattendant_patient->mobile1 : 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="text-theme-6">
                                                    <div class="row">

                                                        @php
                                                            $param = $unattendant_patient->patient_no_pk . '_' . $unattendant_patient->mobile1 . '_' . $unattendant_patient->patient_name . '_' . $unattendant_patient->full_name . '_' . $unattendant_patient->appoint_date;
                                                        @endphp


                                                        @if ($unattendant_patient->call_ind == 1)
                                                            <button class="btn btn-sm bg-navy open-modal mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $unattendant_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $unattendant_patient->patient_no_pk }}">Call
                                                                Info</button>
                                                        @else
                                                            <form action="{{ route('pcrm.call-person') }}"
                                                                method="post" id="call-data">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_no_pk }}"
                                                                    name="id">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->mobile1 }}"
                                                                    name="mobile_num">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_name }}"
                                                                    name="patient_name">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->full_name }}"
                                                                    name="doctor_name">
                                                                {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                                <input type="hidden" value="call" name="call">
                                                                @php
                                                                    $response_action = route('pcrm.pcrm-dashboard');
                                                                @endphp
                                                                <button type="button" class="btn btn-sm bg-navy mx-1"
                                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Call</button>
                                                            </form>
                                                        @endif



                                                        {{-- @if ($unattendant_patient->sms_ind == 1)
                                                            <button class="btn btn-sm bg-blue open-modal  mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $unattendant_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $unattendant_patient->patient_no_pk }}">Sms
                                                                Info</button>
                                                        @else

                                                            <form action="{{ route('pcrm.call-person') }}"
                                                                method="post" id="sms-data">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_no_pk }}"
                                                                    name="id">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->mobile1 }}"
                                                                    name="mobile_num">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_name }}"
                                                                    name="patient_name">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->full_name }}"
                                                                    name="doctor_name">
                                                                {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                        {{-- <input type="hidden" value="sms" name="sms">
                                                                @php
                                                                    $response_action = route('pcrm.pcrm-dashboard');
                                                                @endphp
                                                                <button type="button" class="btn btn-sm bg-blue mx-1"
                                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Sms</button>
                                                            </form> --}}
                                                        {{-- @endif --}}



                                                        @if ($unattendant_patient->sms_ind == 1)
                                                            <button class="btn btn-sm bg-blue open-modal  mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $unattendant_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $unattendant_patient->patient_no_pk }}">Sms
                                                                Info</button>
                                                        @else
                                                            <button class="btn btn-sm bg-blue mx-1 open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-action="{{ route('sms-modal', $param) }}"
                                                                data-title="SMS">Sms
                                                            </button>

                                                        @endif










                                                        @if ($unattendant_patient->email_ind == 1)
                                                            <button class="btn btn-sm bg-brown open-modal mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $unattendant_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $unattendant_patient->patient_no_pk }}">Email
                                                                Info</button>
                                                        @else

                                                            <form action="{{ route('pcrm.call-person') }}"
                                                                method="post" id="email-data">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_no_pk }}"
                                                                    name="id">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->mobile1 }}"
                                                                    name="mobile_num">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->patient_name }}"
                                                                    name="patient_name">
                                                                <input type="hidden"
                                                                    value="{{ $unattendant_patient->full_name }}"
                                                                    name="doctor_name">
                                                                {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                                <input type="hidden" value="email" name="email">
                                                                @php
                                                                    $response_action = route('pcrm.pcrm-dashboard');
                                                                @endphp
                                                                <button type="button" class="btn btn-sm bg-brown mx-1"
                                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Email</button>
                                                            </form>

                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body border-top">
                    <div class="card-title mb-1">
                        <div class="form-row">
                            <div class="col-md-6">
                                <h6 class="">Followup List <span>({{ date('d-M-Y') }}
                                        to {{ date('d-M-Y', strtotime('7 days')) }})</span>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="
                                    col-12 table-responsive p-0" id="folloeup-list">



                        <table
                            class="table table-striped table-bordered table-hover mb-0 border-top border-right data-table data_search followup">
                            <thead>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Doctor</th>
                                <th>Appointment Date</th>
                                <th>Prescription Date</th>
                                <th>Followup Date</th>
                                <th>Patient</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (isset($follow_up))
                                    @foreach ($follow_up as $follow_up_patient)
                                        <tr class="">
                                            <td
                                                class="
                                                        border-0">
                                                {{ $loop->iteration }}</td>
                                            <td class="border-0 ml-4">
                                                <div
                                                    class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden ml-1">
                                                    @if ($follow_up_patient->patient_photo)
                                                        <img alt="No Image"
                                                            src="{{ asset('images/uploads/patient_images/thumb/' . $follow_up_patient->patient_photo) }}">
                                                    @else
                                                        <img alt="No Image"
                                                            src="{{ asset('images/pt-patient.jpg') }}">
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $follow_up_patient->full_name }}
                                                    </div>
                                                    <div class="text-gray-600 text-xs">
                                                        {{ $follow_up_patient->specialization }}</div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ !empty($follow_up_patient->appoint_date) ? date('d/m/Y', strtotime($follow_up_patient->appoint_date)) : 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ !empty($follow_up_patient->prescription_date) ? date('d/m/Y', strtotime($follow_up_patient->prescription_date)) : 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ !empty($follow_up_patient->next_followup_dt) ? date('d/m/Y', strtotime($follow_up_patient->next_followup_dt)) : 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $follow_up_patient->patient_name }}
                                                    </div>
                                                    <div class="text-gray-600 text-xs">
                                                        <span>{{ Carbon\Carbon::parse($follow_up_patient->patient_dob)->age }}years</span>,
                                                        <span>{{ $follow_up_patient->gender_txt }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="border-0">
                                                <div class="ml-4 mr-auto">
                                                    <div class="font-medium">
                                                        {{ $follow_up_patient->mobile1 }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div class="text-theme-6">
                                                    <div class="row">
                                                        @php
                                                            $param = $follow_up_patient->patient_no_pk . '_' . $follow_up_patient->mobile1 . '_' . $follow_up_patient->patient_name . '_' . $follow_up_patient->full_name . '_' . $follow_up_patient->appoint_date . '_' . $follow_up_patient->next_followup_dt;
                                                        @endphp
                                                        @if ($follow_up_patient->call_ind == 1)
                                                            <button class="btn btn-sm bg-navy open-modal mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $follow_up_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $follow_up_patient->patient_no_pk }}">Call
                                                                Info</button>
                                                        @else
                                                            <form action="{{ route('pcrm.call-person') }}"
                                                                method="post" id="call-data">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->patient_no_pk }}"
                                                                    name="id">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->mobile1 }}"
                                                                    name="mobile_num">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->patient_name }}"
                                                                    name="patient_name">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->full_name }}"
                                                                    name="doctor_name">
                                                                {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                                <input type="hidden" value="call" name="call">
                                                                @php
                                                                    $response_action = route('pcrm.pcrm-dashboard');
                                                                @endphp
                                                                <button type="button" class="btn btn-sm bg-navy mx-1"
                                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Call</button>
                                                            </form>
                                                        @endif



                                                        @if ($follow_up_patient->sms_ind == 1)
                                                            <button class="btn btn-sm bg-blue open-modal  mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $follow_up_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $follow_up_patient->patient_no_pk }}">Sms
                                                                Info</button>
                                                        @else
                                                            <button class="btn btn-sm bg-blue mx-1 open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-action="{{ route('sms-modal', $param) }}"
                                                                data-title="SMS">Sms
                                                            </button>

                                                        @endif

                                                        @if ($follow_up_patient->email_ind == 1)
                                                            <button class="btn btn-sm bg-brown open-modal mx-1"
                                                                id="patient_app_info" data-modal="common-modal-md"
                                                                data-action="{{ route('patient.app_info', $follow_up_patient->patient_no_pk) }}"
                                                                data-title="Patient Information"
                                                                bed-attr="{{ $follow_up_patient->patient_no_pk }}">Email
                                                                Info</button>
                                                        @else

                                                            <form action="{{ route('pcrm.call-person') }}"
                                                                method="post" id="email-data">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->patient_no_pk }}"
                                                                    name="id">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->mobile1 }}"
                                                                    name="mobile_num">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->patient_name }}"
                                                                    name="patient_name">
                                                                <input type="hidden"
                                                                    value="{{ $follow_up_patient->full_name }}"
                                                                    name="doctor_name">
                                                                {{-- <input type="hidden" value="{{ $appointment->appoint_date }}" name="app_date"> --}}
                                                                <input type="hidden" value="email" name="email">
                                                                @php
                                                                    $response_action = route('pcrm.pcrm-dashboard');
                                                                @endphp
                                                                <button type="button" class="btn btn-sm bg-brown mx-1"
                                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Email</button>
                                                            </form>

                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        {{-- @include('admin.pcrm.followup_list_data') --}}

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <form action="" id="searchForm" method="post">
                    <div class="card-body border-top">
                        <div class="card-title mb-1">
                            <div class="form-row justify-content-center">
                                <div class="col-md-6">
                                    <h6 class="">Doctor Schedule <span id=" today_date">Today
                                            ({{ date('d-M-Y') }})</span>
                                    </h6>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control form-control-sm select2" id="doctor_id"
                                        name="doctor_id" style="margin-bottom: 0px!important">
                                        <option value="">Select Doctor</option>
                                        @if (isset($all_doctors))
                                            @foreach ($all_doctors as $doctor)
                                                <option value="{{ $doctor->person_no_pk }}">
                                                    {{ $doctor->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control date_picker" name="app_date" id="app_date"
                                        autocomplete="off" placeholder="mm/dd/yyyy"
                                        style="margin-bottom: 0px!important" />
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success btn-md btn-block"
                                        id="btnSearchReport">Search</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive p-0" id="doctor-shedule">

                            @include('admin.pcrm.dashboard_doctor_shedule')

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>


{{-- <script src="{{ asset('site-assets/js/waypoints.min.js') }}"></script>
<!-- Jquery CounterUp Min JS -->
<script src="{{ asset('site-assets/js/jquery.counterup.min.js') }}"></script>


<script>
    // For Counter
    t(".count").counterUp({
        delay: 20,
        time: 1500
    }),



</script> --}}

<!-- Waypoints Min Js -->
<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");

    // $('.appointment').DataTable({
    //     "ordering": false,
    //     "pageLength": 3,
    //     lengthMenu: [
    //         [5, 10, 25, 50, 100, -1],
    //         [5, 10, 25, 50, 100, "All"]
    //     ]
    // });
    $('.appointment').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });
    $('.upAppointment').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });
    $('.followup').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });
    $('.doc_schedule').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });

    // $('.upAppointment').DataTable({
    //     "ordering": false,
    //     "pageLength": 3,
    //     lengthMenu: [
    //         [5, 10, 25, 50, 100, -1],
    //         [5, 10, 25, 50, 100, "All"]
    //     ]
    // });

    $('.select2').select2();
    $(document).ready(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('.date_picker').datepicker({
            clearBtn: true,
            autoclose: true
        });
    });

    $(document).on("click", "#btnSearchReport", function(e) {
        $("#today_date").hide();
        var formID = $("#searchForm").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('pcrm/doctor-shedule-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#doctor-shedule").html(data);
                $('.data_search').DataTable({
                    "ordering": false,
                    "pageLength": 5,
                    lengthMenu: [
                        [5, 10, 25, 50, 100, -1],
                        [5, 10, 25, 50, 100, "All"]
                    ]
                });

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
