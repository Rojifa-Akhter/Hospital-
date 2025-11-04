<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
<!-- Style css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/css/style.css') }}" />

<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<style>
    .collapse:not(.show) {
        background: inherit !important;
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

    .border-class {
        border-radius: 10px;
        padding: 15px !important;
    }

    .bg-transparent-black {
        background-color: #003b61 !important;
    }

    tr {
        float: left
    }
    .AutoScroll {
        color: #fff;
        position: relative;
        top: 0px;
        max-height: 1100px;
        overflow-y: scroll;
    }
</style>

<div class="container-fluid side-app AutoSctroll" style="margin-top: -35px;">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-transparent-black border-0 mt-10 bg-transparent-black">
                <div class="card-body p-2 d-flex align-items-center justify-content-between border-class"
                    style="
            background-color: white!important;
            color: black!important;
        ">
                    <h5 class="mb-0 font-weight-bold">Hospital </h5>
                    <h6 class="mb-0">Today ({{ date('d-m-Y') }})</h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">Today's Appointment</h5>
                    @php
                        $today_apntment = isset($today_appointment[0]->t_appointment) ? $today_appointment[0]->t_appointment : 0;
                        $today_new_appointment = isset($today_new_appointment[0]->t_n_appointment) ? $today_new_appointment[0]->t_n_appointment : 0;
                        $today_followup_appointment = isset($today_followup_appointment[0]->t_f_appointment) ? $today_followup_appointment[0]->t_f_appointment : 0;
                        $today_free_appointment = isset($today_free_appointment[0]->t_free_appointment) ? $today_free_appointment[0]->t_free_appointment : 0;
                    @endphp
                    <h6 class="mb-1 mt-5 number-font">Appointment : {{ $today_apntment }}, Prescribed :
                        {{ $prescribed }}</h6>
                    <h6 class="mb-1 mt-2 number-font">New : {{ $today_new_appointment }}, Followup :
                        {{ $today_followup_appointment }}, Free : {{ $today_free_appointment }}</h6>
                    {{-- <h6 class="mb-1 mt-2 number-font"></h6> --}}

                    @php
                        if ($today_apntment == 0) {
                            $prescribed_perc = round($prescribed * 100);
                        } else {
                            $prescribed_perc = round(($prescribed * 100) / $total_doctor);
                        }

                        $prescribed_percentage = isset($prescribed_perc) ? $prescribed_perc : 0;
                    @endphp

                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center justify-content-between"
                        style="height: 24px;">
                        <div class="progress-bar bg-success text-right"
                            style="width: {{ $prescribed_percentage }}%; height: 24px; font-size: 15px;
                            padding: 0px 5px;">
                            {{ $prescribed_percentage }}</div>

                        <p class="mb-0 pr-2" style="font-size: 14px;">{{ $today_apntment }}</p>
                    </div>
                    {{-- <span class="ratio bg-success">76%</span> --}}
                    @if ($prescribed_percentage < 50)
                        <span class="ratio bg-warning">{{ $prescribed_percentage }}%</span>
                    @else
                        <span class="ratio bg-success">{{ $prescribed_percentage }}%</span>
                    @endif
                    <span class="ratio-text text-muted">Goals Reached</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInDown" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">Available Doctor</h5>
                    <h6 class="mb-1 mt-5 number-font">Total : {{ $total_doctor }}</h6>
                    <h6 class="mb-1 mt-2 number-font">Active : {{ $active_doctor }}</h6>

                    @php
                        if ($total_doctor == 0) {
                            $active_perc = round($active_doctor * 100);
                        } else {
                            $active_perc = round(($active_doctor * 100) / $total_doctor);
                        }

                        $active_percentage = isset($active_perc) ? $active_perc : 0;
                    @endphp


                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center justify-content-between"
                        style="height: 24px;">
                        <div class="progress-bar bg-success text-right"
                            style="width: {{ $active_percentage }}%; height: 24px; font-size: 15px;
                            padding: 0px 5px;">
                            {{ $active_percentage }}</div>
                        <p class="mb-0 pr-2" style="font-size: 14px;">{{ $total_doctor }}</p>
                    </div>

                    @if ($active_percentage < 50)
                        <span class="ratio bg-warning">{{ $active_percentage }}%</span>
                    @else
                        <span class="ratio bg-success">{{ $active_percentage }}%</span>
                    @endif
                    <span class="ratio-text text-muted">Goals Reached</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">IPD Information</h5>
                    <h6 class="mb-1 mt-5 number-font">Current : {{ $todays_available_ipd_pat }}, New :
                        {{ $today_admission }}, Disch. :
                        {{ $today_discharge }}</h6>
                    <h6 class="mb-1 mt-2 number-font">
                        @foreach ($todays_available_dept_pat as $dt)
                            <tr>
                                <td>{{ ucfirst($dt->admitted_department) }} : {{ $dt->su_count }} , </td>
                            </tr>
                        @endforeach
                    </h6>
                    {{-- <h5 class="mb-1">Today's Addmission</h5>
                    <h6 class="mb-1 mt-5 number-font">Total : {{ $today_admission }}</h6>
                    <h6 class="mb-1 mt-5 number-font">Total Available : {{ $todays_available_ipd_pat }} Disch. : {{ $today_discharge }}</h6> --}}

                    {{-- <h6 class="mb-1 mt-2 number-font">Disch. : 10 &nbsp; &nbsp; &nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; New Request : 20 </h6> --}}

                    @php
                        if ($today_admission == 0) {
                            $disch_perc = round($today_discharge);
                        } else {
                            $disch_perc = round($today_discharge / $today_admission);
                        }

                        $disch_percentage = isset($disch_perc) ? $disch_perc * 100 : 0;
                    @endphp
                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center"
                        style="height: 24px;">
                        <div class="progress-bar bg-green text-right"
                            style="width: {{ $disch_percentage }}%; height: 24px; font-size: 14px; padding: 0px 5px;">
                            {{ $disch_percentage }}%
                        </div>
                        {{-- <div class="progress-bar bg-warning text-right"
                            style="width: 40%; height: 24px; font-size: 14px; padding: 0px 5px;">40
                        </div> --}}
                        <p class="mb-0 pr-2 ml-auto" style="font-size: 14px;">{{ $today_admission }}</p>
                    </div>

                    @if ($disch_percentage < 50)
                        <span class="ratio bg-warning">{{ $disch_percentage }}%</span>
                    @else
                        <span class="ratio bg-success">{{ $disch_percentage }}%</span>
                    @endif

                    <span class="ratio-text text-muted">Goals Reached</span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card bg-transparent-black border-0 mt-10 bg-transparent-black">
                <div class="card-body p-2 d-flex align-items-center justify-content-between border-class"
                    style="
            background-color: white!important;
            color: black!important;
        ">
                    <h5 class="mb-0 font-weight-bold">Clinical Summary </h5>
                    <h6 class="mb-0">Today ({{ date('d-m-Y') }})</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">Hospital Patient Summary</h5>
                    @php
                        $today_apntment = isset($today_appointment[0]->t_appointment) ? $today_appointment[0]->t_appointment : 0;
                    @endphp
                    <h6 class="mb-1 mt-5 number-font">Total : {{ $total_patient->total_patient }}</h6>
                    <h6 class="mb-1 mt-2 number-font">OPD : {{ $total_opd->total_patient }}</h6>
                    <h6 class="mb-1 mt-2 number-font">IPD : {{ $total_ipd->total_patient }}</h6>

                    @php
                        $total = $total_patient->total_patient ?? 0;
                        $total_opd = $total_opd->total_patient ?? 0;
                        $total_ipd = $total_ipd->total_patient ?? 0;
                        $percent1 = 0;
                        $percent2 = 0;
                        if ($total_opd != 0 && $total != 0) {
                            $percent1 = ($total_opd / $total) * 100;
                        }
                        if ($total_ipd != 0 && $total != 0) {
                            $percent2 = ($total_ipd / $total) * 100;
                        }

                        $prescribed_percentage = isset($prescribed_perc) ? $prescribed_perc : 0;
                    @endphp

                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center justify-content-between"
                        style="height: 24px;">
                        <div class="progress-bar bg-success text-right"
                            style="width: {{ $percent1 }}%; height: 24px; font-size: 15px;
                            padding: 0px 5px;">
                            {{ $total_opd }}</div>

                        <p class="mb-0 pr-2" style="font-size: 14px;">{{ $total_ipd }}</p>
                    </div>
                    {{-- <span class="ratio bg-success">76%</span> --}}

                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInDown" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">Pharmacy Patient Summary </h5>
                    <h6 class="mb-1 mt-5 number-font">Total : {{ $total_phr_patient->total_patient }}</h6>
                    <h6 class="mb-1 mt-2 number-font">OPD : {{ $total_phr_opd->total_patient }}</h6>
                    <h6 class="mb-1 mt-2 number-font">IPD : {{ $total_phr_ipd->total_patient }}</h6>

                    @php
                        $total_phr = $total_phr_patient->total_patient ?? 0;
                        $total_phr_opd = $total_phr_opd->total_patient ?? 0;
                        $total_phr_ipd = $total_phr_ipd->total_patient ?? 0;
                        $percent1 = 0;
                        $percent2 = 0;
                        if ($total_phr_opd != 0 && $total_phr != 0) {
                            $percent1 = ($total_phr_opd / $total_phr) * 100;
                        }
                        if ($total_phr_ipd != 0 && $total_phr != 0) {
                            $percent2 = ($total_phr_ipd / $total_phr) * 100;
                        }

                    @endphp


                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center justify-content-between"
                        style="height: 24px;">
                        <div class="progress-bar bg-success text-right"
                            style="width: {{ $percent1 }}%; height: 24px; font-size: 15px;
                            padding: 0px 5px;">
                            {{ $total_phr_opd }}</div>
                        <p class="mb-0 pr-2" style="font-size: 14px;">{{ $total_phr_ipd }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <h5 class="mb-1">Investigation Information</h5>
                    <h6 class="mb-1 mt-5 number-font">Total :
                        {{ isset($total_inv_ipd->total) ? $total_inv_ipd->total : 0 }}</h6>
                    <h6 class="mb-1 mt-2 number-font">LAB :
                        {{ isset($total_inv_ipd->pathology_amt_count) ? $total_inv_ipd->pathology_amt_count : 0 }}
                    </h6>
                    <h6 class="mb-1 mt-2 number-font">RAD :
                        {{ isset($total_radiology[0]->total) ? $total_radiology[0]->total : 0 }} [

                        @foreach ($dept_wise_radiology as $row)
                            <tr>
                                <td>{{ $row->serviceunit_name }}:{{ $row->total }} ,</td>
                            </tr>
                        @endforeach
                        ]
                    </h6>
                    {{-- <h5 class="mb-1">Today's Addmission</h5>
                    <h6 class="mb-1 mt-5 number-font">Total : {{ $today_admission }}</h6>
                    <h6 class="mb-1 mt-5 number-font">Total Available : {{ $todays_available_ipd_pat }} Disch. : {{ $today_discharge }}</h6> --}}

                    {{-- <h6 class="mb-1 mt-2 number-font">Disch. : 10 &nbsp; &nbsp; &nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; New Request : 20 </h6> --}}

                    @php
                        $total_phr = isset($total_inv_ipd->total) ? $total_inv_ipd->total : 0;
                        $pathology_amt_count = isset($total_inv_ipd->pathology_amt_count) ? $total_inv_ipd->pathology_amt_count : 0;
                        $radiology_amt_count = isset($total_inv_ipd->radiology_amt_count) ? $total_inv_ipd->radiology_amt_count : 0;
                        $percent1 = 0;
                        $percent2 = 0;
                        if ($pathology_amt_count != 0 && $total_phr != 0) {
                            $percent1 = ($pathology_amt_count / $total_phr) * 100;
                        }
                        if ($radiology_amt_count != 0 && $total_phr != 0) {
                            $percent2 = ($radiology_amt_count / $total_phr) * 100;
                        }

                    @endphp
                    <div class="progress progress-sm mb-0 mt-2 text-right d-flex align-items-center"
                        style="height: 24px;">
                        <div class="progress-bar bg-green text-right"
                            style="width: {{ $percent1 }}%; height: 24px; font-size: 14px; padding: 0px 5px;">
                            {{ $pathology_amt_count }}
                        </div>
                        {{-- <div class="progress-bar bg-warning text-right"
                            style="width: 40%; height: 24px; font-size: 14px; padding: 0px 5px;">40
                        </div> --}}
                        <p class="mb-0 pr-2 ml-auto" style="font-size: 14px;">{{ $radiology_amt_count }}</p>
                    </div>


                </div>
            </div>
        </div>

    </div>


    <div class="form-row">
        <div class="col-md-12">
            <div class="card bg-transparent-black border-0 mt-10 bg-transparent-black">
                <div class="card-body p-2 d-flex align-items-center justify-content-between border-class"
                    style="
            background-color: white!important;
            color: black!important;
        ">
                    <h5 class="mb-0 font-weight-bold">Human Resource (Employee)</h5>
                    <h6 class="mb-0">Today ({{ date('d-m-Y') }})</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 bg-transparent-black mt-0">
                <div class="row mr-0 ml-0 bg-transparent-black">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">

                        <div class="card-body text-center">
                            <p class="mb-1 text-white">
                                Total Man Power</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-title="total Employees">
                                {{ isset($total_manpower[0]->total) ? $total_manpower[0]->total : '0' }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Present</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['ATTEND']) ? $attendence_arr['ATTEND'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Late</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['LATE']) ? $attendence_arr['LATE'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Leave</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['LEAVE']) ? $attendence_arr['LEAVE'] : 0 }}
                            </h4>

                        </div>
                    </div>

                    <div class="col-xl-1 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Absent</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['ABSENT']) ? $attendence_arr['ABSENT'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Day Off</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['DAY OFF']) ? $attendence_arr['DAY OFF'] : 0 }}
                            </h4>

                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Attent Without Outtime</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($attendence_arr['ABNORMAL DATA']) ? $attendence_arr['ABNORMAL DATA'] : 0 }}
                            </h4>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card bg-transparent-black border-0 mt-10 bg-transparent-black">
                <div class="card-body p-2 d-flex align-items-center justify-content-between border-class"
                    style="
            background-color: white!important;
            color: black!important;
        ">
                    <h5 class="mb-0 font-weight-bold">Human Resource(Doctor)</h5>
                    <h6 class="mb-0">Today ({{ date('d-m-Y') }})</h6>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 bg-transparent-black mt-0">
                <div class="row mr-0 ml-0 bg-transparent-black">
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">

                        <div class="card-body text-center">
                            <p class="mb-1 text-white">
                                Total Doctor</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2 " data-title="total Employees">
                                {{ isset($total_doc[0]->total) ? $total_doc[0]->total : '0' }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Present</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['ATTEND']) ? $doc_attendence_arr['ATTEND'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Late</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['LATE']) ? $doc_attendence_arr['LATE'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Leave</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['LEAVE']) ? $doc_attendence_arr['LEAVE'] : 0 }}
                            </h4>

                        </div>
                    </div>

                    <div class="col-xl-1 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Absent</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['ABSENT']) ? $doc_attendence_arr['ABSENT'] : 0 }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-xl-1 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Day Off</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['DAY OFF']) ? $doc_attendence_arr['DAY OFF'] : 0 }}
                            </h4>

                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0 border-right">
                        <div class="card-body text-center">

                            <p class="mb-1 text-white">
                                Attent Without Outtime</p>
                            <h4 class="mb-1 font-weight-bold text-white my-2" data-modal="common-modal-md"
                                data-action="{{ url('dashboard/hrm-employees', '2') }}" data-title="Late Employees">
                                {{ isset($doc_attendence_arr['ABNORMAL DATA']) ? $doc_attendence_arr['ABNORMAL DATA'] : 0 }}
                            </h4>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row ">
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Patient by Age</div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="" id="age" value="{{ $age }}">
                    {{-- <div class="h-300" id="flotBar1"></div> --}}
                    <div id="chart-bar-stacked-age" class="chartsh h-300"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInDown" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Patient by Gender</div>
                </div>
                <div class="card-body">
                    {{-- <div class="h-300" id="flotPie2"></div> --}}
                    <div class="h-300" id="patientByGender"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-7 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Count by Week</h3>
                </div>
                <div class="card-body">
                    <div id="patient-count-patient-week" class="chartsh h-300"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Patient Visit by Department</div>
                </div>
                <div class="card-body">
                    <div class="h-300" id="flotPie1"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Weekly Investigation</h3>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked" class="chartsh "></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 wow slideInDown" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inpatient Bed Occupancy</h3>
                </div>
                <div class="card-body h-300 d-flex align-items-center justify-content-center">
                    <div class="row w-100">
                        <div class="col-6">
                            <div class="card overflow-hidden">
                                <div class="card-body bg-indigo">
                                    <h4>Total</h4>
                                    <h2>{{ $total_bed }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card overflow-hidden">
                                <div class="card-body bg-warning">
                                    <h4>Occupied</h4>
                                    <h2>{{ $occupied_bed }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Addmission, Discharge & Death</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="" id="last_6month" value="{{ $last_6month }}">
                    <div id="chart-bar-rotated1" class="chartsh "></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Count by Patient Type</h3>
                </div>
                <div class="card-body">
                    <div id="patient-count-patient-type" class="chartsh"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Reports</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="{{ route('pcrm.individual-doctor-wise-performance-details-report') }}" rel="tab">
                                        <div class="custom-box-button m-0">
                                            <span>Individual Doctor Wise Performance Details</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('pcrm.doctor-wise-performance-summary-report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Doctor wise Performance Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('reports.doctor-wish-income-summery') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Monthly Doctor Income Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('pcrm.doctor-wish-income-summery') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Doctor Income Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('pcrm.referral-details-report') }}">
                                        <div class="custom-box-button">
                                            <span>Individual Referral Details</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('referral-summary-report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Referral Performance Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('pcrm.referral-payment-bill') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Referral Payment Bill</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" rel="tab">
                                        <div class="custom-box-button">
                                            <span>MPO wise Referral Performance Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Referral wise Payment Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" rel="tab">
                                        <div class="custom-box-button">
                                            <span>IPD Bed Occupancy Report</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" rel="tab">
                                        <div class="custom-box-button">
                                            <span>IPD Bed Ledger</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#" rel="tab">
                                        <div class="custom-box-button">
                                            <span> IPD Bed Summary</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


</div>



{{-- <script src="{{ asset('dashboardv2_assets/js/jquery-3.5.1.min.js') }}"></script> --}}
<!-- Bootstrap4 js-->
<script src="{{ asset('dashboardv2_assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- <script type="application/javascript" src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script> --}}
<!--INTERNAL Flot Charts js-->
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/js/flot.js') }}"></script>

<!-- INTERNAL c3.js Charts js-->
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/js/charts.js') }}"></script>



<!-- Animate js-->
<script src="{{ asset('dashboardv2_assets/WOW-master/dist/wow.min.js') }}"></script>


<script>
    new WOW().init();
</script>

<script>
    $("body").addClass("sidebar-collapse");


    $(function() {

        var age = $("#age").val().split(',');
        // console.log(age);
        /******** Age Chart ********/
        var chart = c3.generate({
            bindto: '#chart-bar-stacked-age', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $totalAgeCount }}]
                ],
                type: 'bar', // default type of chart
                groups: [
                    ['data1', 'data2']
                ],
                colors: {
                    data1: '#fb1c52',
                },
                names: {
                    // name of each serie
                    'data1': 'Age',
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: age
                },
            },
            bar: {
                width: 16
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });


        /*patient-count-patient-week*/
        var chart = c3.generate({
            bindto: '#patient-count-patient-week', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $in_patient }}],
                    ['data2', {{ $out_patient }}]
                ],
                labels: true,
                type: 'line', // default type of chart
                colors: {
                    data1: '#705ec8',
                    data2: '#fb1c52'
                },
                names: {
                    // name of each serie
                    'data1': 'Inpatient',
                    'data2': 'Outpatient'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Last 1 Week', 'Last 2 Week', 'Last 3 Week', 'Last 4 Week',
                        'Last 5 Week', 'Last 6 Week', 'Last 7 Week'
                    ]
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });



        /**************** PIE CHART *******************/
        var piedata = [{
            label: 'Haematology - {{ $haematology }}',
            data: [{{ $haematology }}],
            color: '#fb1c52'
        }, {
            label: 'Biochemistry - {{ $biochemistry }}',
            data: [{{ $biochemistry }}],
            color: '#705ec8'
        }, {
            label: 'Radiology - {{ $radiology }}',
            data: [{{ $radiology }}],
            color: '#2dce89'
        }, {
            label: 'Administration - {{ $administration }}',
            data: [{{ $administration }}],
            color: '#ff5b51'
        }, {
            label: 'Pharmacy - {{ $pharmacy }}',
            data: [{{ $pharmacy }}],
            color: '#ffc107'
        }, {
            label: 'Oncology - {{ $oncology }}',
            data: [{{ $oncology }}],
            color: '#007bff'
        }, {
            label: 'Orhers - {{ $orhers_dept_count }}',
            data: [{{ $orhers_dept_count }}],
            color: '#17a2b8'
        }];


        //gender data
        var piedataGender = [{
            label: 'Male',
            data: [{{ $male_data }}],
            color: 'cornflowerblue'
        }, {
            label: 'Female',
            data: [{{ $female_data }}],
            color: 'darkcyan'
        }];


        $.plot('#flotPie1', piedata, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            grid: {
                hoverable: false,
                clickable: true
            }
        });

        $.plot('#patientByGender', piedataGender, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.4,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            grid: {
                hoverable: false,
                clickable: true
            }
        });

        function labelFormatter(label, series) {
            return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label +
                '<br/>' + Math.round(series.percent) + '%</div>';
        }



        /*chart-bar-rotated1*/
        var month = $("#last_6month").val().split(',');
        // var month = $("#last_6month").val();
        var chart = c3.generate({
            bindto: '#chart-bar-rotated1', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $addmission }}],
                    ['data2', {{ $discharge }}],
                    ['data3', {{ $death }}]
                ],
                type: 'bar', // default type of chart
                colors: {
                    data1: 'darkcyan',
                    data2: 'cornflowerblue',
                    data3: 'tomato'
                },
                names: {
                    // name of each serie
                    'data1': 'Addmission',
                    'data2': 'Discharge',
                    'data3': 'Death'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: month
                    // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
                rotated: true,
            },
            bar: {
                width: 10,
                margin: 15
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });


        /*patient-count-patient-type*/
        var chart = c3.generate({
            bindto: '#patient-count-patient-type', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $general }}],
                    ['data2', {{ $covid }}],
                    ['data3', {{ $staff }}],
                    ['data4', {{ $corporate }}],
                    ['data5', {{ $poor }}],
                    ['data6', {{ $student }}],
                    ['data7', {{ $special }}],
                ],
                labels: true,
                type: 'line', // default type of chart
                colors: {
                    data1: '#705ec8',
                    data2: '#fb1c52',
                    data3: '#00ffff',
                    data4: '#00008b',
                    data5: '#800080',
                    data6: '#00ff00',
                    data7: '#ff00ff',
                },
                names: {
                    // name of each serie
                    'data1': 'General',
                    'data2': 'Covid Discount',
                    'data3': 'Staff',
                    'data4': 'Corporate',
                    'data5': 'Poor',
                    'data6': 'Student',
                    'data7': 'Special'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Last 1 Week', 'Last 2 Week', 'Last 3 Week', 'Last 4 Week',
                        'Last 5 Week', 'Last 6 Week', 'Last 7 Week'
                    ]
                    // categories: ['Week 15-2022', 'Week 16-2022', 'Week 17-2022', 'Week 18-2022', 'Week 19-2022', 'Week 20-2022', 'Week 21-2022']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });


    });
</script>
