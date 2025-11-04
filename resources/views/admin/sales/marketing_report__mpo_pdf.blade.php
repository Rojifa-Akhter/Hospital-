<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MPO Marketing Sales Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 9px;
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
            /* border-top: 1px solid; */
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
            /* border: 1px solid #222; */
            border-spacing: 0;
            width: 100%
        }

        td {
            /* border: 1px solid #222; */
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    {{-- <header>
        <div style="text-align: center; padding:5px">
            <strong>
                <h1> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
            </strong>
            <strong>
                <h2>Marketing Department</h2>
            </strong>
            <strong>
                <h2>Month Wise OPD & IPD Patients</h2>
            </strong>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To
                        Date: {{ $to_date }}</strong>
                </span>
        </div>

    </header> --}}
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">



                </td>
            </tr>
        </table>
    </header>

    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; ">
            <h2>Marketing Department <span>(MPO Month Wise OPD & IPD Patients)</span></h2>

            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To
                        Date: {{ $to_date }}</strong>
                </span>
        </div>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container">
                    <!-- Agent Data Summary -->
                    <h2 class="text-center">Agent Data Summary</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0 data-table">
                            <thead class="sticky_header">
                                <tr class="bg-primary text-white">
                                    <th class="text-center" style="width: 5%; border: 1px solid #ccc;">SL#</th>
                                    <th class="text-center" style="width: 35%; border: 1px solid #ccc;">Name</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">OPD</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">IPD</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data))
                                    @php
                                        $opd_final = 0;
                                        $ipd_final = 0;
                                        $grand_final = 0;
                                    @endphp

                                    @foreach ($data as $key => $dtp)
                                        <!-- Group Name Row -->
                                        <tr class="table-info">
                                            <td colspan="5" class="font-weight-bold text-left"
                                                style="border: 1px solid #ccc;">
                                                <h2><strong>{{ $key }}</strong></h2>
                                            </td>
                                        </tr>

                                        @foreach ($dtp as $agent => $dt)
                                            <!-- Agent Name Row -->
                                            <tr class="table-secondary">
                                                <td colspan="5" class="text-left font-weight-bold"
                                                    style="border: 1px solid #ccc;">
                                                    <strong>{{ $agent }}</strong>
                                                </td>
                                            </tr>

                                            @foreach ($dt as $value)
                                                @php
                                                    $opd = $value->opd ?? 0;
                                                    $ipd = $value->ipd ?? 0;
                                                    $total = $opd + $ipd;

                                                    $opd_final += $opd;
                                                    $ipd_final += $ipd;
                                                    $grand_final += $total;
                                                @endphp

                                                <!-- Displaying individual record -->
                                                <tr>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ $loop->iteration }}</td>
                                                    <td style="border: 1px solid #ccc;">{{ $value->mpo_name }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($opd) }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($ipd) }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($total) }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        <!-- Group Subtotal -->
                                        <tr class="table-light">
                                            <td colspan="2" class="font-weight-bold text-right"
                                                style="border: 1px solid #ccc;">
                                                <strong>Group Subtotal ({{ $key }}):</strong>
                                            </td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($opd_final) }}</td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($ipd_final) }}</td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($grand_final) }}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Grand Total -->
                                    <tr class="table-dark text-white">
                                        <td colspan="2" class="font-weight-bold text-right"
                                            style="border: 1px solid #ccc;">
                                            <strong>Grand Total:</strong>
                                        </td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($opd_final) }}</td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($ipd_final) }}</td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($grand_final) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center text-danger"
                                            style="border: 1px solid #ccc;">
                                            No data available
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Financial Summary -->
                    <h2 class="text-center mt-4">Financial Summary</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0 data-table">
                            <thead class="sticky_header">
                                <tr class="bg-primary text-white">
                                    <th class="text-center" style="width: 5%; border: 1px solid #ccc;">SL#</th>
                                    <th class="text-center" style="width: 25%; border: 1px solid #ccc;">Name</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Total Patient
                                    </th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Per Patient</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Sales</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Discount</th>
                                    <th class="text-center" style="width: 15%; border: 1px solid #ccc;">Collection
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data))
                                    @php
                                        $total_patient = 0;
                                        $total_sales = 0;
                                        $total_discount = 0;
                                        $total_collection = 0;
                                    @endphp

                                    @foreach ($data as $key => $dtp)
                                        <!-- Group Name Row -->
                                        <tr class="table-info">
                                            <td colspan="7" class="font-weight-bold text-left"
                                                style="border: 1px solid #ccc;">
                                                <h2><strong>{{ $key }}</strong></h2>
                                            </td>
                                        </tr>

                                        @foreach ($dtp as $agent => $dt)
                                            <!-- Agent Name Row -->
                                            <tr class="table-secondary">
                                                <td colspan="7" class="text-left font-weight-bold"
                                                    style="border: 1px solid #ccc;">
                                                    <strong>{{ $agent }}</strong>
                                                </td>
                                            </tr>

                                            @foreach ($dt as $value)
                                                @php
                                                    $opd = $value->opd ?? 0;
                                                    $ipd = $value->ipd ?? 0;
                                                    $patient_count = $opd + $ipd;
                                                    $sales = $value->sales ?? 0;
                                                    $discount = $value->discount ?? 0;
                                                    $collection = $value->payment ?? 0;

                                                    $total_patient += $patient_count;
                                                    $total_sales += $sales;
                                                    $total_discount += $discount;
                                                    $total_collection += $collection;
                                                @endphp

                                                <!-- Displaying individual record -->
                                                <tr>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ $loop->iteration }}</td>
                                                    <td style="border: 1px solid #ccc;">{{ $value->mpo_name }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($patient_count) }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        @if ($patient_count > 0)
                                                            {{ number_format($sales / $patient_count, 2) }}
                                                        @else
                                                            0.00
                                                        @endif
                                                    </td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($sales) }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($discount) }}</td>
                                                    <td class="text-center" style="border: 1px solid #ccc;">
                                                        {{ number_format($collection) }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        <!-- Group Subtotal -->
                                        <tr class="table-light">
                                            <td colspan="2" class="font-weight-bold text-right"
                                                style="border: 1px solid #ccc;">
                                                <strong>Group Subtotal ({{ $key }}):</strong>
                                            </td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($total_patient) }}</td>
                                            <td class="text-center" style="border: 1px solid #ccc;"></td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($total_sales) }}</td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($total_discount) }}</td>
                                            <td class="text-center" style="border: 1px solid #ccc;">
                                                {{ number_format($total_collection) }}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Grand Total -->
                                    <tr class="table-dark text-white">
                                        <td colspan="2" class="font-weight-bold text-right"
                                            style="border: 1px solid #ccc;">
                                            <strong>Grand Total:</strong>
                                        </td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($total_patient) }}</td>
                                        <td class="text-center" style="border: 1px solid #ccc;"></td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($total_sales) }}</td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($total_discount) }}</td>
                                        <td class="text-center" style="border: 1px solid #ccc;">
                                            {{ number_format($total_collection) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-danger"
                                            style="border: 1px solid #ccc;">
                                            No data available
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </main>
    <footer class="">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        // window.close(); // Close the window after printing
    }
</script>
