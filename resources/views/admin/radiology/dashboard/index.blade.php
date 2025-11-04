<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('pharmacy/assets/css/icons.css') }}" rel="stylesheet" />

<!-- Style css -->
<link href="{{ asset('pharmacy/assets/css/style.css') }}" rel="stylesheet" />
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
        font-size: 11px !important;
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
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-3">
            <h5 class="mb-0">Radiology Dashboard</h5>
            <small>Radiology / Radiology Dashboard</small>
        </div>

        <div class="col-md-9">
            <div class="form-row justify-content-end mt-2">
                <div class="col-md-2">
                    <a href="#" class="btn btn-success btn-block btn-md"><i class="fa fa-sync"></i> Refresh</a>
                </div>
            </div>
        </div>
    </div>


    <div class="form-row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                {{-- <div class="today" class=""> --}}

                <div class="col-xl-3 col-md-3">
                    <div class="card widget-box-two bg-pink border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Sales Today">
                                        Today RAD Inv. Summary </p>
                                    @php
                                        // $sales_data = !empty($dashboard_data['ROW01COL1_PHR']) ? explode('_', $dashboard_data['ROW01COL1_PHR']) : [];
                                    @endphp

                                    <h2 class="text-white my-1 count"><span data-plugin="counterup">
                                            {{ !empty($total_inv_ipd[0]->total) ? $total_inv_ipd[0]->total : '0' }}
                                            {{-- {{ isset($sales_data[0]) ? number_format($sales_data[0], 2) : '0.00' }}</span> --}}
                                    </h2>
                                    {{-- <p class="text-white m-0 font-12 ">
                                        <b>4%</b>
                                        From Previous Period
                                    </p> --}}
                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="icofont-money  font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
                @if (!empty($total_pathology_by_dep))
                    @foreach ($total_pathology_by_dep as $total_dep)
                        <div class="col-xl-3 col-md-3">
                            <div class="card widget-box-two bg-info border-0 mb-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body wigdet-two-content">
                                            <p class="m-0 text-uppercase font-12 text-white" title="Appointment Today">
                                                Today's Patient Summary ({{ $total_dep->serviceunit_name }}) </p>
                                            @php
                                                // $callection_data = !empty($dashboard_data['ROW01COL2_PHR']) ? explode('_', $dashboard_data['ROW01COL2_PHR']) : [];
                                            @endphp

                                            <h2 class="text-white my-1 count"><span data-plugin="counterup">
                                                    {{ !empty($total_dep->total) ? $total_dep->total : '0' }}
                                                    {{-- {{ !empty($callection_data[0]) ? number_format($callection_data[0], 2) : '0.00' }} --}}
                                                </span>

                                            </h2>
                                            {{-- <p class="text-white m-0 font-12 ">
                                        <b>2%</b>
                                        From Previous Period
                                    </p> --}}
                                        </div>
                                        <div
                                            class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                            <i class="icofont-money-bag  font-22 avatar-title text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- end col -->
            </div>

            <div class="row">
                {{-- <div class="today" class=""> --}}

                <div class="col-xl-3 col-md-3">
                    <div class="card widget-box-two bg-pink border-0 mb-0">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body wigdet-two-content">
                                    <p class="m-0 text-uppercase font-12 text-white" title="Sales Today">
                                        Last Month Total Lab Inv. Summary </p>
                                    @php
                                        // $sales_data = !empty($dashboard_data['ROW01COL1_PHR']) ? explode('_', $dashboard_data['ROW01COL1_PHR']) : [];
                                    @endphp

                                    <h2 class="text-white my-1 count"><span data-plugin="counterup">
                                            {{ !empty($total_inv_ipd_last_month[0]->total) ? $total_inv_ipd_last_month[0]->total : '0.00' }}
                                            {{-- {{ isset($sales_data[0]) ? number_format($sales_data[0], 2) : '0.00' }}</span> --}}
                                    </h2>
                                    {{-- <p class="text-white m-0 font-12 ">
                                        <b>4%</b>
                                        From Previous Period
                                    </p> --}}
                                </div>
                                <div class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                    <i class="icofont-money  font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
                @if (!empty($total_inv_ipd_last_month_by_dep))
                    @foreach ($total_inv_ipd_last_month_by_dep as $total_dep)
                        <div class="col-xl-3 col-md-3">
                            <div class="card widget-box-two {{ $loop->iteration%2==0 ? "bg-success":"bg-primary"  }} border-0 mb-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body wigdet-two-content">
                                            <p class="m-0 text-uppercase font-12 text-white" title="Appointment Today">
                                                Last Month Patient Summary ({{ $total_dep->serviceunit_name }}) </p>
                                            @php
                                                // $callection_data = !empty($dashboard_data['ROW01COL2_PHR']) ? explode('_', $dashboard_data['ROW01COL2_PHR']) : [];
                                            @endphp

                                            <h2 class="text-white my-1 count"><span data-plugin="counterup">
                                                    {{ !empty($total_dep->total) ? $total_dep->total : '0' }}
                                                    {{-- {{ !empty($callection_data[0]) ? number_format($callection_data[0], 2) : '0.00' }} --}}
                                                </span>

                                            </h2>
                                            {{-- <p class="text-white m-0 font-12 ">
                                        <b>2%</b>
                                        From Previous Period
                                    </p> --}}
                                        </div>
                                        <div
                                            class="avatar avatar-md rounded-circle bg-soft-light ml-2 align-self-center">
                                            <i class="icofont-money-bag  font-22 avatar-title text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- end col -->
            </div>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="card mb-0">
                <div class="card-body border-top">
                    <h6 class="card-title mb-1">Slow Moving Investigation <span>(Last 3 Month)</span>
                    </h6>
                    <div class="col-12 table-responsive p-0 ">
                        <table class="table data-table table-striped table-bordered table-hover data-table appointment">
                            <thead>
                                <th>SL</th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Last Inv. Date</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @if (!empty($month_low_inv))
                                    @foreach ($month_low_inv as $row)
                                        <tr class="">
                                            <td class="border-0">{{ $loop->iteration }}</td>
                                            <td class="border-0">
                                                {{ !empty($row->item_name) ? $row->item_name : 'N/A' }} </td>
                                            <td class="border-0">
                                                {{ !empty($row->last_invoice_date) ? date('d/m/Y', strtotime($row->last_invoice_date)) : 'N/A' }}
                                            </td>
                                            <td class="border-0">
                                                {{ !empty($row->item_qty) ? $row->item_qty : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="card mb-0">
                <div class="card-body border-top">
                    <h6 class="card-title mb-1">Top Sales Investigation <span>(Last 3 Month)</span>
                    </h6>
                    <div class="col-12 table-responsive p-0 ">
                        <table
                            class="table data-table table-striped table-bordered table-hover data-table appointment">
                            <thead>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @if (!empty($month_low_inv))
                                @foreach ($month_low_inv as $row)
                                    <tr class="">
                                        <td class="border-0">{{ $loop->iteration }}</td>
                                        <td class="border-0">
                                            {{ !empty($row->item_name) ? $row->item_name : 'N/A' }} </td>
                                        <td class="border-0">
                                            {{ !empty($row->item_qty) ? $row->item_qty : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>







        {{-- Quick Links : --}}

        @if ($management_ind != 1)
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header bg-success">Reports</div>
                    <div class="card-body shadow-sm p-0">
                        <div class="card-body">
                            <div class="shortcut-buttons">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                        <a href="{{ route('reports.pharmacy-daily-sales') }}" target="_blank">
                                            <div class="custom-box-button m-0">
                                                <span>Date Wise Cashier Report</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('report.phr-profit-lose-Financial-Report') }}"
                                            target="_blank">
                                            <div class="custom-box-button">
                                                <span>Profit-Loss</span>
                                            </div>
                                        </a>
                                    </div>


                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('reports.pharmacy-daily-sales') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Daily Sales</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('reports.pharmacy-daily-collection') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Daily Collection</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('reports.pharmacy-daily-discount') }}">
                                        <div class="custom-box-button">
                                            <span>Daily Discount</span>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('report.pharmacy-cashier-wise-report') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Cashier Wise</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('pharmacy.cashier_wise_collection') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Cashier Wise Collection</span>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('report.pharmacy-card-payment-details') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Card Payment</span>
                                        </div>
                                    </a>
                                </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($management_ind != 1)
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header bg-success">Quick Links</div>
                    <div class="card-body shadow-sm p-0">
                        <div class="card-body">
                            <div class="shortcut-buttons">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                                        <a href="{{ route('billing.pharmacy-billing') }}" target="_blank">
                                            <div class="custom-box-button m-0">
                                                <span>POS</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('pos-billing-list') }}" target="_blank">
                                            <div class="custom-box-button">
                                                <span>POS Billing List</span>
                                            </div>
                                        </a>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('inventory.item_po_worklist') }}" target="_blank">
                                            <div class="custom-box-button">
                                                <span>Generate PO</span>
                                            </div>
                                        </a>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('supplier_delivery_viewer') }}" target="_blank">
                                            <div class="custom-box-button">
                                                <span>Supplier Schedule Viewer</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('rate.management/general/phr') }}" target="_blank">
                                            <div class="custom-box-button">
                                                <span>Rate Management</span>
                                            </div>
                                        </a>
                                    </div>


                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="{{ route('inventory.stock_adjustment') }}"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Stock Adjustment</span>
                                        </div>
                                    </a>
                                </div> --}}

                                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <a href="#"  target="_blank">
                                        <div class="custom-box-button">
                                            <span>Stock</span>
                                        </div>
                                    </a>
                                </div> --}}

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="{{ route('inventory.stock-ledger') }}" target="_blank">
                                            <div class="custom-box-button">
                                                <span>Stock Ledger</span>
                                            </div>
                                        </a>
                                    </div>






                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif



    </div>


</div>




{{-- <div class="app sidebar-mini  dark-mode">
    <div class="page p-4">
        <div class="page-main">
            <!-- App-Content -->
            <div class="app-content main-content">
                <div class="side-app">

                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- {{ dd($echart_data) }} --}}



{{-- Echart Value --}}
{{-- @php
$price = '';
@endphp
@foreach ($echart_data as $item)
    @php
        $price .= $item->total_sales . ',';
    @endphp

@endforeach --}}

@foreach ($echart_data as $money)
    <input type='hidden' id='sales' value='{{ $money->total_sales }}'>
    <input type='hidden' id='collection' value='{{ $money->total_collection }}'>
@endforeach


{{-- <input type='hidden' id='total_sales' value='{{ $money->sum('total_sales') }}'>
<input type='hidden' id='total_collection' value='{{ $money->sum('total_collection') }}'> --}}
{{-- <input type='hidden' id='max_collection' value='{{ $echart_data->max('total_sales') }}'>
<input type='hidden' id='max_sales' value='{{ $echart_data->max('total_collection') }}'> --}}



@php
    //dd($echart_data);
@endphp

@for ($i = 0; $i < 24; $i++)
    <input type="hidden" id="dt_{{ $i }}" class="sales_dt"
        value="{{ isset($echart_data[$i]->total_sales) ? $echart_data[$i]->total_sales : '0' }}">
@endfor

@for ($i = 0; $i < 24; $i++)
    <input type="hidden" id="cdt_{{ $i }}" class="collection_cdt"
        value="{{ isset($echart_data[$i]->total_collection) ? $echart_data[$i]->total_collection : '0' }}">
@endfor

{{-- End Echart Value --}}



<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<!--Othercharts js-->
<script src="{{ asset('pharmacy/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

<!-- Peitychart js-->
<script src="{{ asset('pharmacy/assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
<script src="{{ asset('pharmacy/assets/plugins/peitychart/peitychart.init.js') }}"></script>

<!-- INTERNAl Apexchart js-->
<script src="{{ asset('pharmacy/assets/js/apexcharts.js') }}"></script>

<!-- Circle-progress js-->
<script src="{{ asset('pharmacy/assets/js/circle-progress.min.js') }}"></script>

<!-- Jquery-rating js-->
<script src="{{ asset('pharmacy/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!-- INTERNAl Chart js -->
<script src="{{ asset('pharmacy/assets/plugins/chart/chart.min.js') }}"></script>
<script src="{{ asset('pharmacy/assets/plugins/chart/chart.extension.js') }}"></script>

<!--INTERNAL ECharts js-->
<script src="{{ asset('pharmacy/assets/plugins/echarts/echarts.js') }}"></script>




<!-- Waypoints Min Js -->
<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");

    $('.appointment').DataTable({
        "lengthMenu": [
            [10],
            [10]
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



    $(function(e) {
        'use strict'

        const sales_dt_arr = [];
        const collection_dt_arr = [];
        // const =  0;


        const sales_dt_rec = $('.sales_dt');
        Array.from(sales_dt_rec).forEach((sales) => {
            // sum_sale += $(sales).val()
            sales_dt_arr.push($(sales).val())
        })
        // console.log(sum_sale)


        const collection_cdt_rec = $('.collection_cdt');
        Array.from(collection_cdt_rec).forEach((collection) => {
            collection_dt_arr.push($(collection).val())

        })

        const arr_merge = sales_dt_arr.concat(collection_dt_arr)

        const max_sale = Math.max(...sales_dt_arr)
        const max_collection = Math.max(...collection_dt_arr)

        // const sum_sale = _.sum(sales_dt_arr);

        $("#t_sales").html(max_sale);
        $("#t_collection").html(max_collection);

        $("#total_sale").html('20000');
        $("#total_collection").html('15600');





        var chartdata = [{
                name: 'Total Collection',
                type: 'line',
                smooth: true,
                data: collection_dt_arr,
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
                name: 'Total Sales',
                symbolSize: 20,
                barWidth: 20,
                type: 'bar',
                data: sales_dt_arr,


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



        console.log('Chart data', arr_merge);

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
                data: [
                    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14',
                    '15', '16', '17', '18', '19', '20', '21', '22', '23'
                ],

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
                },
                ticks: {
                    scaleIntegersOnly: true
                },
                min: Math.min(...arr_merge),
                max: Math.max(...arr_merge)
            },
            series: chartdata,
            color: ['#ef6430', '#2205bf']
        };
        barChart.setOption(option);
        /* E-chart */

    });
</script>
