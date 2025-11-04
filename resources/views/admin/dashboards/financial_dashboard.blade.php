<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
<!-- Style css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/css/style.css') }}" />

<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .collapse:not(.show) {
        background: inherit !important;
    }

    .ulData {
        margin: 0;
        padding: 0;
        display: flex;
        width: 100%;
        justify-content: space-between;
        text-align: center;
    }

    .ulData li {
        border-left: 2px solid black;
        padding: 4px;
    }

    hr {
        margin: 0px;
        border-top: 3px solid #ebecf1;
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
        background-color: #4d994a;
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


    #rcorners3 {
        border-radius: 15px 50px;
        /* background: #98ea09; */
        padding: 20px;
        /* width: 200px; */
        height: 80px;
    }

    #rcorners4 {
        border-radius: 15px;
        /* background: #73AD21; */
        padding: 20px;
        /* width: 200px; */
        height: 80px;
        margin-right: 3px;
    }
</style>
<div class="container-fluid side-app" style="margin-top: -35px;">
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card p-3">
                {{-- <div class="col-md-3"> --}}
                    <h5 class="mb-0">Financial Dashboard</h5>
                    <small>Dashboard / Financial Dashboard</small>
                {{-- </div> --}}
            </div>
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body p-2">
                    {{-- <div class="form-row mb-2 ml-3">
                        <div class="col-lg-2">
                            <input type="checkbox" id="checkBox" name="checkBox" value="Year Month" id="">
                            <label for="">Year, Month</label>
                        </div>
                    </div>

                    <div class="form-row mb-2 justify-content-center d-none" id="yearMonth">
                        <div class="col-lg-3">
                            <label for="" style="font-size: 11px; margin: 0px;">Year</label>
                            <select class="form-control" name="" id="">
                                @for ($x = 2000; $x <= date('Y'); $x++)
                                    <option value="{{ $x }}" {{ $x == date('Y') ? 'selected' : '' }}>
                                        {{ $x }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label for="" style="font-size: 11px; margin: 0px;">Month</label>
                            <select class="form-control" name="" id="">
                                @php
                                    $monthArray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                    for ($m = 0; $m < count($monthArray); $m++) {
                                        echo '<option value=' . $monthArray[$m] . '>' . $monthArray[$m] . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="Search"
                                style="margin-top: 20px;" />
                        </div>
                    </div> --}}

                    {{-- <div class="form-row mb-2 justify-content-center" id="dateWise">
                        <div class="col-lg-2">
                            <label for="" style="font-size: 11px; margin: 0px;">Date</label>
                            <input type="text" class="form-control date_picker" name=""
                                placeholder="dd-mm-yyyy" autocomplete="off">
                        </div>

                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="Search"
                                style="margin-top: 20px;" />
                        </div>
                    </div> --}}




                    <div class="row">
                        <div class="col-md-12">
                            @if (!empty($fincData))
                                @foreach ($fincData as $data)
                                    <div class="card shadow-none m-0 " style="">
                                        <div class="card-body p-2">
                                            <div class="row align-items-center ">
                                                <div class="col" id="rcorners4"
                                                    style="width:14%; border-right:1px solid #222;background:#2DCE89 !important;">
                                                    <h3 class="mb-0">
                                                        @if ($data->module_code ==  "OPDC")
                                                            OPD-C
                                                            @elseif ($data->module_code ==  "PHR")
                                                            PHR-OPD
                                                            @elseif ($data->module_code ==  "PHR-I")
                                                            PHR-IPD
                                                            @else
                                                            {{ $data->module_code }}
                                                        @endif

                                                    </h3>
                                                </div>
                                                <div class="col" id="rcorners3" id="corner3"
                                                    style="width:14%; border-right:1px solid #222;background:#cbf648 !important;">
                                                    <p class="mb-1">Sales</p>
                                                    <b>{{ number_format($data->total_sales, 2) }}Tk</b>
                                                </div>
                                                <div class="col" id="rcorners3"
                                                    style="width:14%; border-right:1px solid #222;background:#34f845 !important;">
                                                    <p class="mb-1">Discount</p>
                                                    <b>{{ number_format($data->total_discount, 2) }}Tk</b>
                                                </div>
                                                <div class="col" id="rcorners3"
                                                    style="width:14%; border-right:1px solid #222;background:#c2baae !important;">
                                                    <p class="mb-1">Refund</p>
                                                    <b>{{ number_format($data->total_refund, 2) }}Tk</b>
                                                </div>
                                                <div class="col" id="rcorners3"
                                                    style="width:14%; border-right:1px solid #222;background:#9d4ef0 !important;">
                                                    <p class="mb-1">Collection</p>
                                                    <b>{{ number_format($data->total_collection, 2) }}Tk</b>
                                                </div>
                                                <div class="col" id="rcorners3"
                                                    style="width:14%; border-right:1px solid #222;background:#fe8589 !important;">
                                                    <p class="mb-1">Cash</p>
                                                    <b>{{ number_format($data->total_collection, 2) }}Tk</b>
                                                </div>
                                                <div class="col" id="rcorners3"
                                                    style="width:14%; border-right:1px solid #222;background:#89efb3 !important;">
                                                    <p class="mb-1">Others</p>
                                                    <b>00.00Tk</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-5 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Bar Chart</div>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked" class="chartsh "></div>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- @dd($date_arr) --}}
    <input type="hidden" name="" id="date_arr" value="{{ $date_arr }}">

    <div class="row ">
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">OPD Chart</div>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked" class="chartsh "></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">OPDC Chart</div>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked2" class="chartsh "></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">PHR Chart</div>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked3" class="chartsh "></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">PHR-I Chart</div>
                </div>
                <div class="card-body">
                    <div id="chart-bar-stacked4" class="chartsh "></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-xl-7 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Comparison Graph</div>
                </div>
                <div class="card-body">
                    <div id="piechart_3d" style="width: 900px; height: 50;"></div>
                    <div class="row">

                    </div>
                    <div class="h-300" id="flotBar1"></div>
                </div>
            </div>
        </div>


        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12 wow slideInDown"  data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Patient by Gender</div>
                </div>
                <div class="card-body">
                    <div class="h-300" id="flotPie2"></div>
                </div>
            </div>
        </div> --}}

        <div class="col-xl-5 col-lg-6 col-md-6 col-xm-12 wow slideInRight" data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pie Chart</div>
                </div>
                <div class="card-body">
                    <div class="h-300" id="flotPie1"></div>
                </div>
            </div>
        </div>
    </div>

    @if($management_ind != 1)
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-success "> <i class="fa fa-file" aria-hidden="true"></i> &nbsp; Reports</div>
                <div class="card-body shadow-sm p-0">
                    <div class="card-body">
                        <div class="shortcut-buttons">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                    <a href="{{ route('item-wise-financial-report') }}" rel="tab" target="_blank">
                                        <div class="custom-box-button m-0">
                                            <span>Financial Report</span>
                                        </div>
                                    </a>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                    <a href="{{ route('reports.financial-summary') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Financial Summary</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                    <a href="{{ route('report.cashier-wise-report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Cashier Wise Summary</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                    <a href="{{ route('report.date-wise-cashier-report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Date Wise Cashier Report</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                    <a href="{{ route('ipd.patient-report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>IPD Patient Report</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                    <a href="{{ route('report.Item-Type-Wise-Financial-Report') }}" rel="tab">
                                        <div class="custom-box-button">
                                            <span>Item Type Report</span>
                                        </div>
                                    </a>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Bootstrap4 js-->
<script src="{{ asset('dashboardv2_assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
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

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    new WOW().init();
</script>


<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
    });

    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    // console.log(date_arr);


    $(function() {
        $("#checkBox").click(function() {
            if ($(this).is(":checked")) {
                $("#yearMonth").removeClass('d-none');
                $("#dateWise").addClass('d-none');
            } else {
                $("#yearMonth").addClass('d-none');
                $("#dateWise").removeClass('d-none');
            }
        });

        var date_arr = $("#date_arr").val().split(',');
        console.log(date_arr);
        /******** OPD Chart ********/
        var chart = c3.generate({
            bindto: '#chart-bar-stacked', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $opd_data }}]
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
                    'data1': 'OPD',
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: date_arr
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

        /******** OPDC Chart ********/
        var chart = c3.generate({
            bindto: '#chart-bar-stacked2', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $opdc_data }}]
                ],
                type: 'bar', // default type of chart
                groups: [
                    ['data1', 'data2']
                ],
                colors: {
                    data1: '#fd7e14',
                },
                names: {
                    // name of each serie
                    'data1': 'OPDC',
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: date_arr
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

        /******** PHR Chart ********/
        var chart = c3.generate({
            bindto: '#chart-bar-stacked3', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $phr_data }}]
                ],
                type: 'bar', // default type of chart
                groups: [
                    ['data1', 'data2']
                ],
                colors: {
                    data1: '#ffc107',
                },
                names: {
                    // name of each serie
                    'data1': 'PHR',
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: date_arr
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

        /******** PHR-I Chart ********/
        var chart = c3.generate({
            bindto: '#chart-bar-stacked4', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', {{ $phri_data }}]
                ],
                type: 'bar', // default type of chart
                groups: [
                    ['data1', 'data2']
                ],
                colors: {
                    data1: '#6f42c1',
                },
                names: {
                    // name of each serie
                    'data1': 'PHR-I',
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: date_arr
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






        // /**************** PIE CHART *******************/
        // var piedata = [{
        // 	label: 'Medicine - 50',
        // 	data: [
        // 		[1, 50]
        // 	],
        // 	color: '#fb1c52'
        // }, {
        // 	label: 'Cardiology - 28',
        // 	data: [
        // 		[1, 28]
        // 	],
        // 	color: '#705ec8'
        // }, {
        // 	label: 'Gynaecology - 17',
        // 	data: [
        // 		[1, 17]
        // 	],
        // 	color: '#2dce89'
        // }, {
        // 	label: 'ENT - 10',
        // 	data: [
        // 		[1, 10]
        // 	],
        // 	color: '#ff5b51'
        // }];
        // var piedataGender = [{
        // 	label: 'Male',
        // 	data: [
        // 		[1, 50]
        // 	],
        // 	color: 'cornflowerblue'
        // }, {
        // 	label: 'Female',
        // 	data: [
        // 		[1, 28]
        // 	],
        // 	color: 'darkcyan'
        // }];




        // $.plot('#flotPie1', piedata, {
        // 	series: {
        // 		pie: {
        // 			show: true,
        // 			radius: 1,
        // 			label: {
        // 				show: true,
        // 				radius: 2 / 3,
        // 				formatter: labelFormatter,
        // 				threshold: 0.1
        // 			}
        // 		}
        // 	},
        // 	grid: {
        // 		hoverable: false,
        // 		clickable: true
        // 	}
        // });

        // $.plot('#flotPie2', piedataGender, {
        // 	series: {
        // 		pie: {
        // 			show: true,
        // 			radius: 1,
        // 			innerRadius: 0.4,
        // 			label: {
        // 				show: true,
        // 				radius: 2 / 3,
        // 				formatter: labelFormatter,
        // 				threshold: 0.1
        // 			}
        // 		}
        // 	},
        // 	grid: {
        // 		hoverable: false,
        // 		clickable: true
        // 	}
        // });

        // function labelFormatter(label, series) {
        // 	return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
        // }











    });
</script>
