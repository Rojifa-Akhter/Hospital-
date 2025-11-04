<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Statement Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
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

        td {
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
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
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
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By
                    </span>
                </td>
                <td style="text-align:center; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Receved By </span>
                </td>

                <td style="text-align:center; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Checked By
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>



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
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Financial Statement
                    Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <thead>
                            <tr class="bg-light-blue" style="border-bottom:1px solid #000;">
                                {{-- <th rowspan="2" class="text-center"> Date</th> --}}
                                <th class="text-center" style="border-bottom:1px solid #000;">Income Head</th>
                                <th class="text-center" style="border-bottom:1px solid #000;">Notes</th>
                                <th class="text-center" style="border-bottom:1px solid #000;">TK</th>
                                {{-- <th rowspan="2" class="text-center">TK</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $f_bottom_head = $f_dr_amt = $f_cr_amt = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $key => $data)
                                    @php
                                        $t_bottom_head = $t_dr_amt = $t_cr_amt = 0;
                                    @endphp

                                    <tr class="bg-primary">
                                        <td colspan="3" style="text-align: left"><strong>
                                                @if ($key == 'CURRENT ASSET')
                                                    {{ 'ASSETS' }}
                                                @elseif ($key == 'CURRENT LIABILITY')
                                                    {{ 'LIABILITIES' }}
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    @foreach ($data as $key1 => $dt)
                                        <tr class="bg-info">
                                            <td colspan="3" style="text-align: left"><strong>
                                                    {{ ucfirst($key1) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        @php
                                            $total_bottom_head = $total_dr_amt = $total_cr_amt = 0;
                                        @endphp
                                        @foreach ($dt as $value)
                                            <tr>
                                                {{-- <td class="text-left"><strong>{{ $value->journal_date }}</strong> </td> --}}
                                                <td class="text-left">
                                                    {{ !empty($value->root_head_5) ? ucfirst($value->root_head_5) : 'N/A' }}
                                                </td>

                                                <td class="text-center"  style="text-align: center">
                                                    {{ !empty($value->bottom_head) ? $value->bottom_head : 0 }}</td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ !empty($value->amount) ? number_format($value->amount, 1) : '0.00' }}
                                                </td>
                                                {{-- <td class="text-right"> --}}
                                                    {{-- {{ !empty($value->amount) ? number_format($value->amount, 1) : '0.00' }}</td> --}}
                                                    <div style="display: none">
                                                        <strong>{{ $total_bottom_head += $value->bottom_head }}</strong>
                                                    </div>
                                                    <div style="display: none">
                                                        <strong>{{ $total_dr_amt += $value->amount }}</strong>
                                                    </div>
                                                    {{-- <div style="display: none"><strong>{{ $total_cr_amt += $value->amount }}</strong>
                                            </div> --}}

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-right" style="text-align: right">TOTAL {{ ucfirst(strtolower($key)) }} =</th>
                                            <th class="text-center bg-light-blue"style="text-align: center">{{ $total_bottom_head }}</th>
                                            <th class="text-right bg-light-blue" style="text-align: right">{{ number_format($total_dr_amt, 2) }}
                                            </th>
                                            {{-- <th class="text-right bg-light-blue">{{ number_format($total_cr_amt, 2) }}</th> --}}
                                        </tr>
                                        <div style="display: none">
                                            <strong>{{ $t_bottom_head += $total_bottom_head }}</strong>
                                        </div>
                                        <div style="display: none"><strong>{{ $t_dr_amt += $total_dr_amt }}</strong>
                                        </div>

                                        {{-- <div style="display: none">{{ $debit += $debit_sub }}</div>
                                    <div style="display: none">{{ $credit += $credit_sub }}</div> --}}
                                    @endforeach
                                    <tr class="bg-warning">
                                        <th class="text-right" style="text-align: right;border-bottom:1px solid #000;">TOTAL @if ($key == 'CURRENT ASSET')
                                                {{ 'ASSETS' }}
                                            @elseif ($key == 'CURRENT LIABILITY')
                                                {{ 'LIABILITIES' }}
                                            @endif =</th>
                                        <th class="text-center"style="text-align: center;border-bottom:1px solid #000;">{{ $t_bottom_head }}</th>
                                        <th class="text-right" style="text-align: right;border-bottom:1px solid #000;">{{ number_format($t_dr_amt, 2) }}</th>
                                        <div style="display: none"><strong>{{ $f_dr_amt += $total_dr_amt }}</strong>
                                        </div>
                                        {{-- <th class="text-right bg-light-blue">{{ number_format($total_cr_amt, 2) }}</th> --}}
                                    </tr>
                                @endforeach

                                @php
                                    $net_profit_loss = $f_dr_amt;
                                @endphp
                                @if ($net_profit_loss > 0)
                                    <tr>
                                        <td style="padding-bottom: 5px; font-weight:bold;">Retained Earnings </td>
                                        @php
                                            $net_profit = $net_profit_loss;
                                        @endphp
                                        <td
                                            style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;" style="text-align: right">
                                            {{ number_format(abs($net_profit_loss), 2) }}</td>
                                    </tr>
                                @endif


                                @if ($net_profit_loss < 0)
                                    <tr>
                                        <td style="padding-bottom: 5px; font-weight:bold; text-align: left;">Retained
                                            Earnings </td>
                                        @php
                                            $net_profit = $net_profit_loss;
                                        @endphp
                                        <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;text-align: right; "
                                            colspan="2">
                                            {{ '(' . number_format(abs($net_profit_loss), 2) . ')' }}</td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
