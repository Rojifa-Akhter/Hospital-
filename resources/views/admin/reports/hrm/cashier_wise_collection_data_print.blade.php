<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier Wise Collection Report</title>
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

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 15%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>


    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Cashier
                    Performance From <strong>{{ $from_date }}</strong> To <strong>{{ $to_date }}</strong>
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
                        <tr class="bg-primary">
                            <th class="text-center" style="text-align: center;">SL#</th>
                            <th class="text-center" style="text-align: center;">Date</th>
                            <th class="text-center" style="width: 20%; text-align: center;">Cashier</th>
                            <th class="text-center">Income Head</th>
                            <th class="text-center">No of Invoice</th>
                            <th class="text-right" style="text-align: right;">Sales</th>
                            <th class="text-right" style="text-align: right;">Discount</th>
                            <th class="text-right" style="text-align: right;">Net Sales</th>
                            <th class="text-right" style="text-align: right;">Collection</th>
                        </tr>

                        <div style="display: none">
                            {{ $total_no_of_invoice = 0 }}
                            {{ $total_sales = 0 }}
                            {{ $total_discount = 0 }}
                            {{ $total_net_sales = 0 }}
                            {{ $total_collection = 0 }}
                            @php
                                $date_count = 1;
                                $date_store = '';
                                $name_count = 1;
                                $name_store = '';
                            @endphp
                        </div>
                        @if (!empty($data))
                            @foreach ($data as $row)

                                <tr>
                                    <td class="text-center" style="text-align: center;">{{ $loop->iteration }}
                                    </td>

                                    @if ($date_store != date('d/m/Y', strtotime($row->invoice_date)) && $name_store != $row->full_name)
                                        <td style="text-align: center;">
                                            {{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                                        <td style="text-align: center;">{{ $row->full_name }}</td>
                                        @php
                                            $date_count = $date_count + 1;
                                            $date_store = date('d/m/Y', strtotime($row->invoice_date));

                                            $name_count = $name_count + 1;
                                            $name_store = $row->full_name;
                                        @endphp

                                        {{-- new --}}

                                    @elseif($date_store == date('d/m/Y', strtotime($row->invoice_date)) && $name_store != $row->full_name)
                                        <td></td>
                                        <td style="text-align: center;">{{ $row->full_name }}</td>

                                        @php
                                            $name_count = $name_count + 1;
                                            $name_store = $row->full_name;
                                        @endphp
                                        {{-- end --}}
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif

                                    <td class="text-center" style="text-align: center;">
                                        {{ !empty($row->item_type_name) ? $row->item_type_name : '' }}</td>
                                    <td class="text-center" style="text-align: center;">
                                        {{ !empty($row->invoice_count) ? $row->invoice_count : '' }}</td>
                                    <td class="text-right" style="text-align: right;">
                                        {{ !empty($row->ledger_amt_sales) ? number_format($row->ledger_amt_sales, 2) : number_format(0, 2) }}
                                    </td>
                                    <td class="text-right" style="text-align: right;">
                                        {{ !empty($row->ledger_amt_discount) ? number_format($row->ledger_amt_discount, 2) : number_format(0, 2) }}
                                    </td>
                                    <td class="text-right" style="text-align: right;">
                                        {{ !empty($row->net_sales) ? number_format($row->net_sales, 2) : number_format(0, 2) }}
                                    </td>
                                    <td class="text-right" style="text-align: right;">
                                        {{ !empty($row->collection) ? number_format($row->collection, 2) : number_format(0, 2) }}
                                    </td>

                                    <div style="display: none">{{ $total_no_of_invoice += $row->invoice_count }}
                                    </div>
                                    <div style="display: none">{{ $total_sales += $row->ledger_amt_sales }}</div>
                                    <div style="display: none">{{ $total_discount += $row->ledger_amt_discount }}
                                    </div>
                                    <div style="display: none">{{ $total_net_sales += $row->net_sales }}</div>
                                    <div style="display: none">{{ $total_collection += $row->collection }}</div>
                                </tr>

                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" style="text-align: right;" colspan="4">Total =</th>
                                <th class="text-center bg-light-blue">{{ $total_no_of_invoice }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_sales, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_discount, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_net_sales, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_collection, 2) }}</th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>


    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
