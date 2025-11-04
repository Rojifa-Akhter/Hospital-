<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Marketing Sales Report</title>
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
                <h2>Marketing Department <span>(Month Wise OPD & IPD Patients)</span></h2>

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
                <div class="container ">


                    <table class="table table-bordered table-striped mb-0 data-table">
                        <thead class="sticky_header">
                            <tr class="bg-light-blue">
                                <th class="text-center">SL#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">OPD</th>
                                <th class="text-center">IPD</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($data))
                                @php
                                    $opd_final = 0;
                                    $ipd_final = 0;
                                    $grand_final = 0;
                                @endphp
                                @foreach ($data as $key => $dt)
                                    <tr>
                                        <td colspan="5" class="text-left font-weight-bold;border: 1px solid #222;" style="border: 1px solid #222;">
                                           <strong> {{ $key }}</strong>
                                        </td>
                                    </tr>

                                    @php
                                        $opd_total = 0;
                                        $ipd_total = 0;
                                        $grand_total = 0;
                                    @endphp
                                    @foreach ($dt as $value)
                                        @php
                                            $opd = !empty($value->opd) ? $value->opd : 0;
                                            $ipd = !empty($value->ipd) ? $value->ipd : 0;
                                            $total = $opd + $ipd;

                                            $opd_total += $opd;
                                            $ipd_total += $ipd;
                                            $grand_total += $total;

                                            // Accumulate final totals
                                            $opd_final += $opd;
                                            $ipd_final += $ipd;
                                            $grand_final += $total;
                                        @endphp

                                        <tr>
                                            <td class="text-right" style="border: 1px solid #222;">{{ $loop->iteration }}</td>
                                            <td class="text-left" style="border: 1px solid #222;">{{ $value->full_name }}</td>
                                            <td class="text-center" style="border: 1px solid #222;">{{ $opd }}</td>
                                            <td class="text-center" style="border: 1px solid #222;">{{ $ipd }}</td>
                                            <td class="text-center" style="border: 1px solid #222;">{{ $total }}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="bg-light-gray">
                                        <td class="font-weight-bold text-right" colspan="2" style="border: 1px solid #222;">Sub Total =</td>
                                        <td class="text-center" style="border: 1px solid #222;">{{ $opd_total }}</td>
                                        <td class="text-center" style="border: 1px solid #222;">{{ $ipd_total }}</td>
                                        <td class="text-center" style="border: 1px solid #222;">{{ $grand_total }}</td>
                                    </tr>
                                @endforeach

                                <tr class="bg-light-gray">
                                    <td class="font-weight-bold text-right" colspan="2" style="border:1px solid #222;">Total =</td>
                                    <td class="text-center" style="border:1px solid #222;">{{ $opd_final }}</td>
                                    <td class="text-center" style="border:1px solid #222;">{{ $ipd_final }}</td>
                                    <td class="text-center" style="border:1px solid #222;">{{ $grand_final }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <h2 class="text-center">Financial Part</h2>
                    {{-- Financial Part --}}

                    <table class="table table-bordered table-striped mb-0 data-table">
                        <thead class="sticky_header">
                            <tr class="bg-light-blue">
                                <th class="text-center">SL#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Total Patient</th>                                
                                <th class="text-center">Per Patient</th>
                                <th class="text-center">Sales</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($data))
                                @php
                                    $sales_final = 0;
                                    $discount_final = 0;
                                    $collection_final = 0;
                                    $patient_final = 0;
                                @endphp
                                @foreach ($data as $key => $dt)
                                    <tr>
                                        <td colspan="7" class="text-left font-weight-bold" style="border: 1px solid #222;">
                                            <strong>{{ $key }}</strong>
                                        </td>
                                    </tr>

                                    @php
                                        $sales_total = 0;
                                        $discount_total = 0;
                                        $collection_total = 0;
                                        $grand_patient = 0;
                                    @endphp
                                    @foreach ($dt as $value)
                                        @php
                                            $opd = !empty($value->opd) ? $value->opd : 0;
                                            $ipd = !empty($value->ipd) ? $value->ipd : 0;
                                            $sales = !empty($value->sales) ? $value->sales : 0;
                                            $discount = !empty($value->discount) ? $value->discount : 0;
                                            $collection = !empty($value->payment) ? $value->payment : 0;

                                            $total_patient = $opd + $ipd;

                                            $grand_patient += $total_patient;
                                            $sales_total += $sales;
                                            $discount_total += $discount;
                                            $collection_total += $collection;

                                        @endphp

                                        <tr>
                                            <td class="text-right" style="border: 1px solid #222;">{{ $loop->iteration }}</td>
                                            <td class="text-left" style="border: 1px solid #222;">{{ $value->full_name }}</td>
                                            <td class="text-center" style="border: 1px solid #222;">{{ $total_patient }}</td>                                            
                                            <td class="text-right" style="border: 1px solid #222;">{{ number_format($sales / $total_patient) }}</td>
                                            <td class="text-right" style="border: 1px solid #222;">{{ number_format($sales) }}</td>
                                            <td class="text-right" style="border: 1px solid #222;">{{ number_format($discount) }}</td>
                                            <td class="text-right" style="border: 1px solid #222;">{{ number_format($collection) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="bg-light-gray">
                                        <td class="font-weight-bold text-right" colspan="2" style="border: 1px solid #222;">Sub Total =</td>
                                        <td class="text-center" style="border: 1px solid #222;">{{ $grand_patient }}</td>
                                        <td class="text-right" style="border: 1px solid #222;"></td>
                                        <td class="text-right" style="border: 1px solid #222;">{{ number_format($sales_total) }}</td>
                                        
                                        <td class="text-right" style="border: 1px solid #222;">{{ number_format($discount_total) }}</td>
                                        <td class="text-right" style="border: 1px solid #222;">{{ number_format($collection_total) }}</td>
                                    </tr>

                                    @php
                                        // Accumulate final totals for financials
                                        $patient_final += $grand_patient;
                                        $sales_final += $sales_total;
                                        $discount_final += $discount_total;
                                        $collection_final += $collection_total;
                                    @endphp
                                @endforeach

                                <tr class="bg-light-gray">
                                    <td class="font-weight-bold text-right" colspan="2" style="border: 1px solid #222;">Total =</td>
                                    <td class="text-center" style="border: 1px solid #222;">{{ $patient_final }}</td> {{-- This should be updated correctly --}}
                                    <td class="text-right" style="border: 1px solid #222;"></td>
                                    <td class="text-right" style="border: 1px solid #222;">{{ number_format($sales_final) }}</td>

                                    <td class="text-right" style="border: 1px solid #222;">{{ number_format($discount_final) }}</td>
                                    <td class="text-right" style="border: 1px solid #222;">{{ number_format($collection_final) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

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
