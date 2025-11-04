@extends('iCure-Home.admin.partials.cover_master')
@section('admin_content')

    @php
    $doctor_id = !empty(Auth::user()->person_no_fk) ? Auth::user()->person_no_fk : '';

    @endphp




    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            {{-- <h4 class="page-title mb-0">Hi! Welcome Back</h4> --}}
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Doctor Dashboard</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
        </div>
    </div>
    <!--End Page header-->

    <!-- Row-1 -->
    <div class="row">

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Total Appointed Patients</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data->appointed_patient) ? $dashboard_data->appointed_patient : '' }}</h2>

                </div>
                <div id="spark2"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Total Prescribed Patient</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data->prescribed_patient) ? $dashboard_data->prescribed_patient : '' }}</h2>


                </div>
                <div id="spark3"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Future Appointment</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data->future_appoint_pat) ? $dashboard_data->future_appoint_pat : '' }}</h2>


                </div>
                <div id="spark4"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Total Finance</p>
                    <h2 class="mb-1 number-font"><i class="fa-regular fa-bangladeshi-taka-sign"></i>
                        {{ !empty($dashboard_data->sales_price) ? $dashboard_data->sales_price : '' }} </h2>
                </div>
                <div id="spark1"></div>
            </div>
        </div>
    </div>
    <!-- End Row-1 -->

    <div class="row">

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Today Appointed Patients</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data_today[0]->appointed_patient) ? $dashboard_data_today[0]->appointed_patient : 0 }}
                    </h2>

                </div>
                <div id="spark2"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Today Prescribed Patient</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data_today[0]->prescribed_patient) ? $dashboard_data_today[0]->prescribed_patient : 0 }}
                    </h2>


                </div>
                <div id="spark3"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Future Appointment(7 Days)</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data_sevenday[0]->future_appoint_pat) ? $dashboard_data_sevenday[0]->future_appoint_pat : 0 }}
                    </h2>


                </div>
                <div id="spark4"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body">
                    <p class="mb-1">Total Finance</p>
                    <h2 class="mb-1 number-font">
                        {{ !empty($dashboard_data_today[0]->sales_price) ? $dashboard_data_today[0]->sales_price : 0 }}
                    </h2>
                </div>
                <div id="spark1"></div>
            </div>
        </div>
    </div>

    <!-- Row-2 -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Your Finance Analysis</h3>
                    <div class="card-options">
                        <div class="btn-group p-0">
                            <button class="btn btn-outline-light btn-sm" type="button">Week</button>
                            <button class="btn btn-light btn-sm" type="button">Month</button>
                            <button class="btn btn-outline-light btn-sm" type="button">Year</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-3 col-6">
                            <p class="mb-1">Total Appointment</p>
                            <h3 class="mb-0 fs-20 number-font1">0</h3>
                            <p class="fs-12 text-muted">
                                <span class="text-danger mr-1"><i class="fe fe-arrow-down"></i>0</span>this month
                            </p>
                        </div>
                        <div class="col-xl-3 col-6">
                            <p class="mb-1">Total Prescription</p>
                            <h3 class="mb-0 fs-20 number-font1">0</h3>
                            <p class="fs-12 text-muted">
                                <span class="text-success mr-1"><i class="fe fe-arrow-up"></i>0</span>this month
                            </p>
                        </div>
                        <div class="col-xl-3 col-6">
                            <p class="mb-1">Future Appointment</p>
                            <h3 class="mb-0 fs-20 number-font1">0</h3>
                            <p class="fs-12 text-muted">
                                <span class="text-danger mr-1"><i class="fe fe-arrow-down"></i>0</span>this month
                            </p>
                        </div>
                        <div class="col-xl-3 col-6">
                            <p class="mb-1">Future Income</p>
                            <h3 class="mb-0 fs-20 number-font1">0</h3>
                            <p class="fs-12 text-muted">
                                <span class="text-success mr-1"><i class="fe fe-arrow-up"></i>0</span>this month
                            </p>
                        </div>
                    </div>
                    <div id="echart1" class="chart-tasks chart-dropshadow text-center"></div>
                    <div class="text-center mt-2">
                        <span class="mr-4"><span class="dot-label bg-primary"></span>Prescription</span>
                        <span><span class="dot-label bg-secondary"></span>Income</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row-2 -->


    @push('admin_js')
        <script>
            $(function(e) {
                'use strict'

                var jsonfile = {
                    "jsonarray": @php echo $dashboard_data_pie_chart @endphp
                };
                console.log(jsonfile);

                // var future_appoint_pat = jsonfile.jsonarray.map(function(e) {
                //     return e.future_appoint_pat;
                // });

                // var prescribed_patient = jsonfile.jsonarray.map(function(e) {
                //     return e.prescribed_patient;
                // });

                // var appointed_patient = jsonfile.jsonarray.map(function(e) {
                //     return e.appointed_patient;
                // });

                // var sales_price = jsonfile.jsonarray.map(function(e) {
                //     return e.sales_price;
                // });

                /* E-chart */
                var chartdata = [{
                        name: 'Total',
                        type: 'line',
                        smooth: true,
                        data: [23, 8, 0, 31000],
                        // data: [future_appoint_pat, prescribed_patient, appointed_patient, sales_price],
                        itemStyle: {
                            normal: {
                                barBorderRadius: [50, 50, 0, 0],
                                color: new echarts.graphic.LinearGradient(
                                    0, 0, 0, 1,
                                    [{
                                            offset: 0,
                                            color: '#fd6f82'
                                        },
                                        {
                                            offset: 1,
                                            color: '#fb1c52'
                                        }
                                    ]
                                )
                            }
                        },
                    },
                    {
                        name: 'Today',
                        symbolSize: 20,
                        barWidth: 20,
                        type: 'bar',
                        data: [0, 0, 0, 0],
                        itemStyle: {
                            normal: {
                                barBorderRadius: [50, 50, 0, 0],
                                color: new echarts.graphic.LinearGradient(
                                    0, 0, 0, 1,
                                    [{
                                            offset: 0,
                                            color: '#705ec8'
                                        },
                                        {
                                            offset: 1,
                                            color: '#20c2fa'
                                        }

                                    ]
                                )
                            }
                        },
                    }
                ];
                var chart = document.getElementById('echart1');
                var barChart = echarts.init(chart);
                var option = {
                    grid: {
                        top: '6',
                        right: '0',
                        bottom: '17',
                        left: '25',
                    },
                    xAxis: {
                        data: ['Total Appointment', 'Total Prescription', 'Future Appointment', 'Total Finance'],
                        axisLine: {
                            lineStyle: {
                                color: 'rgba(67, 87, 133, .09)'
                            }
                        },
                        axisLabel: {
                            fontSize: 10,
                            color: '#8e9cad'
                        }
                    },
                    tooltip: {
                        show: true,
                        showContent: true,
                        alwaysShowContent: true,
                        triggerOn: 'mousemove',
                        trigger: 'axis',
                        axisPointer: {
                            label: {
                                show: false,
                            }
                        }

                    },
                    yAxis: {
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(67, 87, 133, .09)'
                            }
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'rgba(67, 87, 133, .09)'
                            }
                        },
                        axisLabel: {
                            fontSize: 10,
                            color: '#8e9cad'
                        }
                    },
                    series: chartdata,
                    color: ['#ef6430', '#2205bf']
                };
                barChart.setOption(option);
                /* E-chart */

            });
        </script>
    @endpush
@endsection
