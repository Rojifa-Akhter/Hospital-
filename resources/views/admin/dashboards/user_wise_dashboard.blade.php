<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
<!-- Style css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/css/style.css') }}" />
{{-- use on  My Dashboard --}}
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/css/custom.css') }}" />

<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<style>
    .collapse:not(.show) {
        background: inherit !important;
    }

    .head_text {
        font-size: 12px;
        font-weight: 900;
    }

    .dash1-card .ratio {
        font-size: 16px;
        background-color: transparent;
        color:#333;
        padding: 4px 20px;
        position: relative;
        top:-14px;
        right:14px;
        text-align: center;
    }
</style>

<div class="container-fluid side-app" style="margin-top: -35px;">
    <div class="row">
        @if (!empty($user_privileage_card))
            @foreach ($user_privileage_card as $user)
                @php
                    $query = DB::select($user->dash_board_item_query);
                    $value = isset($query[0]->column1) ? $query[0]->column1 : 0;
                    $query2 = '';
                    $value2 = 0;
                    if (isset($user->compariso_query)) {
                        $query2 = DB::select($user->compariso_query);
                        $value2 = isset($query2[0]->column1) ? $query2[0]->column1 : 0;
                    }

                @endphp

                <div class="col-xl-3 col-lg-3 col-md-3 col-xm-12 wow slideInLeft" data-wow-duration="1s">
                    <div class="card overflow-hidden dash1-card border-0">
                        <div class="card-body">
                            <h5 class="mb-1 head_text">
                                {{ $user->dashboard_items }}
                                @if ($value >= $value2)
                                    <span class="text-green-highlight"><i class="fa fa-caret-up  mr-1"></i>
                                    </span>
                                @else
                                    <span class="text-danger"><i class="fa fa-caret-down  mr-1"></i>
                                    </span>
                                @endif
                            </h5>
                            <p class="mb-1 mt-5 head_number_no">
                                {{ $user->dashboard_value }} &nbsp;
                            </p>
                            <p class="ratio"> {{ $value }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (!empty($user_privileage_text) && count($user_privileage_text) > 1)
        <div class="row">


            <div class="col-lg-4 col-md-4 wow slideInDown" data-wow-duration="1s">
                <div class="card">
                    <div class="card-body">

                        <ul class="list-group w-100">
                            @foreach ($user_privileage_text as $key => $test)
                                @if ($key < 11)
                                    @php
                                        $query = DB::select($test->dash_board_item_query);
                                        $value = isset($query[0]->column1) ? $query[0]->column1 : 0;
                                    @endphp

                                    <li
                                        class=" number-font list-group-item d-flex justify-content-between align-items-center">
                                        {{ $test->dashboard_items }}
                                        @if ($value < 50)
                                            <span
                                                class="number-font badge badge-danger badge-pill">{{ $value }}</span>
                                        @elseif($value < 3000)
                                            <span
                                                class="number-font badge badge-warning badge-pill">{{ $value }}</span>
                                        @else
                                            <span
                                                class="number-font badge badge-success badge-pill">{{ $value }}</span>
                                        @endif
                                    </li>
                                @else
                                @endif
                            @endforeach

                        </ul>

                    </div>
                </div>
            </div>
        </div>
        {{-- @else

        <div class="row">


            <div class="col-lg-12 col-md-12 wow slideInDown" data-wow-duration="1s">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="row w-100">

                            <div class="col-12">
                                You Have no privillege in Dashboard
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

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

<script>
    new WOW().init();
</script>
