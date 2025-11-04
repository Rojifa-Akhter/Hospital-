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
        font-size: 24px;
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
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-3">
            <h5 class="mb-0">IPD Dashboard</h5>
            <small>IPD / IPD Dashboard</small>
        </div>
    </div>


    <div class="row ">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Reports</h5>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="bed-details">
                            <h3>Total Admitted</h3>
                            <span>{{ !empty($toal_appoinment[0]->tot_admited) ? $toal_appoinment[0]->tot_admited : 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="bed-details">
                            <h3>Average length of stay</h3>
                            <span>{{ !empty($average_length[0]->avg_length) ? $average_length[0]->avg_length : 0 }}
                                Days</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details">
                            <h3>Bed Occupancy</h3>
                            <span>{{ !empty($bed_occupancy[0]->rasio) ? $bed_occupancy[0]->rasio : 0 }}%</span>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-md-6">
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
                            <h3>TOTAL BED</h3>
                            <span>{{ !empty($total_bed[0]->tot_bed) ? $total_bed[0]->tot_bed : 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon bg-green">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details green-txt">
                            <h3>BEd occupied</h3>
                            <span>{{ !empty($occupied_bed[0]->bed_occu) ? $occupied_bed[0]->bed_occu : 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon bg--blue">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details blue--txt">
                            <h3>Available</h3>
                            <span>{{ !empty($available_bed[0]->availble) ? $available_bed[0]->availble : 0 }}</span>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Department wise Admission</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped datatable">
                            <thead style="background-color: #322f78; color: #fff;">
                                <tr>
                                    <th class="table-left-border-radius">Department Name</th>
                                    <th>Today</th>
                                    <th>Yestarday</th>
                                    <th>This Month</th>
                                    <th>{{date('F', strtotime('-1 month'))}}</th>
                                    <th>{{date('F', strtotime('-2 month'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($dept_wise_admission))
                                    @foreach ($dept_wise_admission as $data)
                                        <tr>
                                            <td class="text-left">{{!empty($data->dept_name)?$data->dept_name:'N/A'}} </td>
                                            <td class="text-center">{{!empty($data->today)?$data->today:0}}</td>
                                            <td class="text-center">{{!empty($data->yesterday)?$data->yesterday:0}}</td>
                                            <td class="text-center">{{!empty($data->this_month)?$data->this_month:0}}</td>
                                            <td class="text-center">{{!empty($data->last_month)?$data->last_month:0}}</td>
                                            <td class="text-center">{{!empty($data->last_previous)?$data->last_previous:0}}</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Age Group Wise Admission</h5>
                </div>
                <div class="card-body p-0">
                    {{-- <img class="img-fluid w-100" src="{{ asset('images/age-pie-chart.png') }}"> --}}
                    <div id="conversion-to-ipd" class="chartsh h-300"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Gender Wise Admission</h5>
                </div>
                <div class="card-body p-0">
                    <div id="gender-wise-admission" class="chartsh h-300"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>IPD Growth</h5>
                </div>
                <div class="card-body p-0">
                    <div id="ipd-growth" class="chartsh h-300"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links : --}}



    <div class="row">

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Reports</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="{{ route('v1.ipd-patient-list') }}" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>IPD Patient Report</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('report.date-wise-cashier-report') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Date Wise Cashier Report</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success">Quick Links</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                    <a href="{{ route('billing.service-billing') }}" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Service Billing</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('ipd-billing-list') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>Billing List</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('idp.ipd-business-office') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Business Office</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('ipd.ipd-admission') }}" target="_blank">
                                        <div class="custom-box-button">
                                            <span>IPD Admission</span>
                                        </div>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



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
<script>
    $(".sidebar-collapse").addClass("active");
    $("#content").addClass("active");
    $('.datatable').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ]
    });
    // Age Of Admission
    var chart = c3.generate({
        bindto: '#conversion-to-ipd',
        data: {
            columns: [
                ['0-9 Years', {{$age0_9}}],
                ['10-19 Years', {{$age10_19}}],
                ['20-29 Years', {{$age20_29}}],
                ['30-39 Years', {{$age20_39}}],
                ['40-49 Years', {{$age40_49}}],
                ['50-above Years', {{$age50_abo}}],
            ],
            type: 'donut',
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
            title: "Age Group Wise Admission"
        },
        axis: {
            x: {
                type: 'category',
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


    // Gender Wise Admission
    var chart = c3.generate({
        bindto: '#gender-wise-admission',
        data: {
            columns: [
                ['Female', {{$gender_female}}],
                ['Male', {{$gender_male}}],
            ],
            type: 'donut',
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
            title: "Gender Wise Admission"
        },
        axis: {
            x: {
                type: 'category'
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

    // ipd growth
    var chart = c3.generate({
        bindto: '#ipd-growth',
        data: {
            columns: [
                ['data1', {{$ipd_growth}}],
                ['data2', {{$ipd_growth}}]
            ],
            axes: {
                data2: 'y2'
            },
            types: {
                data2: 'bar'
            },
            names: {
                'data1': 'Growth',
                'data2': 'Growth',
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['{{date('F')}}',
                    '{{date('F', strtotime('-1 month'))}}',
                    '{{date('F', strtotime('-2 month'))}}',
                    '{{date('F', strtotime('-3 month'))}}',
                    '{{date('F', strtotime('-4 month'))}}',
                    '{{date('F', strtotime('-5 month'))}}'
                ]
            },
            y: {
                label: {
                    text: 'Y Label',
                    position: 'outer-middle'
                },
                tick: {
                    format: d3.format("") // ADD
                }
            },
            y2: {
                show: true,
                label: {
                    text: 'Y2 Label',
                    position: 'outer-middle'
                }
            }
        }
    });
</script>
