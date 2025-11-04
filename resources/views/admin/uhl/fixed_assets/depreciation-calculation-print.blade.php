<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medical Category Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    {{-- <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all"> --}}

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td,
        th {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>

</head>

<body>
    @if ($type == 'PDF')
        <header>
            <table style="width: 100%; border:none;" class="signature">
                <tr>
                    <td style="width: 15%; border:none;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    </td>
                    <td style="text-align:center; border:none;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span>
                        <br>
                        Address:
                        <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No:
                        <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                    <!-- <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td> -->
                </tr>
            </table>
        </header>

        <!-- <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div> -->
        <footer style="position: fixed;">
            <div class="footer">
                <div class="container">
                    <table style="width: 100%; padding:3px; margin: 0;border:none;">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>

                        </tr>
                    </table>
                </div>
            </div>
        </footer>
    @endif
    <main>

        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <div style="width:100%; text-align: center; margin-bottom:20px;">
                        <h3> Depreciation Calculate Report</h3>
                    </div>

                    <table class="table table-striped table-bordered table-hover">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center" rowspan="2">sl.</th>
                                <th class="text-left" rowspan="2">Date of process</th>
                                <th class="text-left" rowspan="2">Processed by</th>
                                <th class="text-left" rowspan="2">Major Group</th>
                                {{-- <th class="text-left" rowspan="2">Minor Group</th> --}}
                                <th class="text-center" colspan="4">Cost</th>
                                <th class="text-center" colspan="5">Depreciation</th>
                                <th class="text-center" rowspan="2">WDV</th>
                            </tr>
                            <tr>
                                <th>Balance </th>
                                <th>Addition during the year Taka</th>
                                <th>Disposal/Adjustment Taka</th>
                                <th>Balance </th>
                                <th>Rate %</th>
                                <th>Balance </th>
                                <th>Charged during the year Taka</th>
                                <th>Disposal/Adjustment Taka</th>
                                <th>Balance </th>
                            </tr>
                            <tr>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th class="table_heading_bg">(1)</th>
                                <th class="table_heading_bg">(2)</th>
                                <th class="table_heading_bg">(3)</th>
                                <th class="table_heading_bg">(4)</th>
                                <th class="table_heading_bg">(5)</th>
                                <th class="table_heading_bg">(6)</th>
                                <th class="table_heading_bg">(7)</th>
                                <th class="table_heading_bg">(8)</th>
                                <th class="table_heading_bg">(9)</th>
                                <th class="table_heading_bg">(10)</th>
                                <th class="table_heading_bg">(11)</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (isset($depreciation_arr_group) && !empty($depreciation_arr_group))
                                @php
                                    $total_cost_balance_total = 0;
                                    $total_cost_addition_total = 0;
                                    $total_cost_disposal_adj_total = 0;
                                    $total_cost_cal_total = 0;
                                    $total_depr_rate = 0;
                                    $total_depr_balance_total = 0;
                                    $total_depr_Charged_during_total = 0;
                                    $total_depr_disposal_adj_total = 0;
                                    $total_depr_cal_total = 0;
                                    $total_written_down_value_wdv_total = 0;
                                    $total_depr_charged_during_total = 0;
                                    $total_depr_Charged_during_total = 0;
                                @endphp
                                @foreach ($depreciation_arr_group as $yearMonth => $value)
                                    <tr>
                                        <td style="text-align: left!important;" colspan="15"> <strong>
                                                {{ $yearMonth }}</strong></td>
                                    </tr>
                                    @php
                                        $sum_cost_balance_total = 0;
                                        $sum_cost_addition_total = 0;
                                        $sum_cost_disposal_adj_total = 0;
                                        $sum_cost_cal_total = 0;
                                        $sum_depr_rate = 0;
                                        $sum_depr_balance_total = 0;
                                        $sum_depr_Charged_during_total = 0;
                                        $sum_depr_disposal_adj_total = 0;
                                        $sum_depr_cal_total = 0;
                                        $sum_written_down_value_wdv_total = 0;
                                        $sum_depr_charged_during_total = 0;
                                    @endphp
                                    @foreach ($value as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->processed_date != '' ? date('d/m/Y', strtotime($data->processed_date)) : '' }}
                                            </td>
                                            <td>{{ $data->processed_by_name }}</td>
                                            <td>{{ $data->major_group_name }}</td>
                                            {{-- <td>{{$data->minor_group_name}}</td> --}}
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->cost_balance, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->cost_addition_during_month, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->cost_disposal_adj, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->cost_closing_balance, 2, '.', '') }}</td>
                                            <td class="text-center" style="text-align:right !important;">
                                                {{ number_format($data->dept_rate) }}%</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->dept_balance, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->depr_charged, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->depr_disposal_adj, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->dept_closing_balance, 2, '.', '') }}</td>
                                            <td class="text-right" style="text-align:right !important;">
                                                {{ number_format($data->wdv, 2, '.', '') }}</td>

                                        </tr>

                                        @php
                                            $sum_cost_balance_total += $data->cost_balance;
                                            $sum_cost_addition_total += $data->cost_addition_during_month;
                                            $sum_cost_disposal_adj_total += $data->cost_disposal_adj;
                                            $sum_cost_cal_total += $data->cost_closing_balance;
                                            $sum_depr_rate += 0;
                                            $sum_depr_balance_total += $data->dept_balance;
                                            $sum_depr_charged_during_total += $data->depr_charged;
                                            $sum_depr_disposal_adj_total += $data->depr_disposal_adj;
                                            $sum_depr_cal_total += $data->dept_closing_balance;
                                            $sum_written_down_value_wdv_total += $data->wdv;
                                        @endphp
                                    @endforeach

                                    @php
                                        $total_cost_balance_total += $sum_cost_balance_total;
                                        $total_cost_addition_total += $sum_cost_addition_total;
                                        $total_cost_disposal_adj_total += $sum_cost_disposal_adj_total;
                                        $total_cost_cal_total += $sum_cost_cal_total;
                                        $total_depr_rate += 0;
                                        $total_depr_balance_total += $sum_depr_balance_total;
                                        $total_depr_Charged_during_total += $sum_depr_charged_during_total;
                                        $total_depr_disposal_adj_total += $sum_depr_disposal_adj_total;
                                        $total_depr_cal_total += $sum_depr_cal_total;
                                        $total_written_down_value_wdv_total += $sum_written_down_value_wdv_total;
                                    @endphp
                                @endforeach



                            @endif
                        </tbody>

                    </table>


                </div>
            </section>
        </div>
    </main>
</body>

</html>
