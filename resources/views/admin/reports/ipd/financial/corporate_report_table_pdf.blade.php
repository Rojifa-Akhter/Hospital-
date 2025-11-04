@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Corporate Financial Report</title>
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
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    Corporate Financial Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <div style="display: none">
                            {{ $total_amt = $total_refund = $total_net_amt = 0 }}

                        </div>

                        <thead class="bg-soft-green" style="margin-bottom: 10px">
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <td class="table-td" scope="col">
                                    <strong>SL</strong>
                                </td>
                                @if ($report_type == '')
                                    <td class="table-td" scope="col" style="text-align:center">
                                        <strong>Date</strong>
                                    </td>
                                    <td class="table-td" scope="col" style="text-align:center;">
                                        <strong>Patient Name</strong>
                                    </td>
                                @endif

                                <td class="table-td" scope="col" style="text-align:center;">
                                    <strong>Corporate Name</strong>
                                </td>
                                @if ($report_type == 'SUMMARY')
                                    <td class="table-td" scope="col" style="text-align:center;">
                                        <strong>
                                            Address
                                        </strong>
                                    </td>
                                @endif
                                <td class="table-td" scope="col" style="text-align:center;">
                                    <strong>Payable</strong>
                                </td>
                                {{-- <td class="table-td" scope="col" style="text-align:center">
                                    <strong>Discount</strong>
                                </td>
                                <td class="table-td" scope="col" style="text-align:center;">
                                    <strong>Net Payable</strong>
                                </td> --}}
                            </tr>

                        </thead>
                        <br>
                        <br>
                        <br>
                        <tbody>
                            @php
                                $total_sales = $total_discount = $total_net_payable = 0;
                                $counter = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $key => $row)
                                    <?php $counter = $counter + 1; ?>
                                    @if ($row->sales > 1)
                                        <tr>
                                            <td class="text-center global-uhl-table-bg">{{ $loop->iteration }}</td>
                                            @if ($report_type == '')
                                                <td class="text-left">
                                                    <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                                                </td>
                                                <td class="text-left">{{ $row->customer_name }}</td>
                                            @endif
                                            <td class="text-left">{{ $row->ccm_client_name }}</td>
                                            @if ($report_type == 'SUMMARY')
                                                <td class="text-left">{{ $row->client_address }}</td>
                                            @endif
                                            <td class="text-right global-uhl-table-bg" style="text-align: right">
                                                {{ number_format($row->sales, 2, '.', '') }}
                                            </td>
                                            {{-- <td class="text-right global-uhl-table-bg" style="text-align: right">
                                                {{ number_format($row->discount, 2, '.', '') }}</td>
                                            <td class="text-right global-uhl-table-bg" style="text-align: right">
                                                {{ number_format($row->payment, 2, '.', '') }}
                                            </td> --}}
                                        </tr>
                                        @php
                                            $total_sales += $row->sales;
                                            $total_discount += $row->discount;
                                            $total_net_payable += $row->payment;
                                        @endphp
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <th class="text-center" scope="col" colspan="15">No Data Available</th>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                @if ($report_type == '')
                                    <th class="text-right" scope="col" colspan="4" style="text-align: right">Total
                                        =
                                    </th>
                                @else
                                    <th class="text-right" scope="col" colspan="3" style="text-align: right">Total
                                        =
                                    </th>
                                @endif
                                <th scope="col" class="text-right global-uhl-table-bg" style="text-align: right">
                                    {{ number_format($total_sales, 2, '.', '') }}
                                </th>
                                {{-- <th scope="col" class="text-right global-uhl-table-bg" style="text-align: right">
                                    {{ number_format($total_discount, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right global-uhl-table-bg" style="text-align: right">
                                    {{ number_format($total_net_payable, 2, '.', '') }}</th> --}}
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
