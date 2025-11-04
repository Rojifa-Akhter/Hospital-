<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<style>
    .table-left-border-radius {
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
    }

    .table-right-border-radius {
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
    }

    .table thead th {
        border-bottom: none !important;
    }

    .month-wise {
        margin-top: 15px;
        margin-bottom: 0;
        font-size: 14px;
        color: #000;
    }

    .service_name img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        line-height: 50px;
        border-radius: 50%;
    }

    .service_name h4 {
        font-weight: 600;
        font-size: 20px;
        letter-spacing: 0.1px;
        color: #4E4E4E;
    }

    .service_name span {
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.1px;
        color: #4E4E4E;
        ;
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
        content: "";
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

    .total-bed {
        display: flex;
        gap: 30px;
        background: #F7F9FB;
        padding: 15px;
        border-bottom: 3px solid #535673;
    }

    .bed-icon i {
        font-size: 50px;
        color: #322F78;
    }

    .bed-details h3 {
        color: #322F78;
        font-weight: 700;
        font-size: 34px;
        text-transform: uppercase;
        letter-spacing: 0.1px;
        margin-bottom: 0;
    }

    .bed-details span {
        font-weight: 700;
        font-size: 48px;
        color: #322F78;
        letter-spacing: 0.1px;
    }

    .bed-icon.bg-green i {
        color: #07BE6E;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-icon.bg--blue i {
        color: #0177FB;
    }

    .bed-details.blue--txt h3 {
        color: #0177fb;
    }

    .bed-details.blue--txt .month_wise {
        padding: 0;
        margin-top: 15px;
    }

    .bed-details.blue--txt .month_wise li {
        list-style: none;
    }

    .bed-details.blue--txt .month_wise li {
        display: flex;
        justify-content: space-between;
    }

    .month_wise li h5 {
        color: #4E4E4E;
        font-size: 18px;
        font-weight: 700;
    }

    .month_wise li h6 {
        color: #0177FB;
        font-size: 18px;
        font-weight: 700;
    }

    .AutoScroll {
        color: #fff;
        position: relative;
        top: 0px;
        /* max-height: 1100px; */
        overflow-y: scroll;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-3">
            <h5 class="mb-0">Managment Dashboard</h5>
            <small>Managment / Managment Dashboard</small>
        </div>

        {{-- <div class="col-md-9">
            <div class="form-row justify-content-end mt-2">
                <div class="col-md-2">
                    <a href="#" class="btn btn-success btn-block btn-md"><i class="fa fa-sync"></i> Refresh</a>
                </div>
            </div>
        </div> --}}
    </div>


    <div class="row AutoScroll">
        <div class="col-md-12">
            <div class="card mb-0">
                <div class="card-header">
                    <h5>Hospital Summery</h5>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color:#322F78; color:#fff;">
                                <tr>
                                    <th class="table-left-border-radius" colspan="2">OPD Consultation</th>
                                    {{-- <th colspan="9">OPD Intervention</th> --}}
                                    {{-- <th class="table-right-border-radius" colspan="11">Emergency</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left ">Today</td>
                                    <td class="text-center">10</td>


                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center">10</td> --}}

                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius ">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission to IPD</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Total Consultation</td>
                                    <td class="text-center ">10</td> --}}

                                </tr>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left ">Yesterday</td>
                                    <td class="text-center">10</td>


                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center">10</td> --}}


                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius ">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission to IPD</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Total Consultation</td>
                                    <td class="text-center ">10</td> --}}

                                </tr>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left ">This Month</td>
                                    <td class="text-center">10</td>


                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center">10</td> --}}

                                    {{-- <td class="text-left ">Today</td>
                                    <td class="table-left-border-radius ">Observation​</td>
                                    <td class="text-center">10</td>
                                    <td class="table-left-border-radius ">Admission to IPD</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Procedure</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Medicine with Discharge</td>
                                    <td class="text-center ">10</td>
                                    <td class="table-left-border-radius ">Total Consultation</td>
                                    <td class="text-center ">10</td> --}}

                                </tr>


                            </tbody>
                        </table>


                        {{-- End Of Hospital Details --}}


                    </div>
                </div>



                <div class="form-row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Conversion To IPD</h5>
                                <p class="month-wise">Month wise Comparison (last 3 Months)</p>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead style="background-color:#0177FB; color:#fff;">
                                            <tr>
                                                <th colspan="2">OPD</th>
                                                <th colspan="2">Emergency</th>
                                                <th colspan="2">General</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background: #f2f7f2;">
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->others : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->others : '' }}
                                                </td>
                                            </tr>
                                            <tr style="background: #f2f7f2;">
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->others : '' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>OPD To IPD Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-ipd" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Conversion To IPD</h5>
                                <p class="month-wise">Month wise Comparison (last 3 Months)</p>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead style="background-color:#0177FB; color:#fff;">
                                            <tr>
                                                <th colspan="2">OPD</th>
                                                <th colspan="2">Emergency</th>
                                                <th colspan="2">General</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background: #f2f7f2;">
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[0]) ? $ipd_conversation[0]->others : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[1]) ? $ipd_conversation[1]->others : '' }}
                                                </td>
                                            </tr>
                                            <tr style="background: #f2f7f2;">
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->opd : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->emr : '' }}
                                                </td>
                                                <td>{{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->month : '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($ipd_conversation[2]) ? $ipd_conversation[2]->others : '' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Emergency To IPD Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-em-to-ipd" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>



                </div>


                {{-- IPD Part wire:  --}}

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color:#322F78; color:#fff;">
                                <tr>
                                    <th class="table-left-border-radius" colspan="11">IPD PATIENT REPORT</th>
                                    <th colspan="11">ICU Patient Report</th>
                                    <th class="table-right-border-radius" colspan="11">CCU PATIENT REPORT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                                <tr>
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                            </tbody>
                        </table>


                        {{-- End Of Hospital Details --}}


                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>OPD To IPD Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-ipd-bar" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>OPD To IPD Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-icu" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>OPD To IPD Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-ccu" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>

                </div>





                {{-- NICU Par   --}}

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color:#322F78; color:#fff;">
                                <tr>
                                    <th class="table-left-border-radius" colspan="11">IPD PATIENT REPORT</th>
                                    <th colspan="11">OT REPORT</th>
                                    <th class="table-right-border-radius" colspan="11">DIALYSIS REPORT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                                <tr>
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                                <tr style="background: #f2f7f2;">
                                    <td class="text-left">Today</td>
                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>


                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                    <td class="text-center">Current</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Discharge</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Dis. With Advice</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">DAMA</td>
                                    <td class="text-center">10</td>
                                    <td class="text-left">Death</td>
                                    <td class="text-center">10</td>

                                </tr>
                            </tbody>
                        </table>


                        {{-- End Of Hospital Details --}}


                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>NICU Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-nicu" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>OT Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-OT" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>DIALYSIS Conversion</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="conversion-to-dialysis" class="chartsh h-300"></div>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="form-row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Bed occupancy</h5>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details">
                                        <h3>Hospital Bed</h3>
                                        <span>{{ $total_bed_count[0]->no_of_bed }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon bg-green">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details green-txt">
                                        <h3>Total Operational Bed</h3>
                                        <span>{{ $occupied_bed_count[0]->no_of_bed }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Bed occupied Ratio </h5>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon bg--blue">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details blue--txt">

                                        {{-- <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h5>General Bed
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                        </h6>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> --}}


                                        {{-- <table class="table table-bordered table-hover table-striped" style="270px;">
                                            <tbody>
                                                <tr>
                                                    <td  style="border: none;"><h5>General Bed
                                                    </h5></td>
                                                    <td class="text-center" style="border: none;">
                                                        <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                        </h6>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> --}}

                                        <ul class="month_wise">
                                            <li>
                                                <h5>General Bed
                                                </h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>Cabin
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>ICU
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>CCU
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>NICU
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>Free Bed
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>Academic Bed
                                                </h5>
                                                <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>
                                            <li>
                                                <h5>Bed Available
                                                </h5>
                                                <h6> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}
                                                </h6>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Statistics</h5>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details">
                                        <h3 style="font-size: 15px !important;">Bed Occupancy Rate(BOR)</h3>
                                        <span
                                            style="font-size: 31px !important;">{{ $total_bed_count[0]->no_of_bed }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon bg-green">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details green-txt">
                                        <h3 style="font-size: 15px !important;">Length Of Hospital Stay</h3>
                                        <span
                                            style="font-size: 31px !important;">{{ $occupied_bed_count[0]->no_of_bed }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="total-bed">
                                    <div class="bed-icon bg-green">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="bed-details green-txt">
                                        <h3 style="font-size: 15px !important;">Average Length Of Hospital Stay</h3>
                                        <span
                                            style="font-size: 31px !important;">{{ $occupied_bed_count[0]->no_of_bed }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>


    </div>

</div>




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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('js/autoscroll.js') }}"></script>

<SCript>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    // $(".AutoScroll").scroller();

    // countDown(120);



    $('.datatable2').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });

    // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-ipd',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    });


    // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-em-to-ipd',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-ipd-bar',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-icu',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-ccu',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-nicu',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-OT',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    }); // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-dialysis',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'bar',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
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
        }
    });
</SCript>
