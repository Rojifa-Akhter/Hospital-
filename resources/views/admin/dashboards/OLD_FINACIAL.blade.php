<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
<!-- Style css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/css/style.css') }}" />

<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
{{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}

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

</style>

<div class="container-fluid side-app" style="margin-top: -35px;">
    <div class="row">
        <div class="col-xl-7 col-lg-6 col-md-6 col-xm-12 wow slideInLeft" data-wow-duration="1s">
            <div class="card overflow-hidden dash1-card border-0">
                <div class="card-body p-2">
                    <div class="form-row mb-2 ml-3">
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
                                    <option value="{{ $x }}" {{ $x == date('Y') ? 'selected' : '' }}>{{ $x }}</option>
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
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="Search" style="margin-top: 20px;"/>
                        </div>
                    </div>

                    <div class="form-row mb-2 justify-content-center" id="dateWise">
                        <div class="col-lg-6">
                            <label for="" style="font-size: 11px; margin: 0px;">Date</label>
                            <input type="text" class="form-control date_picker" name="" placeholder="dd-mm-yyyy" autocomplete="off">
                        </div>

                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="Search" style="margin-top: 20px;"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if (!empty($fincData))
                                @foreach ($fincData as $data)
                                    <div class="card shadow-none m-0" style="border:0; border-top: 1px solid #222; border-bottom: 1px solid #222;" >
                                        <div class="card-body p-2">
                                            <div class="row align-items-center">
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <h3 class="mb-0">{{ $data->module_code }}</h3>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Sales</p>
                                                    <b>{{ number_format($data->total_sales,2) }}Tk</b>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Discount</p>
                                                    <b>{{ number_format($data->total_discount,2) }}Tk</b>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Refund</p>
                                                    <b>{{ number_format($data->total_refund,2) }}Tk</b>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Collection</p>
                                                    <b>{{ number_format($data->total_collection,2) }}Tk</b>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Cash</p>
                                                    <b>{{ number_format($data->total_collection,2) }}Tk</b>
                                                </div>
                                                <div class="col" style="width:14%; border-right:1px solid #222">
                                                    <p class="mb-1">Others</p>
                                                    <b>00.00Tk</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- <div class="card shadow-none m-0" style="border:0; border-top: 1px solid #222; border-bottom: 1px solid #222;" >
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <h3 class="mb-0">LAB</h3>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Sales</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Discount</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Refund</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Collection</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Cash</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%;>
                                            <p class="mb-1">Others</p>
                                            <b>1000Tk</b>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-none m-0" style="border:0; border-top: 1px solid #222; border-bottom: 1px solid #222;" >
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <h3 class="mb-0">RAD</h3>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Sales</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Discount</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Refund</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Collection</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Cash</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%;>
                                            <p class="mb-1">Others</p>
                                            <b>1000Tk</b>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-none m-0" style="border:0; border-top: 1px solid #222; border-bottom: 1px solid #222;" >
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <h3 class="mb-0">IPD</h3>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Sales</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Discount</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Refund</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Collection</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Cash</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%;>
                                            <p class="mb-1">Others</p>
                                            <b>1000Tk</b>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-none m-0" style="border:0; border-top: 1px solid #222; border-bottom: 1px solid #222;" >
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <h3 class="mb-0">PHR</h3>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Sales</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Discount</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Refund</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Collection</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%; border-right:1px solid #222">
                                            <p class="mb-1">Cash</p>
                                            <b>1000Tk</b>
                                        </div>
                                        <div class="col" style="width:14%;>
                                            <p class="mb-1">Others</p>
                                            <b>1000Tk</b>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-6 col-md-6 col-xm-12 wow slideInRight"  data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Bar Chart</div>
                </div>
                <div class="card-body">
                    <div class="h-300" id="flotBar1"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        {{-- <div class="col-xl-7 col-lg-6 col-md-6 col-xm-12 wow slideInLeft"  data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Comparison Graph</div>
                </div>
                <div class="card-body">
                    <div class="row">

                    </div>
                    <div class="h-300" id="flotBar1"></div>
                </div>
            </div>
        </div> --}}


        <div class="col-xl-7 col-lg-6 col-md-6 col-xm-12 wow slideInLeft"  data-wow-duration="1s">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Comparison Graph</div>
                </div>
                <div class="card-body">
                    {{-- <div id="top_x_div" style="width: 800px; height: 600px;"></div> --}}
                    <script src="https://www.gstatic.com/charts/loader.js"></script>
                    <div id="chart_div"></div>

                </div>
            </div>
        </div>




        <div class="col-xl-5 col-lg-6 col-md-6 col-xm-12 wow slideInRight"  data-wow-duration="1s">
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

</div>

<!-- Bootstrap4 js-->
<script src="{{ asset('dashboardv2_assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


<!-- Animate js-->
<script src="{{ asset('dashboardv2_assets/WOW-master/dist/wow.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


<script>
    new WOW().init();
</script>


 <script type="text/javascript">

// google.charts.load('current', {packages: ['corechart', 'bar']});
// google.charts.setOnLoadCallback(drawBasic);


function LoadGoogle(){
  google.charts.load('current', {
    callback: drawChart,
    packages:['corechart']
  }
  );


function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'Time of Day');
      data.addColumn('number', 'Motivation Level');

      data.addRows([
        [{v: [8, 0, 0], f: '8 am'}, 1],
        [{v: [9, 0, 0], f: '9 am'}, 2],
        [{v: [10, 0, 0], f:'10 am'}, 3],
        [{v: [11, 0, 0], f: '11 am'}, 4],
        [{v: [12, 0, 0], f: '12 pm'}, 5],
        [{v: [13, 0, 0], f: '1 pm'}, 6],
        [{v: [14, 0, 0], f: '2 pm'}, 7],
        [{v: [15, 0, 0], f: '3 pm'}, 8],
        [{v: [16, 0, 0], f: '4 pm'}, 9],
        [{v: [17, 0, 0], f: '5 pm'}, 10],
      ]);

      var options = {
        title: 'Motivation Level Throughout the Day',
        hAxis: {
          title: 'Time of Day',
          format: 'h:mm a',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: 'Rating (scale of 1-10)'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }
}
LoadGoogle();

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


    $(function () {
        $("#checkBox").click(function () {
            if ($(this).is(":checked")) {
                $("#yearMonth").removeClass('d-none');
                $("#dateWise").addClass('d-none');
            } else {
                $("#yearMonth").addClass('d-none');
                $("#dateWise").removeClass('d-none');
            }
        });
    });
</script>


